<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optile\Persistence;

use Generated\Shared\Transfer\OptileCustomerRegistrationTransfer;
use Generated\Shared\Transfer\OptileNotificationRequestTransfer;
use Generated\Shared\Transfer\OptileOrderItemRequestLogCriteriaTransfer;
use Generated\Shared\Transfer\OptileOrderItemRequestLogTransfer;
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
    public function findOptileCustomerRegistrationByEmail(string $email): ?OptileCustomerRegistrationTransfer
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
     * @param string $paymentReference
     *
     * @return \Generated\Shared\Transfer\OptileNotificationRequestTransfer[]
     */
    public function getNotificationsByPaymentReference(string $paymentReference): array
    {
        $notificationTransfers = [];

        $notificationEntities = $this->getFactory()
            ->createOptileNotificationQuery()
            ->filterByPaymentReference($paymentReference)
            ->find();

        foreach ($notificationEntities as $optileNotificationEntity) {
            $notificationTransfer = new OptileNotificationRequestTransfer();
            $notificationTransfers[] = $notificationTransfer->fromArray($optileNotificationEntity->toArray(), true);
        }

        return $notificationTransfers;
    }

    /**
     * @param \Generated\Shared\Transfer\OptileOrderItemRequestLogCriteriaTransfer $criteriaTransfer
     *
     * @return \Generated\Shared\Transfer\OptileOrderItemRequestLogTransfer|null
     */
    public function findOrderItemRequestLogByCriteria(
        OptileOrderItemRequestLogCriteriaTransfer $criteriaTransfer
    ): ?OptileOrderItemRequestLogTransfer {
        $orderItemRequestLogEntity = $this->getFactory()
            ->createPaymentOptileItemRequestLogQuery()
            ->filterByFkSalesOrderItem($criteriaTransfer->getFkSalesOrderItem())
            ->filterByRequestType($criteriaTransfer->getRequestType())
            ->findOne();

        return (new OptileOrderItemRequestLogTransfer())->fromArray(
            $orderItemRequestLogEntity->toArray(),
            true
        );
    }
}
