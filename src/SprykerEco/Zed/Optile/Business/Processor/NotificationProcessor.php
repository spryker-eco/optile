<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optile\Business\Processor;

use Generated\Shared\Transfer\OptileNotificationRequestTransfer;
use Generated\Shared\Transfer\OptileNotificationResponseTransfer;
use Generated\Shared\Transfer\PaymentOptileTransfer;
use SprykerEco\Zed\Optile\Persistence\OptileEntityManagerInterface;

class NotificationProcessor implements NotificationProcessorInterface
{
    public const PAYMENT_NOTIFICATION_ENTITY_TYPE_KEY = 'payment';
    public const CUSTOMER_REGISTRATION_NOTIFICATION_TYPE_KEY = 'customer';

    public const CANCEL_NOTIFICATION_SUCCESS_STATUS_CODE = 'canceled';
    public const CHARGE_NOTIFICATION_SUCCESS_STATUS_CODE = 'preauthorized';
    public const CLOSE_NOTIFICATION_SUCCESS_STATUS_CODE = 'charged';
    public const CLOSE_NOTIFICATION_SUCCESS_REASON_CODE = 'debited';
    public const REFUND_NOTIFICATION_SUCCESS_STATUS_CODE = 'paid_out';
    public const REFUND_NOTIFICATION_SUCCESS_REASON_CODE = 'refund_credited';

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
        $this->saveRegistration($optileNotificationRequestTransfer);
        $this->saveChargeLongId($optileNotificationRequestTransfer);
        $this->saveRefundLongId($optileNotificationRequestTransfer);

        $this->optileEntityManager->saveNotification($optileNotificationRequestTransfer);

        return (new OptileNotificationResponseTransfer())->setIsSuccess(true);
    }

    /**
     * @param \Generated\Shared\Transfer\OptileNotificationRequestTransfer $optileNotificationRequestTransfer
     *
     * @return void
     */
    protected function saveRegistration(
        OptileNotificationRequestTransfer $optileNotificationRequestTransfer
    ): void {
        if ($optileNotificationRequestTransfer->getEntity() !== static::CUSTOMER_REGISTRATION_NOTIFICATION_TYPE_KEY) {
            return;
        }

        if (
            empty($optileNotificationRequestTransfer->getCustomerRegistrationHash())
            || empty($optileNotificationRequestTransfer->getCustomerRegistrationEmail())
            || empty($optileNotificationRequestTransfer->getCustomerRegistrationId())
        ) {
            return;
        }

        $this->optileEntityManager->saveRegistration($optileNotificationRequestTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\OptileNotificationRequestTransfer $optileNotificationRequestTransfer
     *
     * @return void
     */
    protected function saveChargeLongId(
        OptileNotificationRequestTransfer $optileNotificationRequestTransfer
    ): void {
        if ($optileNotificationRequestTransfer->getStatusCode() === static::CHARGE_NOTIFICATION_SUCCESS_STATUS_CODE) {
            $paymentOptileTransfer = (new PaymentOptileTransfer())
                ->setPaymentReference($optileNotificationRequestTransfer->getPaymentReference())
                ->setChargeLongId($optileNotificationRequestTransfer->getLongId());

            $this->optileEntityManager->savePaymentOptile($paymentOptileTransfer);
        }
    }

    /**
     * @param \Generated\Shared\Transfer\OptileNotificationRequestTransfer $optileNotificationRequestTransfer
     *
     * @return void
     */
    protected function saveRefundLongId(OptileNotificationRequestTransfer $optileNotificationRequestTransfer): void
    {
        if ($optileNotificationRequestTransfer->getReasonCode() === static::CLOSE_NOTIFICATION_SUCCESS_REASON_CODE) {
            $paymentOptileTransfer = (new PaymentOptileTransfer())
                ->setPaymentReference($optileNotificationRequestTransfer->getPaymentReference())
                ->setRefundLongId($optileNotificationRequestTransfer->getLongId());

            $this->optileEntityManager->savePaymentOptile($paymentOptileTransfer);
        }
    }
}
