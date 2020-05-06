<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optile\Business\Writer;

use Generated\Shared\Transfer\PaymentOptileTransfer;

interface PaymentOptileWriterWriterInterface
{
    /**
     * @param \Generated\Shared\Transfer\PaymentOptileTransfer $paymentOptileTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentOptileTransfer
     */
    public function savePaymentOptile(PaymentOptileTransfer $paymentOptileTransfer): PaymentOptileTransfer;
}
