<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optile\Communication\Plugin\Checkout\Oms\Condition;

use Generated\Shared\Transfer\OptileOrderItemRequestLogCriteriaTransfer;
use Orm\Zed\Sales\Persistence\SpySalesOrderItem;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\Oms\Dependency\Plugin\Condition\ConditionInterface;
use SprykerEco\Zed\Optile\Business\Request\RefundRequest;

/**
 * @method \SprykerEco\Zed\Optile\Business\OptileFacadeInterface getFacade()
 * @method \SprykerEco\Zed\Optile\OptileConfig getConfig()
 */
class IsRefundedPlugin extends AbstractPlugin implements ConditionInterface
{
    /**
     * {@inheritDoc}
     * - Finds order item request log.
     * - Finds notifications by item payment reference.
     * - Returns success if refunded notification exists and success.
     * - Returns false otherwise.
     *
     * @api
     *
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem $orderItem
     *
     * @return bool
     */
    public function check(SpySalesOrderItem $orderItem)
    {
        $refundOrderItemRequestLogTransfer = $this->getFacade()->findOrderItemRequestLogByCriteria(
            (new OptileOrderItemRequestLogCriteriaTransfer())
                ->setRequestType(RefundRequest::REFUND_REQUEST_TYPE)
                ->setFkSalesOrderItem($orderItem->getIdSalesOrderItem())
        );

        return $this->getFacade()->isOrderRefunded($refundOrderItemRequestLogTransfer->getItemPaymentReference());
    }
}
