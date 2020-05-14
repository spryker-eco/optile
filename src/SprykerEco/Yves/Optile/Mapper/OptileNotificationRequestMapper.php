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
    protected const OPTILE_REFERENCE_KEY = 'reference';
    protected const OPTILE_NOTIFICATION_ID_KEY = 'notificationId';
    protected const OPTILE_REASON_CODE_KEY = 'reasonCode';
    protected const OPTILE_ENTITY_KEY = 'entity';
    protected const OPTILE_AMOUNT_KEY = 'amount';
    protected const OPTILE_SHORT_ID_KEY = 'shortId';
    protected const OPTILE_TIMESTAMP_KEY = 'timestamp';
    protected const OPTILE_STATUS_CODE_KEY = 'statusCode';
    protected const OPTILE_LONG_ID_KEY = 'longId';
    protected const OPTILE_TRANSACTION_ID_KEY = 'transactionId';
    protected const OPTILE_CURRENCY_ID_KEY = 'currency';

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
            ->setTransactionId($request->get(static::OPTILE_LONG_ID_KEY))
            ->setCurrency($request->get(static::OPTILE_CURRENCY_ID_KEY));
    }
}
