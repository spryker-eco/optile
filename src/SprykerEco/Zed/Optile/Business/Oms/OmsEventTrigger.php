<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optile\Business\Oms;

use Generated\Shared\Transfer\OrderItemFilterTransfer;
use SprykerEco\Zed\Optile\Dependency\Facade\OptileToOmsFacadeInterface;
use SprykerEco\Zed\Optile\Dependency\Facade\OptileToSalesFacadeInterface;
use SprykerEco\Zed\Optile\OptileConfig;

class OmsEventTrigger implements OmsEventTriggerInterface
{
    /**
     * @var \SprykerEco\Zed\Optile\OptileConfig
     */
    protected $optileConfig;

    /**
     * @var \SprykerEco\Zed\Optile\Dependency\Facade\OptileToSalesFacadeInterface
     */
    protected $salesFacade;

    /**
     * @var \SprykerEco\Zed\Optile\Dependency\Facade\OptileToOmsFacadeInterface
     */
    protected $omsFacade;

    /**
     * @param \SprykerEco\Zed\Optile\OptileConfig $optileConfig
     * @param \SprykerEco\Zed\Optile\Dependency\Facade\OptileToSalesFacadeInterface $salesFacade
     * @param \SprykerEco\Zed\Optile\Dependency\Facade\OptileToOmsFacadeInterface $omsFacade
     */
    public function __construct(
        OptileConfig $optileConfig,
        OptileToSalesFacadeInterface $salesFacade,
        OptileToOmsFacadeInterface $omsFacade
    ) {
        $this->optileConfig = $optileConfig;
        $this->salesFacade = $salesFacade;
        $this->omsFacade = $omsFacade;
    }

    /**
     * @param string $orderReference
     * @param string $event
     *
     * @return void
     */
    public function triggerOmsEventForRemainingItems(string $orderReference, string $event): void
    {
        $orderItemsId = [];

        $orderItemCollectionTransfer = $this->salesFacade->getOrderItems(
            (new OrderItemFilterTransfer())->setOrderReferences([$orderReference])
        );

        foreach ($orderItemCollectionTransfer->getItems() as $item) {
            $orderItemsId[] = $item->getIdSalesOrderItem();
        }

        $this->omsFacade->triggerEventForOrderItems(
            $event,
            $orderItemsId,
            [$this->optileConfig->getOptileAutomaticOmsTrigger() => true]
        );
    }
}
