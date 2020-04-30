<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optile\Business\Hook;

use Generated\Shared\Transfer\PaymentOptileTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

class CheckoutPostSaveHook implements CheckoutPostSaveHookInterface
{

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentOptileTransfer
     */
    public function execute(QuoteTransfer $quoteTransfer): PaymentOptileTransfer
    {
        // TODO: Implement execute() method.
    }
}
