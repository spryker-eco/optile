<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optile\Business\Request\ApiClient;

use Generated\Shared\Transfer\OptileRequestTransfer;
use Generated\Shared\Transfer\OptileResponseTransfer;
use Psr\Http\Message\ResponseInterface;
use Spryker\Service\UtilEncoding\UtilEncodingServiceInterface;
use SprykerEco\Zed\Optile\Business\HttpClient\Exception\OptileHttpRequestException;
use SprykerEco\Zed\Optile\Business\HttpClient\OptileHttpClientInterface;
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
     * @var \SprykerEco\Zed\Optile\Business\HttpClient\OptileHttpClientInterface
     */
    protected $optileHttpClient;

    /**
     * @var \SprykerEco\Zed\Optile\Business\Request\RequestInterface
     */
    protected $request;

    /**
     * @var \Spryker\Service\UtilEncoding\UtilEncodingServiceInterface
     */
    protected $utilEncoding;

    /**
     * @param \SprykerEco\Zed\Optile\Business\HttpClient\OptileHttpClientInterface $optileHttpClient
     * @param \SprykerEco\Zed\Optile\OptileConfig $optileConfig
     * @param \SprykerEco\Zed\Optile\Business\Writer\TransactionLogWriterInterface $transactionLogWriter
     * @param \SprykerEco\Zed\Optile\Business\Mapper\OptileRequestMapperInterface $optileRequestToTransactionLog
     * @param \SprykerEco\Zed\Optile\Business\Request\RequestInterface $request
     * @param \Spryker\Service\UtilEncoding\UtilEncodingServiceInterface $utilEncoding
     */
    public function __construct(
        OptileHttpClientInterface $optileHttpClient,
        OptileConfig $optileConfig,
        TransactionLogWriterInterface $transactionLogWriter,
        OptileRequestMapperInterface $optileRequestToTransactionLog,
        RequestInterface $request,
        UtilEncodingServiceInterface $utilEncoding
    ) {
        $this->optileHttpClient = $optileHttpClient;
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
        $options = $this->buildRequestOptions($optileRequestTransfer);
        $optileResponseTransfer = (new OptileResponseTransfer())->setIsSuccess(false);

        try {
            $response = $this->optileHttpClient->request(
                $this->request->getRequestMethod(),
                $optileRequestTransfer->getRequestUrl(),
                $options
            );
        } catch (OptileHttpRequestException $exception) {
            return $optileResponseTransfer->setError($exception->getMessage());
        }

        $this->logOptileTransaction($response, $optileRequestTransfer);
        $responseData = $this->utilEncoding->decodeJson($response->getBody(), true);

        if ($responseData['returnCode']['name'] != static::SUCCESS_RESPONSE_CODE) {
            return $optileResponseTransfer->setError($response->getBody());
        }

        return $this->request->handleResponse($responseData, $optileRequestTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\OptileRequestTransfer $optileRequestTransfer
     *
     * @return array
     */
    protected function buildRequestOptions(OptileRequestTransfer $optileRequestTransfer): array
    {
        $options = [
            'auth' => [
                $this->optileConfig->getMerchantCode(),
                $this->optileConfig->getPaymentToken(),
            ],
            'headers' => static::BASE_OPTILE_REQUEST_HEADERS,
        ];

        if (empty($optileRequestTransfer->getRequestPayload())) {
            $options['body'] = '{}';

            return $options;
        }

        $options['json'] = $optileRequestTransfer->getRequestPayload();

        return $options;
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
