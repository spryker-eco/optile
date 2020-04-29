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
use Symfony\Component\HttpFoundation\Request;

class ListRequest implements RequestInterface
{
    protected const LISTS_URL_PATH = 'lists';

    /**
     * @var \GuzzleHttp\ClientInterface
     */
    protected $client;

    /**
     * @var \SprykerEco\Zed\Optile\OptileConfigInterface
     */
    protected $optileConfig;

    /**
     * @var \SprykerEco\Zed\Optile\Business\Writer\TransactionLogWriterInterface
     */
    protected $transactionLogWriter;

    /**
     * @var \SprykerEco\Zed\Optile\Business\Mapper\OptileRequestToTransactionLogInterface
     */
    protected $optileRequestToTransactionLog;

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
        $response = $this->client->request(Request::METHOD_POST, $optileRequestTransfer->getRequestUrl(), [
            'auth' => [
                $this->optileConfig->getMerchantCode(),
                $this->optileConfig->getPaymentToken(),
            ],
            'headers' => static::BASE_OPTILE_REQUEST_HEADERS,
            'json' => $this->optileRequestToTransactionLog->getPayload($optileRequestTransfer),
        ]);

        return $this->handleResponse($response, $optileRequestTransfer);
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param \Generated\Shared\Transfer\OptileRequestTransfer $optileRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileResponseTransfer
     */
    protected function handleResponse(ResponseInterface $response, OptileRequestTransfer $optileRequestTransfer)
    {
        $responseBody = $response->getBody();
        $responseData = json_decode($responseBody, true);
        $optileResponseTransfer = (new OptileResponseTransfer())
            ->setPaymentReference($optileRequestTransfer->getPaymentReference());

        $this->logOptileTransaction($response, $optileRequestTransfer);

        if ($response->getStatusCode() >= 300) {
            return $optileResponseTransfer->setError($responseBody)->setIsSuccess(false);
        }

        return $optileResponseTransfer
            ->setIsSuccess(true)
            ->setOperation($responseData['operation'])
            ->setLongId($responseData['identification']['longId'])
            ->setSelfLink($responseData['links']['self']);
    }

    protected function logOptileTransaction(ResponseInterface $response, OptileRequestTransfer $optileRequestTransfer)
    {
        $optileTransactionLogTransfer = $this->optileRequestToTransactionLog->map($optileRequestTransfer);
        $optileTransactionLogTransfer->setResponsePayload($response->getBody())
            ->setResponseCode($response->getStatusCode());

        $this->transactionLogWriter->saveTransactionLog($optileTransactionLogTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\OptileRequestTransfer $optileRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileRequestTransfer
     */
    protected function configureRequest(OptileRequestTransfer $optileRequestTransfer): OptileRequestTransfer
    {
        $optileRequestTransfer
            ->setIntegration($this->optileConfig->getIntegrationType())
            ->setCallbackNotificationUrl($this->optileConfig->getNotificationUrl())
            ->setCallbackSummaryUrl($this->optileConfig->getPaymentSummaryUrl())
            ->setCallbackCancelUrl('https://dev.oscato.com/shop/success.html')
            ->setRequestUrl($this->optileConfig->getBaseApiUrl() . '/' . static::LISTS_URL_PATH)
            ->setPresetFirst($this->optileConfig->isPresetEnabled());

        if (!$optileRequestTransfer->getCustomerScore()) {
            $optileRequestTransfer->setCustomerScore($this->optileConfig->getMax3dSecureScore());
        }

        return $optileRequestTransfer;
    }
}
