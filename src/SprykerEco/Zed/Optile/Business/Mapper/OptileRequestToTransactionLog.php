<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Optile\Business\Mapper;

use Generated\Shared\Transfer\OptileRequestTransfer;
use Generated\Shared\Transfer\OptileTransactionLogTransfer;

class OptileRequestToTransactionLog implements OptileRequestToTransactionLogInterface
{
    /**
     * @inheritDoc
     */
    public function map(OptileRequestTransfer $optileRequestTransfer): OptileTransactionLogTransfer
    {
        return (new OptileTransactionLogTransfer())
            ->setRequestPayload(json_encode($optileRequestTransfer->getRequestPayload()))
            ->setRequestUrl($optileRequestTransfer->getRequestUrl())
            ->setPaymentReference($optileRequestTransfer->getPaymentReference())
            ->setFkSalesOrder($optileRequestTransfer->getFkSalesOrder());
    }
}
