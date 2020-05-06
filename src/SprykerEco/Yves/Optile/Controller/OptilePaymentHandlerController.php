<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Optile\Controller;

use Generated\Shared\Transfer\PaymentTransfer;
use Spryker\Yves\Kernel\Controller\AbstractController;
use SprykerEco\Shared\Optile\OptileConfig;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \SprykerEco\Yves\Optile\OptileFactory getFactory()
 */
class OptilePaymentHandlerController extends AbstractController
{
    protected const SUMMARY_STEP_URL = 'checkout-summary';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handleAction(Request $request)
    {
        $this->handlePayment($request);

        return $this->redirectResponseInternal(static::SUMMARY_STEP_URL);
    }

    /**
     * @return void
     */
    protected function handlePayment(Request $request)
    {
        $quoteClient = $this->getFactory()->getQuoteClient();

        $quoteTransfer = $quoteClient->getQuote()->setPayment(
            (new PaymentTransfer())
                ->setPaymentSelection(OptileConfig::PAYMENT_METHOD_NAME)
                ->setPaymentProvider(OptileConfig::PAYMENT_PROVIDER_NAME)
                ->setPaymentMethod(OptileConfig::PAYMENT_METHOD_NAME)
        );

         $quoteClient->setQuote($quoteTransfer);
    }
}
