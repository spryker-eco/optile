<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Optile\CheckoutPage\Process\Steps;

use Generated\Shared\Transfer\OptileRequestTransfer;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;
use SprykerEco\Client\Optile\OptileClientInterface;
use SprykerShop\Yves\CheckoutPage\Process\Steps\AbstractBaseStep;
use Symfony\Component\HttpFoundation\Request;

class OptileItInitializeStep extends AbstractBaseStep
{
    /**
     * @var \SprykerEco\Client\Optile\OptileClientInterface
     */
    protected $optileClient;

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
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function execute(Request $request, AbstractTransfer $quoteTransfer)
    {
        $optileInitResponseTransfer = $this->optileClient->makeListRequest(
            (new OptileRequestTransfer())
                ->setTransactionId($quoteTransfer->getUuid())
                ->setCountry($quoteTransfer->getBillingAddress()->getIso2Code())
                ->setCustomerEmail($quoteTransfer->getCustomer()->getEmail())
                ->setIdCustomer($quoteTransfer->getCustomer()->getIdCustomer())
                ->setPaymentAmount($quoteTransfer->getTotals()->getGrandTotal())
                ->setPaymentCurrency($quoteTransfer->getCurrency()->getCode())
                ->setPaymentReference($quoteTransfer->getUuid())
                ->setCustomerScore($quoteTransfer->getCustomerScore())
                ->setCustomerIp($request->getClientIp())
                ->setClientUserAgent($request->headers->get('User-Agent'))
                ->setClientAcceptableContentTypes($request->getAcceptableContentTypes())
        );

        $quoteTransfer->setOptileInitResponse($optileInitResponseTransfer);

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
}
