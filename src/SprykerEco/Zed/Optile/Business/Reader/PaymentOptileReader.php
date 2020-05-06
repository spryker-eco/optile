<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optile\Business\Reader;

use Generated\Shared\Transfer\PaymentOptileTransfer;
use SprykerEco\Zed\Optile\Persistence\OptileRepositoryInterface;

class PaymentOptileReader implements PaymentOptileReaderInterface
{
    /**
     * @var \SprykerEco\Zed\Optile\Persistence\OptileRepositoryInterface
     */
    protected $optileRepository;

    /**
     * @param \SprykerEco\Zed\Optile\Persistence\OptileRepositoryInterface $optileRepository
     */
    public function __construct(OptileRepositoryInterface $optileRepository)
    {
        $this->optileRepository = $optileRepository;
    }

    /**
     * @param int $optileRequestTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentOptileTransfer
     */
    public function findOptilePaymentByIdSalesOrder(int $optileRequestTransfer): PaymentOptileTransfer
    {
        return $this->optileRepository->findOptilePaymentByIdSalesOrder($optileRequestTransfer);
    }
}
