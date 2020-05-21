<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optile\Business\Conditions;

use Generated\Shared\Transfer\PaymentOptileTransfer;

interface ConditionInterface
{
    /**
     * @param \Generated\Shared\Transfer\PaymentOptileTransfer $paymentOptileTransfer
     *
     * @return bool
     */
    public function check(PaymentOptileTransfer $paymentOptileTransfer): bool;
}
