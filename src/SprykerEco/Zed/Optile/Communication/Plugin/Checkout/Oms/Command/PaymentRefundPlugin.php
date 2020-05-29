<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optile\Communication\Plugin\Checkout\Oms\Command;

use Generated\Shared\Transfer\OptileRequestTransfer;
use Orm\Zed\Sales\Persistence\SpySalesOrder;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\Oms\Business\Util\ReadOnlyArrayObject;
use Spryker\Zed\Oms\Dependency\Plugin\Command\CommandByOrderInterface;

/**
 * @method \SprykerEco\Zed\Optile\Business\OptileFacadeInterface getFacade()
 * @method \SprykerEco\Zed\Optile\OptileConfig getConfig()
 */
class PaymentRefundPlugin extends AbstractPlugin implements CommandByOrderInterface
{
    /**
     * {@inheritDoc}
     * - Finds optile payment.
     * - Makes Api call to close optile payment.
     * - Logs transaction to DB.
     * - Creates optile items request log in DB with newly generated reference.
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
        $optilePaymentTransfer = $this->getFacade()->findOptilePaymentByIdSalesOrder($orderEntity->getIdSalesOrder());

        $this->getFacade()->makeRefundRequest(
            (new OptileRequestTransfer())->setLongId($optilePaymentTransfer->getRefundLongId())
                ->setOrderItems($orderItems)
                ->setPaymentCurrency($orderEntity->getCurrencyIsoCode())
        );

        return [];
    }
}
