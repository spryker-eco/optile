<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optile\Persistence;

use Generated\Shared\Transfer\OptileNotificationRequestTransfer;
use Generated\Shared\Transfer\OptileTransactionLogTransfer;
use Generated\Shared\Transfer\PaymentOptileTransfer;

interface OptileEntityManagerInterface
{
    /**
     * Specification:
     *
     * @param \Generated\Shared\Transfer\OptileNotificationRequestTransfer $optileNotificationRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileNotificationRequestTransfer
     */
    public function saveNotification(
        OptileNotificationRequestTransfer $optileNotificationRequestTransfer
    ): OptileNotificationRequestTransfer;

    /**
     * @param \Generated\Shared\Transfer\OptileTransactionLogTransfer $optileNotificationRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileTransactionLogTransfer
     */
    public function saveTransactionLog(
        OptileTransactionLogTransfer $optileNotificationRequestTransfer
    ): OptileTransactionLogTransfer;

    /**
     * @param \Generated\Shared\Transfer\PaymentOptileTransfer $paymentOptileTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentOptileTransfer
     */
    public function savePaymentOptile(
        PaymentOptileTransfer $paymentOptileTransfer
    ): PaymentOptileTransfer;
}
