<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
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
