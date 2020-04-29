<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
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
