<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optile\Business\Oms\Conditions;

use SprykerEco\Zed\Optile\Business\Processor\NotificationProcessor;
use SprykerEco\Zed\Optile\Persistence\OptileRepositoryInterface;

class IsOrderCanceledOmsCondition implements OmsConditionInterface
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
     * @param string $paymentReference
     *
     * @return bool
     */
    public function check(string $paymentReference): bool
    {
        $notificationTransfers = $this->optileRepository->getNotificationsByPaymentReference($paymentReference);

        foreach ($notificationTransfers as $notificationTransfer) {
            if (
                $notificationTransfer->getEntity() === NotificationProcessor::PAYMENT_NOTIFICATION_ENTITY_TYPE_KEY
                && $notificationTransfer->getStatusCode() === NotificationProcessor::CANCEL_NOTIFICATION_SUCCESS_STATUS_CODE
            ) {
                return true;
            }
        }

        return false;
    }
}
