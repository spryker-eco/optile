<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optile\Business\Oms;

interface OmsAutomaticTriggerHandlerInterface
{
    /**
     * @param string $orderReference
     * @param string $event
     *
     * @return void
     */
    public function triggerOmsForRemainingItems(string $orderReference, string $event): void;
}
