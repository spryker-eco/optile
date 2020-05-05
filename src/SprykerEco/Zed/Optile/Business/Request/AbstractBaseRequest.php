<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Optile\Business\Request;

use Generated\Shared\Transfer\OptileRequestTransfer;
use Generated\Shared\Transfer\OptileResponseTransfer;
use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use SprykerEco\Zed\Optile\Business\Mapper\OptileRequestToTransactionLogInterface;
use SprykerEco\Zed\Optile\Business\Writer\TransactionLogWriterInterface;
use SprykerEco\Zed\Optile\OptileConfigInterface;

abstract class AbstractBaseRequest implements RequestInterface
{
    protected const SUCCESS_RESPONSE_CODE = 'OK';

    /**
     * @var \SprykerEco\Zed\Optile\Business\Mapper\OptileRequestToTransactionLogInterface
     */
    protected $optileRequestToTransactionLog;

    /**
     * @var \SprykerEco\Zed\Optile\Business\Writer\TransactionLogWriterInterface
     */
    protected $transactionLogWriter;

    /**
     * @var \SprykerEco\Zed\Optile\OptileConfigInterface
     */
    protected $optileConfig;

    /**
     * @var \GuzzleHttp\ClientInterface
     */
    protected $client;

    /**
     * @param \GuzzleHttp\ClientInterface $client
     * @param \SprykerEco\Zed\Optile\OptileConfigInterface $optileConfig
     * @param \SprykerEco\Zed\Optile\Business\Writer\TransactionLogWriterInterface $transactionLogWriter
     * @param \SprykerEco\Zed\Optile\Business\Mapper\OptileRequestToTransactionLogInterface $optileRequestToTransactionLog
     */
    public function __construct(
        ClientInterface $client,
        OptileConfigInterface $optileConfig,
        TransactionLogWriterInterface $transactionLogWriter,
        OptileRequestToTransactionLogInterface $optileRequestToTransactionLog
    ) {
        $this->client = $client;
        $this->optileConfig = $optileConfig;
        $this->transactionLogWriter = $transactionLogWriter;
        $this->optileRequestToTransactionLog = $optileRequestToTransactionLog;
    }

    /**
     * @param \Generated\Shared\Transfer\OptileRequestTransfer $optileRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileResponseTransfer
     */
    public function request(OptileRequestTransfer $optileRequestTransfer): OptileResponseTransfer
    {
        $optileRequestTransfer = $this->configureRequest($optileRequestTransfer);

        $options =   [
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

        $response = $this->client->request(
            $this->getRequestMethod(),
            $optileRequestTransfer->getRequestUrl(),
            $options
        );

        $this->logOptileTransaction($response, $optileRequestTransfer);
        $responseData = json_decode($response->getBody(), true);

        if ($response->getStatusCode() >= 300 || $responseData['returnCode']['name'] != static::SUCCESS_RESPONSE_CODE) {
            return (new OptileResponseTransfer())
                ->setError($response->getBody())
                ->setIsSuccess(false)
                ->setPaymentReference($optileRequestTransfer->getPaymentReference());
        }

        return $this->handleResponse($responseData, $optileRequestTransfer);
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
        $optileTransactionLogTransfer = $this->optileRequestToTransactionLog->map($optileRequestTransfer);
        $optileTransactionLogTransfer->setResponsePayload($response->getBody())
            ->setResponseCode($response->getStatusCode());

        $this->transactionLogWriter->saveTransactionLog($optileTransactionLogTransfer);
    }

    /**
     * @return string
     */
    abstract protected function getRequestMethod(): string;

    /**
     * @param array $responseData
     * @param \Generated\Shared\Transfer\OptileRequestTransfer $optileRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileResponseTransfer
     */
    abstract protected function handleResponse(
        array $responseData,
        OptileRequestTransfer $optileRequestTransfer
    ): OptileResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\OptileRequestTransfer $optileRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileRequestTransfer
     */
    abstract protected function configureRequest(OptileRequestTransfer $optileRequestTransfer): OptileRequestTransfer;
}
