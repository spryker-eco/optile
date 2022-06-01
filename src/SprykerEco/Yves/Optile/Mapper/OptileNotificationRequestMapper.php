<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Optile\Mapper;

use Generated\Shared\Transfer\OptileNotificationRequestTransfer;
use Symfony\Component\HttpFoundation\Request;

class OptileNotificationRequestMapper implements OptileNotificationRequestMapperInterface
{
    /**
     * @var string
     */
    protected const OPTILE_REFERENCE_KEY = 'reference';

    /**
     * @var string
     */
    protected const OPTILE_NOTIFICATION_ID_KEY = 'notificationId';

    /**
     * @var string
     */
    protected const OPTILE_REASON_CODE_KEY = 'reasonCode';

    /**
     * @var string
     */
    protected const OPTILE_ENTITY_KEY = 'entity';

    /**
     * @var string
     */
    protected const OPTILE_AMOUNT_KEY = 'amount';

    /**
     * @var string
     */
    protected const OPTILE_SHORT_ID_KEY = 'shortId';

    /**
     * @var string
     */
    protected const OPTILE_TIMESTAMP_KEY = 'timestamp';

    /**
     * @var string
     */
    protected const OPTILE_STATUS_CODE_KEY = 'statusCode';

    /**
     * @var string
     */
    protected const OPTILE_LONG_ID_KEY = 'longId';

    /**
     * @var string
     */
    protected const OPTILE_TRANSACTION_ID_KEY = 'transactionId';

    /**
     * @var string
     */
    protected const OPTILE_CURRENCY_ID_KEY = 'currency';

    /**
     * @var string
     */
    protected const OPTILE_CUSTOMER_REGISTRATION_ID_KEY = 'customerRegistrationId';

    /**
     * @var string
     */
    protected const OPTILE_CUSTOMER_REGISTRATION_PASSWORD_KEY = 'customerRegistrationPassword';

    /**
     * @var string
     */
    protected const OPTILE_CUSTOMER_REGISTRATION_EMAIL_KEY = 'customerEmail';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Generated\Shared\Transfer\OptileNotificationRequestTransfer
     */
    public function mapExternalRequestToNotificationRequestTransfer(Request $request): OptileNotificationRequestTransfer
    {
        return (new OptileNotificationRequestTransfer())
            ->setPaymentReference($request->get(static::OPTILE_REFERENCE_KEY))
            ->setNotificationId($request->get(static::OPTILE_NOTIFICATION_ID_KEY))
            ->setEntity($request->get(static::OPTILE_ENTITY_KEY))
            ->setAmount($request->get(static::OPTILE_AMOUNT_KEY))
            ->setShortId($request->get(static::OPTILE_SHORT_ID_KEY))
            ->setReasonCode($request->get(static::OPTILE_REASON_CODE_KEY))
            ->setTimestamp($request->get(static::OPTILE_TIMESTAMP_KEY))
            ->setStatusCode($request->get(static::OPTILE_STATUS_CODE_KEY))
            ->setLongId($request->get(static::OPTILE_LONG_ID_KEY))
            ->setTransactionId($request->get(static::OPTILE_TRANSACTION_ID_KEY))
            ->setCustomerRegistrationHash($request->get(static::OPTILE_CUSTOMER_REGISTRATION_PASSWORD_KEY))
            ->setCustomerRegistrationId($request->get(static::OPTILE_CUSTOMER_REGISTRATION_ID_KEY))
            ->setCustomerRegistrationEmail($request->get(static::OPTILE_CUSTOMER_REGISTRATION_EMAIL_KEY))
            ->setCurrency($request->get(static::OPTILE_CURRENCY_ID_KEY));
    }
}
