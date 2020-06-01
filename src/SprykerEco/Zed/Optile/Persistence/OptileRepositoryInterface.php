<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optile\Persistence;

use Generated\Shared\Transfer\OptileCustomerRegistrationTransfer;
use Generated\Shared\Transfer\OptileOrderItemRequestLogCriteriaTransfer;
use Generated\Shared\Transfer\OptileOrderItemRequestLogTransfer;
use Generated\Shared\Transfer\PaymentOptileTransfer;

interface OptileRepositoryInterface
{
    /**
     * @param int $salesOrderId
     *
     * @return \Generated\Shared\Transfer\PaymentOptileTransfer|null
     */
    public function findOptilePaymentByIdSalesOrder(int $salesOrderId): ?PaymentOptileTransfer;

    /**
     * @param string $email
     *
     * @return \Generated\Shared\Transfer\OptileCustomerRegistrationTransfer|null
     */
    public function findOptileCustomerRegistrationByEmail(string $email): ?OptileCustomerRegistrationTransfer;

    /**
     * @param \Generated\Shared\Transfer\OptileOrderItemRequestLogCriteriaTransfer $criteriaTransfer
     *
     * @return \Generated\Shared\Transfer\OptileOrderItemRequestLogTransfer|null
     */
    public function findOrderItemRequestLogByCriteria(
        OptileOrderItemRequestLogCriteriaTransfer $criteriaTransfer
    ): ?OptileOrderItemRequestLogTransfer;

    /**
     * @param string $paymentOptileTransfer
     *
     * @return \Generated\Shared\Transfer\OptileNotificationRequestTransfer[]
     */
    public function getNotificationsByPaymentReference(
        string $paymentOptileTransfer
    ): array;
}
