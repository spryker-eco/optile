<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\Optile\Controller;

use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Yves\Kernel\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \SprykerEco\Yves\Optile\OptileFactory getFactory()
 */
class OptilePaymentHandlerController extends AbstractController
{
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handleAction(Request $request)
    {
        $summaryStepUrl = $this->getFactory()->getConfig()->getYvesCheckoutSummaryStepUrl();

        $quoteTransfer = $this->getFactory()->getQuoteClient()->getQuote();

        $this->handlePayment($request, $quoteTransfer);

        return new RedirectResponse($summaryStepUrl);
    }

    protected function handlePayment(Request $request, QuoteTransfer $quoteTransfer)
    {

    }
}