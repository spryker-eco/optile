<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Optile\Communication\Plugin\Checkout;

use Generated\Shared\Transfer\OptileRequestTransfer;
use Generated\Shared\Transfer\PaymentOptileTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;
use Spryker\Zed\CheckoutExtension\Dependency\Plugin\CheckoutDoSaveOrderInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \SprykerEco\Zed\Optile\Business\OptileFacadeInterface getFacade()
 * @method \SprykerEco\Zed\Optile\OptileConfig getConfig()
 */
class OptilePaymentSaveCheckoutDoSavePlugin extends AbstractPlugin implements CheckoutDoSaveOrderInterface
{
    /**
     * {@inheritDoc}
     * Specification:
     * - This plugin is called after the order is placed.
     * - Set the success flag to false, if redirect should be headed to an error page afterwords
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\CheckoutResponseTransfer $checkoutResponse
     *
     * @return void
     */
    public function saveOrder(QuoteTransfer $quoteTransfer, SaveOrderTransfer $saveOrderTransfer)
    {
        /** @var PaymentOptileTransfer $paymentOptileTransfer */
        $paymentOptileTransfer = $this->getFacade()->checkoutDoSaveHook($quoteTransfer, $saveOrderTransfer);

        $this->getFacade()->makeChargeRequest(
            (new OptileRequestTransfer())->setLongId($paymentOptileTransfer->getLongId())
                ->setPaymentReference($quoteTransfer->getUuid())
                ->setFkSalesOrder($paymentOptileTransfer->getFkSalesOrder())
        );
    }
}
