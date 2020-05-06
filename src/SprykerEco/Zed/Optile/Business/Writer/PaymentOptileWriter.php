<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optile\Business\Writer;

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
