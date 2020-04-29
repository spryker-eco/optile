<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Optile\Business\Mapper;

use Generated\Shared\Transfer\OptileRequestTransfer;
use Generated\Shared\Transfer\OptileTransactionLogTransfer;

class OptileListsRequestToTransactionLog implements OptileRequestToTransactionLogInterface
{
    /**
     * @inheritDoc
     */
    public function map(OptileRequestTransfer $optileRequestTransfer): OptileTransactionLogTransfer
    {
        return (new OptileTransactionLogTransfer())
            ->setRequestPayload(json_encode($this->getPayload($optileRequestTransfer)))
            ->setRequestUrl($optileRequestTransfer->getRequestUrl())
            ->setPaymentReference($optileRequestTransfer->getPaymentReference());
    }

    /**
     * @param \Generated\Shared\Transfer\OptileRequestTransfer $optileRequestTransfer
     *
     * @return array
     */
    public function getPayload(OptileRequestTransfer $optileRequestTransfer): array
    {
        return [
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
        ];
    }
}
