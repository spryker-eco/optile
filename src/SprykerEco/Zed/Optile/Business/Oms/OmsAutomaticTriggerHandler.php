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

class OmsAutomaticTriggerHandler implements OmsAutomaticTriggerHandlerInterface
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
    protected $optileToOmsFacade;

    /**
     * @param \SprykerEco\Zed\Optile\OptileConfig $optileConfig
     * @param \SprykerEco\Zed\Optile\Dependency\Facade\OptileToSalesFacadeInterface $salesFacade
     * @param \SprykerEco\Zed\Optile\Dependency\Facade\OptileToOmsFacadeInterface $optileToOmsFacade
     */
    public function __construct(
        OptileConfig $optileConfig,
        OptileToSalesFacadeInterface $salesFacade,
        OptileToOmsFacadeInterface $optileToOmsFacade
    ) {
        $this->optileConfig = $optileConfig;
        $this->salesFacade = $salesFacade;
        $this->optileToOmsFacade = $optileToOmsFacade;
    }

    /**
     * @param string $orderReference
     * @param string $event
     *
     * @return void
     */
    public function triggerOmsForRemainingItems(string $orderReference, string $event): void
    {
        $orderItemsId = [];

        $orderItemCollectionTransfer = $this->salesFacade->getOrderItems(
            (new OrderItemFilterTransfer())->setOrderReferences([$orderReference])
        );

        foreach ($orderItemCollectionTransfer->getItems() as $item) {
            $orderItemsId[] = $item->getIdSalesOrderItem();
        }

        $this->optileToOmsFacade->triggerEventForOrderItems(
            $event,
            $orderItemsId,
            [$this->optileConfig->getOptileAutomaticOmsTrigger() => true]
        );
    }
}
