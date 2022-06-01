<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Optile\Controller;

use Spryker\Yves\Kernel\Controller\AbstractController;
use SprykerEco\Shared\Optile\OptileConfig;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \SprykerEco\Yves\Optile\OptileFactory getFactory()
 */
class OptilePaymentHandlerController extends AbstractController
{
    /**
     * @uses \SprykerShop\Yves\CheckoutPage\Plugin\Router\CheckoutPageRouteProviderPlugin::CHECKOUT_SUMMARY
     *
     * @var string
     */
    protected const SUMMARY_STEP_URL = 'checkout-summary';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function handleAction(Request $request): RedirectResponse
    {
        $this->handlePayment($request);

        return $this->redirectResponseInternal(static::SUMMARY_STEP_URL);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return void
     */
    protected function handlePayment(Request $request): void
    {
        $quoteClient = $this->getFactory()->getQuoteClient();

        $quoteTransfer = $quoteClient->getQuote();

        $quoteTransfer->getPayment()
                ->setPaymentSelection(OptileConfig::PAYMENT_METHOD_NAME)
                ->setPaymentProvider(OptileConfig::PAYMENT_PROVIDER_NAME)
                ->setPaymentMethod(OptileConfig::PAYMENT_METHOD_NAME)
                ->setAmount($request->get('amount'));

         $quoteClient->setQuote($quoteTransfer);
    }
}
