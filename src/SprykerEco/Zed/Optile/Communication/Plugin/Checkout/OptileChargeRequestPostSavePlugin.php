<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optile\Communication\Plugin\Checkout;

use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\Checkout\Dependency\Plugin\CheckoutPostSaveHookInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \SprykerEco\Zed\Optile\Business\OptileFacadeInterface getFacade()
 * @method \SprykerEco\Zed\Optile\OptileConfig getConfig()
 */
class OptileChargeRequestPostSavePlugin extends AbstractPlugin implements CheckoutPostSaveHookInterface
{
    /**
     * {@inheritDoc}
     *
     * Specification:
     * - Makes Charge Request to Optile remote.
     * - Set success or error response to the Checkout response transfer.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\CheckoutResponseTransfer $checkoutResponse
     *
     * @return void
     */
    public function executeHook(QuoteTransfer $quoteTransfer, CheckoutResponseTransfer $checkoutResponse)
    {
        $this->getFacade()->executeOrderPostSaveHook($quoteTransfer, $checkoutResponse);
    }
}
