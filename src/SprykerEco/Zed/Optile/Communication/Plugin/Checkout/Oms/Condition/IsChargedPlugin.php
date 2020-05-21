<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optile\Communication\Plugin\Checkout\Oms\Condition;

use Orm\Zed\Sales\Persistence\SpySalesOrderItem;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\Oms\Dependency\Plugin\Condition\ConditionInterface;

/**
 * @method \SprykerEco\Zed\Optile\Business\OptileFacadeInterface getFacade()
 * @method \SprykerEco\Zed\Optile\OptileConfig getConfig()
 */
class IsChargedPlugin extends AbstractPlugin implements ConditionInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem $orderItem
     *
     * @return bool
     */
    public function check(SpySalesOrderItem $orderItem)
    {
        $optilePaymentTransfer = $this->getFacade()->findOptilePaymentByIdSalesOrder($orderItem->getFkSalesOrder());

        return $this->getFacade()->isOrderCharged($optilePaymentTransfer);
    }
}