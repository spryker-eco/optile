<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optile\Business\Oms\Conditions;

interface OmsConditionInterface
{
    /**
     * @param string $paymentReference
     *
     * @return bool
     */
    public function check(string $paymentReference): bool;
}
