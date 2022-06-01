<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Optile\Plugin\StepEngine;

use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;
use Spryker\Yves\Kernel\AbstractPlugin;
use Spryker\Yves\StepEngine\Dependency\Plugin\Handler\StepHandlerPluginInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @see \Pyz\Yves\CheckoutPage\CheckoutPageDependencyProvider::extendPaymentMethodHandler()
 * @method \SprykerEco\Yves\Optile\OptileFactory getFactory()
 */
class OptileStepHandlerPlugin extends AbstractPlugin implements StepHandlerPluginInterface
{
    /**
     * {@inheritDoc}
     * - Requires `QuoteTransfer.payment` to be set.
     * - Adds `OptilePaymentTransfer` to `QuoteTransfer`.
     * - Sets payment provider and payment method based on payment selection.
     *
     * @api
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function addToDataClass(Request $request, AbstractTransfer $quoteTransfer): QuoteTransfer
    {
        return $this->getFactory()->createOptileQouteSetter()->addPaymentToQuote($request, $quoteTransfer);
    }
}
