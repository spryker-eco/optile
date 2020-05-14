<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optile\Business\Writer;

use Generated\Shared\Transfer\OptileTransactionLogTransfer;

interface TransactionLogWriterInterface
{
    /**
     * @param \Generated\Shared\Transfer\OptileTransactionLogTransfer $optileNotificationRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileTransactionLogTransfer
     */
    public function saveTransactionLog(
        OptileTransactionLogTransfer $optileNotificationRequestTransfer
    ): OptileTransactionLogTransfer;
}
