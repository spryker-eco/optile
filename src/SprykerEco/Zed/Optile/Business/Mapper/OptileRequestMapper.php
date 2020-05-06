<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optile\Business\Mapper;

use Generated\Shared\Transfer\OptileRequestTransfer;
use Generated\Shared\Transfer\OptileTransactionLogTransfer;

class OptileRequestMapper implements OptileRequestMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\OptileRequestTransfer $optileRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileTransactionLogTransfer
     */
    public function mapOptileRequestToTransactionLog(
        OptileRequestTransfer $optileRequestTransfer
    ): OptileTransactionLogTransfer {
        return (new OptileTransactionLogTransfer())
            ->setRequestPayload(json_encode($optileRequestTransfer->getRequestPayload()))
            ->setRequestUrl($optileRequestTransfer->getRequestUrl())
            ->setPaymentReference($optileRequestTransfer->getPaymentReference());
    }
}