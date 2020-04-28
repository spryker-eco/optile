<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\Optile\CheckoutPage\Process\Steps;

use Generated\Shared\Transfer\OptileRequestTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;
use SprykerEco\Client\Optile\OptileClientInterface;
use SprykerShop\Yves\CheckoutPage\Process\Steps\AbstractBaseStep;
use Symfony\Component\HttpFoundation\Request;

class OptileItInitializeStep extends AbstractBaseStep
{
    protected const LISTS_URL_PATH = 'lists';

    /**
     * @var \SprykerEco\Client\Optile\OptileClientInterface
     */
    protected $optileClient;

    /**
     * @var \SprykerEco\Yves\Optile\OptileConfigInterface
     */
    protected $optileConfig;

    /**
     * @param string $stepRoute
     * @param string $escapeRoute
     * @param \SprykerEco\Client\Optile\OptileClientInterface $optileClient
     */
    public function __construct(
        string $stepRoute,
        string $escapeRoute,
        OptileClientInterface $optileClient
    ) {
        parent::__construct($stepRoute, $escapeRoute);

        $this->optileClient = $optileClient;
    }

    /**
     * @param \Spryker\Shared\Kernel\Transfer\AbstractTransfer $quoteTransfer
     *
     * @return bool
     */
    public function requireInput(AbstractTransfer $quoteTransfer)
    {
        return false;
    }

    /**
     * Empty quote transfer and mark logged in customer as "dirty" to force update it in the next request.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer|\Spryker\Shared\Kernel\Transfer\AbstractTransfer
     */
    public function execute(Request $request, AbstractTransfer $quoteTransfer)
    {
        $optileResponseTransfer = $this->optileClient->makeListRequest(
            $this->buildOptileRequestTransfer($quoteTransfer)
        );

        dd($optileResponseTransfer);

        return $quoteTransfer;
    }

    /**
     * @param \Spryker\Shared\Kernel\Transfer\AbstractTransfer|\Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return bool
     */
    public function postCondition(AbstractTransfer $quoteTransfer)
    {
        return true;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\OptileRequestTransfer
     */
    protected function buildOptileRequestTransfer(QuoteTransfer $quoteTransfer)
    {
        return (new OptileRequestTransfer())
            ->setTransactionId($quoteTransfer->getUuid())
            ->setCountry($quoteTransfer->getBillingAddress()->getIso2Code())
            ->setCustomerEmail($quoteTransfer->getCustomer()->getEmail())
            ->setIdCustomer($quoteTransfer->getIdCustomer())
            ->setPaymentAmount($quoteTransfer->getTotals()->getGrandTotal())
            ->setPaymentCurrency($quoteTransfer->getCurrency()->getCode())
            ->setPaymentReference($quoteTransfer->getUuid());
    }
}
