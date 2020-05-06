<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optile\Persistence;

use Generated\Shared\Transfer\PaymentOptileTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \SprykerEco\Zed\Optile\Persistence\OptilePersistenceFactory getFactory()
 */
class OptileRepository extends AbstractRepository implements OptileRepositoryInterface
{
    /**
     * @param int $optileRequestTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentOptileTransfer
     */
    public function findOptilePaymentByIdSalesOrder(int $optileRequestTransfer): PaymentOptileTransfer
    {
        $paymentOptileEntity = $this->getFactory()
            ->createOptilePaymentQuery()
            ->filterByFkSalesOrder($optileRequestTransfer)
            ->findOne();

        $paymentOptileTransfer = new PaymentOptileTransfer();

        return $paymentOptileTransfer->fromArray(
            $paymentOptileEntity->toArray()
        );
    }
}
