<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optile\Communication\Plugin\Checkout\Oms\Command;

use Generated\Shared\Transfer\OptileRequestTransfer;
use Orm\Zed\Sales\Persistence\SpySalesOrder;
use Spryker\Zed\Oms\Business\Util\ReadOnlyArrayObject;
use Spryker\Zed\Oms\Dependency\Plugin\Command\CommandByOrderInterface;

/**
 * @method \SprykerEco\Zed\Optile\Business\OptileFacadeInterface getFacade()
 * @method \SprykerEco\Zed\Optile\OptileConfig getConfig()
 */
class PaymentCancelPlugin extends AbstractOptilePaymentPlugin implements CommandByOrderInterface
{
    /**
     * {@inheritDoc}
     * - Finds optile payment.
     * - Makes Api call to cancel optile payment reservation.
     * - Logs transaction to DB.
     * - Triggers oms for remaining items.
     *
     * @api
     *
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem[] $orderItems
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $orderEntity
     * @param \Spryker\Zed\Oms\Business\Util\ReadOnlyArrayObject $data
     *
     * @return array
     */
    public function run(array $orderItems, SpySalesOrder $orderEntity, ReadOnlyArrayObject $data): array
    {
        if ($this->isAutomaticOmsTrigger($data)) {
            return [];
        }

        $optilePaymentTransfer = $this->getFacade()->findOptilePaymentByIdSalesOrder($orderEntity->getIdSalesOrder());

        $this->getFacade()->makeCancelRequest(
            (new OptileRequestTransfer())->setLongId($optilePaymentTransfer->getChargeLongId())
                ->setPaymentReference($optilePaymentTransfer->getPaymentReference())
                ->setSalesOrderReference($orderEntity->getOrderReference())
        );

        return [];
    }
}
