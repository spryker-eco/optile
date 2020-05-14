<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optile\Business;

use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Generated\Shared\Transfer\OptileNotificationRequestTransfer;
use Generated\Shared\Transfer\OptileNotificationResponseTransfer;
use Generated\Shared\Transfer\OptileRequestTransfer;
use Generated\Shared\Transfer\OptileResponseTransfer;
use Generated\Shared\Transfer\PaymentOptileTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \SprykerEco\Zed\Optile\Business\OptileBusinessFactory getFactory()
 * @method \SprykerEco\Zed\Optile\Persistence\OptileEntityManagerInterface getEntityManager()
 * @method \SprykerEco\Zed\Optile\Persistence\OptileRepositoryInterface getRepository()
 */
class OptileFacade extends AbstractFacade implements OptileFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\OptileNotificationRequestTransfer $optileNotificationRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileNotificationResponseTransfer
     */
    public function processNotificationRequest(
        OptileNotificationRequestTransfer $optileNotificationRequestTransfer
    ): OptileNotificationResponseTransfer {
        return $this->getFactory()->createNotificationProcessor()->process($optileNotificationRequestTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\OptileRequestTransfer $optileRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileResponseTransfer
     */
    public function makeListRequest(OptileRequestTransfer $optileRequestTransfer): OptileResponseTransfer
    {
        return $this->getFactory()->createListClient()->request($optileRequestTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\OptileRequestTransfer $optileRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileResponseTransfer
     */
    public function makeCloseRequest(OptileRequestTransfer $optileRequestTransfer): OptileResponseTransfer
    {
        return $this->getFactory()->createCloseClient()->request($optileRequestTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\OptileRequestTransfer $optileRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileResponseTransfer
     */
    public function makeCancelRequest(OptileRequestTransfer $optileRequestTransfer): OptileResponseTransfer
    {
        return $this->getFactory()->createCancelClient()->request($optileRequestTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\OptileRequestTransfer $optileRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileResponseTransfer
     */
    public function makeRefundRequest(OptileRequestTransfer $optileRequestTransfer): OptileResponseTransfer
    {
        return $this->getFactory()->createRefundClient()->request($optileRequestTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param int $optileRequestTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentOptileTransfer|null
     */
    public function findOptilePaymentByIdSalesOrder(int $optileRequestTransfer): ?PaymentOptileTransfer
    {
        return $this->getRepository()
            ->findOptilePaymentByIdSalesOrder($optileRequestTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\SaveOrderTransfer $saveOrderTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentOptileTransfer
     */
    public function executeCheckoutDoSaveHook(
        QuoteTransfer $quoteTransfer,
        SaveOrderTransfer $saveOrderTransfer
    ): PaymentOptileTransfer {
        return $this->getFactory()->createCheckoutDoSaveHook()->execute($quoteTransfer, $saveOrderTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\CheckoutResponseTransfer $checkoutResponse
     *
     * @return void
     */
    public function executeOrderPostSaveHook(
        QuoteTransfer $quoteTransfer,
        CheckoutResponseTransfer $checkoutResponse
    ): void {
        $this->getFactory()->createCheckoutPostSaveHook()->execute($quoteTransfer, $checkoutResponse);
    }
}
