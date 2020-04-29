<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Optile\Business\Writer;

use Generated\Shared\Transfer\OptileNotificationRequestTransfer;
use Spryker\Zed\Optile\Persistence\OptileEntityManagerInterface;

class NotificationWriter implements NotificationWriterInterface
{
    /**
     * @var \Spryker\Zed\Optile\Persistence\OptileEntityManagerInterface
     */
    protected $optileEntityManager;

    /**
     * @param \Spryker\Zed\Optile\Persistence\OptileEntityManagerInterface $optileEntityManager
     */
    public function __construct(OptileEntityManagerInterface $optileEntityManager)
    {
        $this->optileEntityManager = $optileEntityManager;
    }

    /**
     * @param \Generated\Shared\Transfer\OptileNotificationRequestTransfer $optileNotificationRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileNotificationRequestTransfer
     */
    public function saveNotification(
        OptileNotificationRequestTransfer $optileNotificationRequestTransfer
    ): OptileNotificationRequestTransfer {
        return $this->optileEntityManager->saveNotification($optileNotificationRequestTransfer);
    }
}
