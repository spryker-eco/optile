<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Optile\Business\Processor;

use Generated\Shared\Transfer\OptileNotificationRequestTransfer;
use Generated\Shared\Transfer\OptileNotificationResponseTransfer;
use SprykerEco\Zed\Optile\Business\Writer\NotificationWriterInterface;

class NotificationProcessor implements NotificationProcessorInterface
{
    /**
     * @var \SprykerEco\Zed\Optile\Business\Writer\NotificationWriterInterface
     */
    protected $notificationWriter;

    /**
     * @param \SprykerEco\Zed\Optile\Business\Writer\NotificationWriterInterface $notificationWriter
     */
    public function __construct(NotificationWriterInterface $notificationWriter)
    {
        $this->notificationWriter = $notificationWriter;
    }

    /**
     * @param \Generated\Shared\Transfer\OptileNotificationRequestTransfer $optileNotificationRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileNotificationResponseTransfer
     */
    public function process(
        OptileNotificationRequestTransfer $optileNotificationRequestTransfer
    ): OptileNotificationResponseTransfer {
        $optileNotificationRequestTransfer = $this->notificationWriter->saveNotification(
            $optileNotificationRequestTransfer
        );

        return $this->createOptileNotificationResponse($optileNotificationRequestTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\OptileNotificationRequestTransfer $optileNotificationRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileNotificationResponseTransfer
     */
    protected function createOptileNotificationResponse(
        OptileNotificationRequestTransfer $optileNotificationRequestTransfer
    ): OptileNotificationResponseTransfer {
        return new OptileNotificationResponseTransfer();
    }
}
