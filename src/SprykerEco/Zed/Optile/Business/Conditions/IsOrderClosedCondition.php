<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optile\Business\Conditions;

use Generated\Shared\Transfer\PaymentOptileTransfer;
use SprykerEco\Zed\Optile\Business\Processor\NotificationProcessor;
use SprykerEco\Zed\Optile\Persistence\OptileRepositoryInterface;

class IsOrderClosedCondition implements ConditionInterface
{
    /**
     * @var \SprykerEco\Zed\Optile\Persistence\OptileRepositoryInterface
     */
    protected $optileRepository;

    /**
     * @param \SprykerEco\Zed\Optile\Persistence\OptileRepositoryInterface $optileRepository
     */
    public function __construct(OptileRepositoryInterface $optileRepository)
    {
        $this->optileRepository = $optileRepository;
    }

    /**
     * @param \Generated\Shared\Transfer\PaymentOptileTransfer $paymentOptileTransfer
     *
     * @return bool
     */
    public function check(PaymentOptileTransfer $paymentOptileTransfer): bool
    {
        $notificationTransfers = $this->optileRepository->findNotificationsByPaymentReference($paymentOptileTransfer);

        foreach ($notificationTransfers as $notificationTransfer) {
            if (
                $notificationTransfer->getEntity() === NotificationProcessor::PAYMENT_NOTIFICATION_ENTITY_TYPE_KEY
                && $notificationTransfer->getStatusCode() === NotificationProcessor::CLOSE_NOTIFICATION_SUCCESS_STATUS_CODE
            ) {
                return true;
            }
        }

        return false;
    }
}
