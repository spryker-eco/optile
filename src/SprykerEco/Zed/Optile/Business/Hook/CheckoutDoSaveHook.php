<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optile\Business\Hook;

use Generated\Shared\Transfer\PaymentOptileTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;
use SprykerEco\Zed\Optile\Business\Writer\PaymentOptileWriterWriterInterface;

class CheckoutDoSaveHook implements CheckoutDoSaveHookInterface
{
    /**
     * @var \SprykerEco\Zed\Optile\Business\Writer\PaymentOptileWriterWriterInterface
     */
    protected $paymentOptileWriter;

    /**
     * @param \SprykerEco\Zed\Optile\Business\Writer\PaymentOptileWriterWriterInterface $paymentOptileWriter
     */
    public function __construct(PaymentOptileWriterWriterInterface $paymentOptileWriter)
    {
        $this->paymentOptileWriter = $paymentOptileWriter;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\SaveOrderTransfer $saveOrderTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentOptileTransfer
     */
    public function execute(
        QuoteTransfer $quoteTransfer,
        SaveOrderTransfer $saveOrderTransfer
    ): PaymentOptileTransfer {
        $optileInitResponse = $quoteTransfer->getOptileInitResponse();

        $paymentOptileTransfer = (new PaymentOptileTransfer())
                ->setLongId($optileInitResponse->getLongId())
                ->setPaymentReference($optileInitResponse->getPaymentReference())
                ->setFkSalesOrder($saveOrderTransfer->getIdSalesOrder())
                ->setPaymentMethod($quoteTransfer->getPayment()->getPaymentMethod());

        return $this->paymentOptileWriter->savePaymentOptile($paymentOptileTransfer);
    }
}
