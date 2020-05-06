<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Optile\Dependency\Client;

use Generated\Shared\Transfer\QuoteTransfer;

interface OptileToQuoteClientInterface
{
    /**
     * Specification:
     * - Returns the stored quote from session.
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function getQuote(): QuoteTransfer;

    /**
     * Specification:
     * - Set quote in session.
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return void
     */
    public function setQuote(QuoteTransfer $quoteTransfer);
}
