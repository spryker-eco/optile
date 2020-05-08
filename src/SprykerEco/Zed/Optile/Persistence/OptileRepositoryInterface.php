<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optile\Persistence;

use Generated\Shared\Transfer\PaymentOptileTransfer;

interface OptileRepositoryInterface
{
    /**
     * @param int $salesOrderId
     *
     * @return \Generated\Shared\Transfer\PaymentOptileTransfer|null
     */
    public function findOptilePaymentByIdSalesOrder(int $salesOrderId): ?PaymentOptileTransfer;
}
