<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optile\Business;

use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Generated\Shared\Transfer\OptileNotificationRequestTransfer;
use Generated\Shared\Transfer\OptileNotificationResponseTransfer;
use Generated\Shared\Transfer\OptileOrderItemRequestLogCriteriaTransfer;
use Generated\Shared\Transfer\OptileOrderItemRequestLogTransfer;
use Generated\Shared\Transfer\OptileRequestTransfer;
use Generated\Shared\Transfer\OptileResponseTransfer;
use Generated\Shared\Transfer\PaymentOptileTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;

interface OptileFacadeInterface
{
    /**
     * Specification:
     * - Process external notification request based on the notification type.
     * - Saves notification request data.
     * - Returns response with result code.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\OptileNotificationRequestTransfer $optileNotificationRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileNotificationResponseTransfer
     */
    public function processNotificationRequest(
        OptileNotificationRequestTransfer $optileNotificationRequestTransfer
    ): OptileNotificationResponseTransfer;

    /**
     * Specification:
     * - Sends "List" request to the Optile api.
     * - Logs request and response to the transaction log table.
     * - Returns api response.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\OptileRequestTransfer $optileRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileResponseTransfer
     */
    public function makeListRequest(OptileRequestTransfer $optileRequestTransfer): OptileResponseTransfer;

    /**
     * Specification:
     * - Sends "Close" request to the Optile api.
     * - Logs request and response to the transaction log table.
     * - Returns api response.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\OptileRequestTransfer $optileRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileResponseTransfer
     */
    public function makeCloseRequest(OptileRequestTransfer $optileRequestTransfer): OptileResponseTransfer;

    /**
     * Specification:
     * - Sends "Cancel" request to the Optile api.
     * - Logs request and response to the transaction log table.
     * - Returns api response.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\OptileRequestTransfer $optileRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileResponseTransfer
     */
    public function makeCancelRequest(OptileRequestTransfer $optileRequestTransfer): OptileResponseTransfer;

    /**
     * Specification:
     * - Sends "Refund" request to the Optile api.
     * - Logs request and response to the transaction log table.
     * - Returns api response.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\OptileRequestTransfer $optileRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileResponseTransfer
     */
    public function makeRefundRequest(OptileRequestTransfer $optileRequestTransfer): OptileResponseTransfer;

    /**
     * Specification:
     * - Returns optile payment transfer by the foreign sales order id or null if not found.
     *
     * @api
     *
     * @param int $optileRequestTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentOptileTransfer|null
     */
    public function findOptilePaymentByIdSalesOrder(int $optileRequestTransfer): ?PaymentOptileTransfer;

    /**
     * Specification:
     * - Returns optile item request transfer by given criteria or null if not found.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\OptileOrderItemRequestLogCriteriaTransfer $criteriaTransfer
     *
     * @return \Generated\Shared\Transfer\OptileOrderItemRequestLogTransfer|null
     */
    public function findOrderItemRequestLogByCriteria(
        OptileOrderItemRequestLogCriteriaTransfer $criteriaTransfer
    ): ?OptileOrderItemRequestLogTransfer;

    /**
     * Specification:
     * - Creates payment optile entity in db.
     * - Fulfill payment optile entity with data from quote.
     * - Returns created optile payment transfer.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\SaveOrderTransfer $saveOrderTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentOptileTransfer
     */
    public function executeCheckoutDoSaveHook(
        QuoteTransfer $quoteTransfer,
        SaveOrderTransfer $saveOrderTransfer
    ): PaymentOptileTransfer;

    /**
     * Specification:
     * - Sends "Charge" request to the Optile api.
     * - Logs request and response to the transaction log table.
     * - Returns api response.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\CheckoutResponseTransfer $checkoutResponse
     *
     * @return void
     */
    public function executeOrderPostSaveHook(
        QuoteTransfer $quoteTransfer,
        CheckoutResponseTransfer $checkoutResponse
    ): void;

    /**
     * Specification:
     * - Finds charge notification by given reference
     * - Returns true if notification exists and has success status.
     * - Returns false otherwise.
     *
     * @api
     *
     * @param string $notificationReference
     *
     * @return bool
     */
    public function isOrderCharged(string $notificationReference): bool;

    /**
     * Specification:
     * - Checks is given order "canceled" notification.
     * - Returns "true" if notification exists and success or "false" otherwise.
     *
     * @api
     *
     * @param string $notificationReference
     *
     * @return bool
     */
    public function isOrderCanceled(string $notificationReference): bool;

    /**
     * Specification:
     * - Checks is given order "charged" notification.
     * - Returns "true" if notification exists and success or "false" otherwise.
     *
     * @api
     *
     * @param string $notificationReference
     *
     * @return bool
     */
    public function isOrderClosed(string $notificationReference): bool;

    /**
     * Specification:
     * - Checks is given order item has "refunded" notification.
     * - Returns "true" if notification exists and success or "false" otherwise.
     *
     * @api
     *
     * @param string $notificationReference
     *
     * @return bool
     */
    public function isOrderRefunded(string $notificationReference): bool;
}
