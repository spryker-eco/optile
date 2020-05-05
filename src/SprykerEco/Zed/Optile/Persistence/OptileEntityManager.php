<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Optile\Persistence;

use Generated\Shared\Transfer\OptileNotificationRequestTransfer;
use Generated\Shared\Transfer\OptileTransactionLogTransfer;
use Generated\Shared\Transfer\PaymentOptileTransfer;
use Orm\Zed\Optile\Persistence\SpyPaymentOptile;
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
        $spyNotification = $this->getFactory()
            ->createOptileNotificationQuery()
            ->filterByNotificationId($optileNotificationRequestTransfer->getNotificationId())
            ->findOneOrCreate();

        $spyNotification = $this->getFactory()
            ->createPropelNotificationRequestMapper()
            ->mapNotificationRequestTransferToEntity($optileNotificationRequestTransfer, $spyNotification);

        $spyNotification->save();

        $optileNotificationRequestTransfer->setIdPaymentOptileNotification(
            $spyNotification->getIdPaymentOptileNotification()
        );

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
            ->createPaymentOptileMapper()
            ->mapPaymentOptileTransferToEntity($paymentOptileTransfer, new SpyPaymentOptile());

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
}
