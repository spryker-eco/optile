<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Optile\Business\Request;

use Generated\Shared\Transfer\OptileRequestTransfer;
use Generated\Shared\Transfer\OptileResponseTransfer;
use Symfony\Component\HttpFoundation\Request;

class ListRequest extends AbstractBaseRequest
{
    protected const LISTS_URL_PATH = '/lists';

    /**
     * @param array $responseData
     * @param \Generated\Shared\Transfer\OptileRequestTransfer $optileRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileResponseTransfer
     */
    protected function handleResponse(
        array $responseData,
        OptileRequestTransfer $optileRequestTransfer
    ): OptileResponseTransfer {
        return (new OptileResponseTransfer())
            ->setPaymentReference($optileRequestTransfer->getPaymentReference())
            ->setIsSuccess(true)
            ->setOperation($responseData['operation'])
            ->setLongId($responseData['identification']['longId'])
            ->setSelfLink($responseData['links']['self']);
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
            ->setRequestUrl($this->optileConfig->getBaseApiUrl() . static::LISTS_URL_PATH)
            ->setPresetFirst($this->optileConfig->isPresetEnabled());

        if (!$optileRequestTransfer->getCustomerScore()) {
            $optileRequestTransfer->setCustomerScore($this->optileConfig->getMax3dSecureScore());
        }

        $this->prepareRequestBody($optileRequestTransfer);

        return $optileRequestTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\OptileRequestTransfer $optileRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileRequestTransfer
     */
    protected function prepareRequestBody(OptileRequestTransfer $optileRequestTransfer): OptileRequestTransfer
    {
        return $optileRequestTransfer->setRequestPayload([
            'transactionId' => $optileRequestTransfer->getTransactionId(),
            'integration' => $optileRequestTransfer->getIntegration(),
            'presetFirst' => $optileRequestTransfer->getPresetFirst(),
            'country' => $optileRequestTransfer->getCountry(),
            'customer' => [
                'number' => $optileRequestTransfer->getIdCustomer(),
                'email' => $optileRequestTransfer->getCustomerEmail(),
            ],
            'payment' => [
                'amount' => $optileRequestTransfer->getPaymentAmount(),
                'currency' => $optileRequestTransfer->getPaymentCurrency(),
                'reference' => $optileRequestTransfer->getPaymentReference(),
            ],
            'callback' => [
                'returnUrl' => $optileRequestTransfer->getCallbackSummaryUrl(),
                'cancelUrl' => $optileRequestTransfer->getCallbackCancelUrl(),
                'summaryUrl' => $optileRequestTransfer->getCallbackSummaryUrl(),
                'notificationUrl' => $optileRequestTransfer->getCallbackNotificationUrl(),
            ],
        ]);
    }

    /**
     * @return string
     */
    protected function getRequestMethod(): string
    {
        return Request::METHOD_POST;
    }
}
