<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optile\Persistence;

use Generated\Shared\Transfer\OptileCustomerRegistrationTransfer;
use Generated\Shared\Transfer\OptileNotificationRequestTransfer;
use Generated\Shared\Transfer\PaymentOptileTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \SprykerEco\Zed\Optile\Persistence\OptilePersistenceFactory getFactory()
 */
class OptileRepository extends AbstractRepository implements OptileRepositoryInterface
{
    /**
     * @param int $salesOrderId
     *
     * @return \Generated\Shared\Transfer\PaymentOptileTransfer|null
     */
    public function findOptilePaymentByIdSalesOrder(int $salesOrderId): ?PaymentOptileTransfer
    {
        $paymentOptileEntity = $this->getFactory()
            ->createOptilePaymentQuery()
            ->filterByFkSalesOrder($salesOrderId)
            ->findOne();

        if (!$paymentOptileEntity) {
            return null;
        }

        $paymentOptileTransfer = new PaymentOptileTransfer();

        return $paymentOptileTransfer->fromArray($paymentOptileEntity->toArray(), true);
    }

    /**
     * @param string $email
     *
     * @return \Generated\Shared\Transfer\OptileCustomerRegistrationTransfer|null
     */
    public function findCustomerRegistrationTransferByEmail(string $email): ?OptileCustomerRegistrationTransfer
    {
        $registrationEntity = $this->getFactory()
            ->createOptileRegistrationQuery()
            ->filterByCustomerRegistrationEmail($email)
            ->findOne();

        if (!$registrationEntity) {
            return null;
        }

        $registrationTransfer = new OptileCustomerRegistrationTransfer();

        return $registrationTransfer->fromArray($registrationEntity->toArray(), true);
    }

    /**
     * @param \Generated\Shared\Transfer\PaymentOptileTransfer $paymentOptileTransfer
     *
     * @return \Generated\Shared\Transfer\OptileNotificationRequestTransfer[]
     */
    public function findNotificationsByPaymentReference(PaymentOptileTransfer $paymentOptileTransfer): array
    {
        $notificationTransfers = [];

        $notificationEntities = $this->getFactory()
            ->createOptileNotificationQuery()
            ->filterByPaymentReference($paymentOptileTransfer->getPaymentReference())
            ->find();

        foreach ($notificationEntities as $optileNotificationEntity) {
            $notificationTransfer = new OptileNotificationRequestTransfer();
            $notificationTransfers[] = $notificationTransfer->fromArray($optileNotificationEntity->toArray(), true);
        }

        return $notificationTransfers;
    }
}
