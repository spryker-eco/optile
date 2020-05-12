<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optile\Business\Hook;

use ArrayObject;
use Generated\Shared\Transfer\CheckoutErrorTransfer;
use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Generated\Shared\Transfer\OptileRequestTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use SprykerEco\Zed\Optile\Business\Request\ApiClient\OptileApiClientInterface;

class CheckoutPostSaveHook implements CheckoutPostSaveHookInterface
{
    /**
     * @var \SprykerEco\Zed\Optile\Business\Request\ApiClient\OptileApiClientInterface
     */
    protected $client;

    /**
     * @param \SprykerEco\Zed\Optile\Business\Request\ApiClient\OptileApiClientInterface $client
     */
    public function __construct(OptileApiClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\CheckoutResponseTransfer $checkoutResponse
     *
     * @return void
     */
    public function execute(QuoteTransfer $quoteTransfer, CheckoutResponseTransfer $checkoutResponse): void
    {
        $optileRequestTransfer = (new OptileRequestTransfer())
            ->setLongId($quoteTransfer->getOptileInitResponse()->getLongId())
            ->setPaymentReference($quoteTransfer->getOptileInitResponse()->getPaymentReference());

        $optileResponseTransfer = $this->client->request($optileRequestTransfer);

        $checkoutResponse->setIsSuccess($optileResponseTransfer->getIsSuccess());

        if (!$optileResponseTransfer->getIsSuccess()) {
            $checkoutResponse->addError((new CheckoutErrorTransfer())->setMessage($optileResponseTransfer->getError()));
        }
    }
}
