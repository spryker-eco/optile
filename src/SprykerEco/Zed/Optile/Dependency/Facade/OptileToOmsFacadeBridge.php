<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optile\Dependency\Facade;

class OptileToOmsFacadeBridge implements OptileToOmsFacadeInterface
{
    /**
     * @var \Spryker\Zed\Oms\Business\OmsFacadeInterface
     */
    protected $omsFacade;

    /**
     * @param \Spryker\Zed\Oms\Business\OmsFacadeInterface $omsFacade
     */
    public function __construct($omsFacade)
    {
        $this->omsFacade = $omsFacade;
    }

    /**
     * @param string $eventId
     * @param array<int, mixed> $orderItemIds
     * @param array<string, mixed> $data
     *
     * @return array<string, mixed> |null
     */
    public function triggerEventForOrderItems(string $eventId, array $orderItemIds, array $data = [])
    {
        return $this->omsFacade->triggerEventForOrderItems($eventId, $orderItemIds, $data);
    }
}
