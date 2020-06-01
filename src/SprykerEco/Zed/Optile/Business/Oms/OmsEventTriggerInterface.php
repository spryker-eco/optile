<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optile\Business\Oms;

interface OmsEventTriggerInterface
{
    /**
     * @param string $orderReference
     * @param string $event
     *
     * @return void
     */
    public function triggerOmsEventForRemainingItems(string $orderReference, string $event): void;
}
