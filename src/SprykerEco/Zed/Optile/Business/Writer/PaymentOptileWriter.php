<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Optile\Business\Writer;

use Generated\Shared\Transfer\OptileNotificationRequestTransfer;
use Generated\Shared\Transfer\PaymentOptileTransfer;
use SprykerEco\Zed\Optile\Persistence\OptileEntityManagerInterface;

class PaymentOptileWriter implements PaymentOptileWriterWriterInterface
{
    /**
     * @var \SprykerEco\Zed\Optile\Persistence\OptileEntityManagerInterface
     */
    protected $optileEntityManager;

    /**
     * @param \SprykerEco\Zed\Optile\Persistence\OptileEntityManagerInterface $optileEntityManager
     */
    public function __construct(OptileEntityManagerInterface $optileEntityManager)
    {
        $this->optileEntityManager = $optileEntityManager;
    }

    /**
     * @param \Generated\Shared\Transfer\PaymentOptileTransfer $paymentOptileTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentOptileTransfer
     */
    public function savePaymentOptile(PaymentOptileTransfer $paymentOptileTransfer): PaymentOptileTransfer
    {
        return $this->optileEntityManager->savePaymentOptile($paymentOptileTransfer);
    }
}
