<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optile\Business\Reader;

use Generated\Shared\Transfer\PaymentOptileTransfer;

interface PaymentOptileReaderInterface
{
    /**
     * @param int $optileRequestTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentOptileTransfer|null
     */
    public function findOptilePaymentByIdSalesOrder(int $optileRequestTransfer): ?PaymentOptileTransfer;
}
