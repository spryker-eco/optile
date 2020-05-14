<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optile\Business\Writer;

use Generated\Shared\Transfer\OptileTransactionLogTransfer;
use SprykerEco\Zed\Optile\Persistence\OptileEntityManagerInterface;

class TransactionLogWriter implements TransactionLogWriterInterface
{
    /**
     * @var \SprykerEco\Zed\Optile\Persistence\OptileEntityManagerInterface
     */
    protected $optileEntityManager;

    /**
     * @param \SprykerEco\Zed\Optile\Persistence\OptileEntityManagerInterface $optileEntityManager
     */
    public function __construct(OptileEntityManagerInterface $optileEntityManager)
    {
        $this->optileEntityManager = $optileEntityManager;
    }

    /**
     * @param \Generated\Shared\Transfer\OptileTransactionLogTransfer $optileNotificationRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileTransactionLogTransfer
     */
    public function saveTransactionLog(
        OptileTransactionLogTransfer $optileNotificationRequestTransfer
    ): OptileTransactionLogTransfer {
        return $this->optileEntityManager->saveTransactionLog($optileNotificationRequestTransfer);
    }
}
