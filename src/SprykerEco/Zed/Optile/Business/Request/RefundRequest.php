<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optile\Business\Request;

use Generated\Shared\Transfer\OptileOrderItemRequestLogTransfer;
use Generated\Shared\Transfer\OptileRequestTransfer;
use Generated\Shared\Transfer\OptileResponseTransfer;
use SprykerEco\Zed\Optile\OptileConfig;
use SprykerEco\Zed\Optile\Persistence\OptileEntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class RefundRequest implements OptileApiRequestInterface
{
    protected const REFUND_REQUEST_PATH_TEMPLATE = '%s/charges/%s/payout';
    public const REFUND_REQUEST_TYPE = 'REFUND_REQUEST';

    /**
     * @var \SprykerEco\Zed\Optile\OptileConfig
     */
    protected $optileConfig;

    /**
     * @var \SprykerEco\Zed\Optile\Persistence\OptileEntityManagerInterface
     */
    protected $optileEntityManager;

    /**
     * @param \SprykerEco\Zed\Optile\OptileConfig $optileConfig
     * @param \SprykerEco\Zed\Optile\Persistence\OptileEntityManagerInterface $optileEntityManager
     */
    public function __construct(OptileConfig $optileConfig, OptileEntityManagerInterface $optileEntityManager)
    {
        $this->optileConfig = $optileConfig;
        $this->optileEntityManager = $optileEntityManager;
    }

    /**
     * @param array $responseData
     * @param \Generated\Shared\Transfer\OptileRequestTransfer $optileRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileResponseTransfer
     */
    public function handleResponse(
        array $responseData,
        OptileRequestTransfer $optileRequestTransfer
    ): OptileResponseTransfer {
        $this->saveOrderItemRequestLog($optileRequestTransfer);

        return (new OptileResponseTransfer())->setIsSuccess(true);
    }

    /**
     * @param \Generated\Shared\Transfer\OptileRequestTransfer $optileRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileRequestTransfer
     */
    public function configureRequest(OptileRequestTransfer $optileRequestTransfer): OptileRequestTransfer
    {
        $optileRequestTransfer->setRequestUrl(
            sprintf(
                static::REFUND_REQUEST_PATH_TEMPLATE,
                $this->optileConfig->getBaseApiUrl(),
                $optileRequestTransfer->getLongId()
            )
        );

        $optileRequestTransfer->setPaymentReference($this->getUniquePaymentReference($optileRequestTransfer));
        $optileRequestTransfer = $optileRequestTransfer->setRequestPayload($this->getPayload($optileRequestTransfer));

        return $optileRequestTransfer;
    }

    /**
     * @return string
     */
    public function getRequestMethod(): string
    {
        return Request::METHOD_POST;
    }

    /**
     * @param \Generated\Shared\Transfer\OptileRequestTransfer $optileRequestTransfer
     *
     * @return string
     */
    protected function getUniquePaymentReference(OptileRequestTransfer $optileRequestTransfer): string
    {
        $uniquePrefix = '';

        foreach ($optileRequestTransfer->getOrderItems() as $orderItemTransfer) {
            /** @var \Orm\Zed\Sales\Persistence\Base\SpySalesOrderItem $orderItemTransfer */
            $uniquePrefix.= "_{$orderItemTransfer->getIdSalesOrderItem()}";
        }

        return uniqid($uniquePrefix);
    }

    /**
     * @param \Generated\Shared\Transfer\OptileRequestTransfer $optileRequestTransfer
     *
     * @return array
     */
    protected function getPayload(OptileRequestTransfer $optileRequestTransfer): array
    {
        $requestPayload = [];
        $refundableAmount = 0;

        foreach ($optileRequestTransfer->getOrderItems() as $orderItemTransfer) {
            $itemRefundableAmount = $this->getRefundAmount($orderItemTransfer->getRefundableAmount());
            /** @var \Orm\Zed\Sales\Persistence\Base\SpySalesOrderItem $orderItemTransfer */
            $refundableAmount += $itemRefundableAmount;
            $requestPayload['products'][] = [
                'code' => $orderItemTransfer->getIdSalesOrderItem(),
                'name' => $orderItemTransfer->getName(),
                'quantity' => $orderItemTransfer->getQuantity(),
                'amount' => $itemRefundableAmount,
            ];
        }

        $requestPayload['payment'] = [
            'amount' => $refundableAmount,
            'currency' => $optileRequestTransfer->getPaymentCurrency(),
            'reference' => $optileRequestTransfer->getPaymentReference(),
        ];

        return $requestPayload;
    }

    /**
     * @param int $amount
     *
     * @return float
     */
    protected function getRefundAmount(int $amount): float
    {
        return $amount / 100;
    }

    /**
     * @param \Generated\Shared\Transfer\OptileRequestTransfer $optileRequestTransfer
     *
     * @return void
     */
    protected function saveOrderItemRequestLog(OptileRequestTransfer $optileRequestTransfer): void
    {
        foreach ($optileRequestTransfer->getOrderItems() as $orderItem) {
            $optileRequestLogTransfer = (new OptileOrderItemRequestLogTransfer())
                ->setFkSalesOrderItem($orderItem->getIdSalesOrderItem())
                ->setRequestType(static::REFUND_REQUEST_TYPE)
                ->setItemPaymentReference($optileRequestTransfer->getPaymentReference());

            $this->optileEntityManager->saveOrderItemRequestLog($optileRequestLogTransfer);
        }
    }
}
