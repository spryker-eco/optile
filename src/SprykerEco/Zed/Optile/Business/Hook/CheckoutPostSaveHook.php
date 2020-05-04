<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Optile\Business\Hook;

use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Generated\Shared\Transfer\PaymentOptileTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;
use SprykerEco\Zed\Optile\Business\Writer\PaymentOptileWriterWriterInterface;

class CheckoutPostSaveHook implements CheckoutPostSaveHookInterface
{
    /**
     * @var \SprykerEco\Zed\Optile\Business\Writer\PaymentOptileWriterWriterInterface
     */
    protected $paymentOptileWriterWriter;

    /**
     * @param \SprykerEco\Zed\Optile\Business\Writer\PaymentOptileWriterWriterInterface $paymentOptileWriterWriter
     */
    public function __construct(PaymentOptileWriterWriterInterface $paymentOptileWriterWriter)
    {
        $this->paymentOptileWriterWriter = $paymentOptileWriterWriter;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @param \Generated\Shared\Transfer\SaveOrderTransfer $saveOrderTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentOptileTransfer
     */
    public function execute(
        QuoteTransfer $quoteTransfer,
        SaveOrderTransfer $saveOrderTransfer
    ): PaymentOptileTransfer {
        $optileInitResponse = $quoteTransfer->getOptileInitResponse();

        return $this->paymentOptileWriterWriter->savePaymentOptile(
            (new PaymentOptileTransfer())
                ->setLongId($optileInitResponse->getLongId())
                ->setPaymentReference($optileInitResponse->getPaymentReference())
                ->setFkSalesOrder($saveOrderTransfer->getIdSalesOrder())
                ->setPaymentMethod($quoteTransfer->getPayment()->getPaymentMethod())
        );
    }
}
