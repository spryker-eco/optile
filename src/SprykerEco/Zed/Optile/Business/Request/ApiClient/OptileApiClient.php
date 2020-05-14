<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optile\Business\Request\ApiClient;

use Generated\Shared\Transfer\OptileRequestTransfer;
use Generated\Shared\Transfer\OptileResponseTransfer;
use Psr\Http\Message\ResponseInterface;
use SprykerEco\Zed\Optile\Business\HttpClient\Exception\OptileHttpRequestException;
use SprykerEco\Zed\Optile\Business\HttpClient\OptileHttpClientInterface;
use SprykerEco\Zed\Optile\Business\Mapper\OptileRequestMapperInterface;
use SprykerEco\Zed\Optile\Business\Request\OptileApiRequestInterface;
use SprykerEco\Zed\Optile\Business\Writer\TransactionLogWriterInterface;
use SprykerEco\Zed\Optile\Dependency\Service\OptileToUtilEncodingServiceInterface;
use SprykerEco\Zed\Optile\OptileConfig;

class OptileApiClient implements OptileApiClientInterface
{
    protected const SUCCESS_RESPONSE_CODE = 'OK';
    protected const BASE_OPTILE_REQUEST_HEADERS = [
        'Content-Type' => 'application/vnd.optile.payment.enterprise-v1-extensible+json',
        'Accept' => 'application/vnd.optile.payment.enterprise-v1-extensible+json',
    ];

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
     * @var \SprykerEco\Zed\Optile\Business\Request\OptileApiRequestInterface
     */
    protected $optileApiRequest;

    /**
     * @var \SprykerEco\Zed\Optile\Dependency\Service\OptileToUtilEncodingServiceInterface
     */
    protected $utilEncodingService;

    /**
     * @param \SprykerEco\Zed\Optile\Business\HttpClient\OptileHttpClientInterface $optileHttpClient
     * @param \SprykerEco\Zed\Optile\OptileConfig $optileConfig
     * @param \SprykerEco\Zed\Optile\Business\Writer\TransactionLogWriterInterface $transactionLogWriter
     * @param \SprykerEco\Zed\Optile\Business\Mapper\OptileRequestMapperInterface $optileRequestToTransactionLog
     * @param \SprykerEco\Zed\Optile\Business\Request\OptileApiRequestInterface $optileApiRequest
     * @param \SprykerEco\Zed\Optile\Dependency\Service\OptileToUtilEncodingServiceInterface $utilEncodingService
     */
    public function __construct(
        OptileHttpClientInterface $optileHttpClient,
        OptileConfig $optileConfig,
        TransactionLogWriterInterface $transactionLogWriter,
        OptileRequestMapperInterface $optileRequestToTransactionLog,
        OptileApiRequestInterface $optileApiRequest,
        OptileToUtilEncodingServiceInterface $utilEncodingService
    ) {
        $this->optileHttpClient = $optileHttpClient;
        $this->optileConfig = $optileConfig;
        $this->transactionLogWriter = $transactionLogWriter;
        $this->optileRequestToTransactionLog = $optileRequestToTransactionLog;
        $this->optileApiRequest = $optileApiRequest;
        $this->utilEncodingService = $utilEncodingService;
    }

    /**
     * @param \Generated\Shared\Transfer\OptileRequestTransfer $optileRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileResponseTransfer
     */
    public function request(OptileRequestTransfer $optileRequestTransfer): OptileResponseTransfer
    {
        $optileRequestTransfer = $this->optileApiRequest->configureRequest($optileRequestTransfer);
        $options = $this->buildRequestOptions($optileRequestTransfer);
        $optileResponseTransfer = (new OptileResponseTransfer())->setIsSuccess(false);

        try {
            $response = $this->optileHttpClient->request(
                $this->optileApiRequest->getRequestMethod(),
                $optileRequestTransfer->getRequestUrl(),
                $options
            );
        } catch (OptileHttpRequestException $exception) {
            return $optileResponseTransfer->setError($exception->getMessage());
        }

        $this->logOptileTransaction($response, $optileRequestTransfer);
        $responseData = $this->utilEncodingService->decodeJson($response->getBody(), true);

        if (
            empty($responseData['returnCode']['name'])
            || $responseData['returnCode']['name'] != static::SUCCESS_RESPONSE_CODE
        ) {
            return $optileResponseTransfer->setError($response->getBody());
        }

        return $this->optileApiRequest->handleResponse($responseData, $optileRequestTransfer);
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
