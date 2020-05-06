<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optile\Business\Processor;

use Generated\Shared\Transfer\OptileNotificationRequestTransfer;
use Generated\Shared\Transfer\OptileNotificationResponseTransfer;
use SprykerEco\Zed\Optile\Persistence\OptileEntityManagerInterface;

class NotificationProcessor implements NotificationProcessorInterface
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
     * @param \Generated\Shared\Transfer\OptileNotificationRequestTransfer $optileNotificationRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileNotificationResponseTransfer
     */
    public function process(
        OptileNotificationRequestTransfer $optileNotificationRequestTransfer
    ): OptileNotificationResponseTransfer {
        $this->optileEntityManager->saveNotification($optileNotificationRequestTransfer);

        return (new OptileNotificationResponseTransfer())->setIsSuccess(true);
    }
}
