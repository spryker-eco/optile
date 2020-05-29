<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optile\Persistence;

use Generated\Shared\Transfer\OptileNotificationRequestTransfer;
use Generated\Shared\Transfer\OptileOrderItemRequestLogTransfer;
use Generated\Shared\Transfer\OptileTransactionLogTransfer;
use Generated\Shared\Transfer\PaymentOptileTransfer;
use Orm\Zed\Optile\Persistence\SpyPaymentOptileNotification;
use Orm\Zed\Optile\Persistence\SpyPaymentOptileOrderItemRequestLog;
use Orm\Zed\Optile\Persistence\SpyPaymentOptileRegistration;
use Orm\Zed\Optile\Persistence\SpyPaymentOptileTransactionLog;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;

/**
 * @method \SprykerEco\Zed\Optile\Persistence\OptilePersistenceFactory getFactory()
 */
class OptileEntityManager extends AbstractEntityManager implements OptileEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\OptileNotificationRequestTransfer $optileNotificationRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileNotificationRequestTransfer
     */
    public function saveNotification(
        OptileNotificationRequestTransfer $optileNotificationRequestTransfer
    ): OptileNotificationRequestTransfer {
        $spyNotification = new SpyPaymentOptileNotification();

        $spyNotification->fromArray(
            $optileNotificationRequestTransfer->modifiedToArray(false)
        );

        $spyNotification->save();

        $optileNotificationRequestTransfer->setIdPaymentOptileNotification(
            $spyNotification->getIdPaymentOptileNotification()
        );

        return $optileNotificationRequestTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\OptileNotificationRequestTransfer $optileNotificationRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileNotificationRequestTransfer
     */
    public function saveRegistration(
        OptileNotificationRequestTransfer $optileNotificationRequestTransfer
    ): OptileNotificationRequestTransfer {
        $paymentOptileRegistrationEntity = new SpyPaymentOptileRegistration();

        $paymentOptileRegistrationEntity->fromArray(
            $optileNotificationRequestTransfer->modifiedToArray(false)
        );

        $paymentOptileRegistrationEntity->save();

        return $optileNotificationRequestTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\PaymentOptileTransfer $paymentOptileTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentOptileTransfer
     */
    public function savePaymentOptile(
        PaymentOptileTransfer $paymentOptileTransfer
    ): PaymentOptileTransfer {
        $spyPaymentOptile = $this->getFactory()
            ->createOptilePaymentQuery()
            ->filterByPaymentReference($paymentOptileTransfer->getPaymentReference())
            ->findOneOrCreate();

        $spyPaymentOptile->fromArray(
            $paymentOptileTransfer->modifiedToArray(false)
        );

        $spyPaymentOptile->save();

        $paymentOptileTransfer->setIdPaymentOptile(
            $spyPaymentOptile->getIdPaymentOptile()
        );

        return $paymentOptileTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\OptileTransactionLogTransfer $optileTransactionLogTransfer
     *
     * @return \Generated\Shared\Transfer\OptileTransactionLogTransfer
     */
    public function saveTransactionLog(
        OptileTransactionLogTransfer $optileTransactionLogTransfer
    ): OptileTransactionLogTransfer {
        $spyTransactionLog = new SpyPaymentOptileTransactionLog();

        $spyTransactionLog->fromArray($optileTransactionLogTransfer->toArray());
        $spyTransactionLog->save();

        $optileTransactionLogTransfer->setIdPaymentOptileTransactionId(
            $spyTransactionLog->getIdPaymentOptileTransactionLog()
        );

        return $optileTransactionLogTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\OptileOrderItemRequestLogTransfer $optileOrderItemRequestLogTransfer
     *
     * @return \Generated\Shared\Transfer\OptileOrderItemRequestLogTransfer
     */
    public function saveOrderItemRequestLog(
        OptileOrderItemRequestLogTransfer $optileOrderItemRequestLogTransfer
    ): OptileOrderItemRequestLogTransfer {
        $spyOptileOrderItemRequestLogEntity = new SpyPaymentOptileOrderItemRequestLog();

        $spyOptileOrderItemRequestLogEntity->fromArray($optileOrderItemRequestLogTransfer->toArray());
        $spyOptileOrderItemRequestLogEntity->save();

        $optileOrderItemRequestLogTransfer->setIdPaymentOptileOrderItemRequestLog(
            $spyOptileOrderItemRequestLogEntity->getIdSpyPaymentOptileOrderItemRequestLog()
        );

        return $optileOrderItemRequestLogTransfer;
    }
}
