<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optile\Business\Request\ApiClient;

use Generated\Shared\Transfer\OptileRequestTransfer;
use Generated\Shared\Transfer\OptileResponseTransfer;
use GuzzleHttp\ClientInterface as GuzzleHttpClientInterface;
use Psr\Http\Message\ResponseInterface;
use Spryker\Service\UtilEncoding\UtilEncodingServiceInterface;
use SprykerEco\Zed\Optile\Business\Mapper\OptileRequestMapperInterface;
use SprykerEco\Zed\Optile\Business\Request\RequestInterface;
use SprykerEco\Zed\Optile\Business\Writer\TransactionLogWriterInterface;
use SprykerEco\Zed\Optile\OptileConfig;

class Client implements ClientInterface
{
    protected const SUCCESS_RESPONSE_CODE = 'OK';

    /**
     * @var \SprykerEco\Zed\Optile\Business\Mapper\OptileRequestMapperInterface
     */
    protected $optileRequestToTransactionLog;

    /**
     * @var \SprykerEco\Zed\Optile\Business\Writer\TransactionLogWriterInterface
     */
    protected $transactionLogWriter;

    /**
     * @var \SprykerEco\Zed\Optile\OptileConfig
     */
    protected $optileConfig;

    /**
     * @var \GuzzleHttp\ClientInterface
     */
    protected $guzzleHttpClient;

    /**
     * @var \SprykerEco\Zed\Optile\Business\Request\RequestInterface
     */
    protected $request;

    /**
     * @var \Spryker\Service\UtilEncoding\UtilEncodingServiceInterface
     */
    protected $utilEncoding;

    /**
     * @param \GuzzleHttp\ClientInterface $guzzleHttpClient
     * @param \SprykerEco\Zed\Optile\OptileConfig $optileConfig
     * @param \SprykerEco\Zed\Optile\Business\Writer\TransactionLogWriterInterface $transactionLogWriter
     * @param \SprykerEco\Zed\Optile\Business\Mapper\OptileRequestMapperInterface $optileRequestToTransactionLog
     * @param \SprykerEco\Zed\Optile\Business\Request\RequestInterface $request
     * @param \Spryker\Service\UtilEncoding\UtilEncodingServiceInterface $utilEncoding
     */
    public function __construct(
        GuzzleHttpClientInterface $guzzleHttpClient,
        OptileConfig $optileConfig,
        TransactionLogWriterInterface $transactionLogWriter,
        OptileRequestMapperInterface $optileRequestToTransactionLog,
        RequestInterface $request,
        UtilEncodingServiceInterface $utilEncoding
    ) {
        $this->guzzleHttpClient = $guzzleHttpClient;
        $this->optileConfig = $optileConfig;
        $this->transactionLogWriter = $transactionLogWriter;
        $this->optileRequestToTransactionLog = $optileRequestToTransactionLog;
        $this->request = $request;
        $this->utilEncoding = $utilEncoding;
    }

    /**
     * @param \Generated\Shared\Transfer\OptileRequestTransfer $optileRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileResponseTransfer
     */
    public function request(OptileRequestTransfer $optileRequestTransfer): OptileResponseTransfer
    {
        $optileRequestTransfer = $this->request->configureRequest($optileRequestTransfer);

        $options = [
            'auth' => [
                $this->optileConfig->getMerchantCode(),
                $this->optileConfig->getPaymentToken(),
            ],
            'headers' => static::BASE_OPTILE_REQUEST_HEADERS,
        ];

        if (empty($optileRequestTransfer->getRequestPayload())) {
            $options['body'] = '{}';
        } else {
            $options['json'] = $optileRequestTransfer->getRequestPayload();
        }

        $response = $this->guzzleHttpClient->request(
            $this->request->getRequestMethod(),
            $optileRequestTransfer->getRequestUrl(),
            $options
        );

        $this->logOptileTransaction($response, $optileRequestTransfer);
        $responseData = $this->utilEncoding->decodeJson($response->getBody(), true);

        if ($response->getStatusCode() >= 300 || $responseData['returnCode']['name'] != static::SUCCESS_RESPONSE_CODE) {
            return (new OptileResponseTransfer())
                ->setError($response->getBody())
                ->setIsSuccess(false)
                ->setPaymentReference($optileRequestTransfer->getPaymentReference());
        }

        return $this->request->handleResponse($responseData, $optileRequestTransfer);
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param \Generated\Shared\Transfer\OptileRequestTransfer $optileRequestTransfer
     *
     * @return void
     */
    protected function logOptileTransaction(
        ResponseInterface $response,
        OptileRequestTransfer $optileRequestTransfer
    ): void {
        $optileTransactionLogTransfer = $this->optileRequestToTransactionLog
            ->mapOptileRequestToTransactionLog($optileRequestTransfer);

        $optileTransactionLogTransfer->setResponsePayload($response->getBody())
            ->setResponseCode($response->getStatusCode());

        $this->transactionLogWriter->saveTransactionLog($optileTransactionLogTransfer);
    }
}