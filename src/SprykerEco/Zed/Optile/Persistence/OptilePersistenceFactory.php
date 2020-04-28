<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Optile\Persistence;

use Orm\Zed\Optile\Persistence\SpyPaymentOptileNotificationQuery;
use Orm\Zed\Optile\Persistence\SpyPaymentOptileOrderItemQuery;
use Orm\Zed\Optile\Persistence\SpyPaymentOptileQuery;
use Orm\Zed\Optile\Persistence\SpyPaymentOptileRegistrationQuery;
use Orm\Zed\Optile\Persistence\SpyPaymentOptileTransactionLogQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;
use SprykerEco\Zed\Optile\Persistence\Mapper\NotificationRequestMapper;
use SprykerEco\Zed\Optile\Persistence\Mapper\NotificationRequestMapperInterface;

/**
 * @method \SprykerEco\Zed\Optile\Persistence\OptileEntityManagerInterface getEntityManager()
 * @method \SprykerEco\Zed\Optile\Persistence\OptileRepositoryInterface getRepository()
 * @method \SprykerEco\Zed\Optile\OptileConfig getConfig()
 */
class OptilePersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\Optile\Persistence\SpyPaymentOptileNotificationQuery
     */
    public function createOptileNotificationQuery(): SpyPaymentOptileNotificationQuery
    {
        return SpyPaymentOptileNotificationQuery::create();
    }

    /**
     * @return \Orm\Zed\Optile\Persistence\SpyPaymentOptileQuery
     */
    public function createOptilePaymentQuery(): SpyPaymentOptileQuery
    {
        return SpyPaymentOptileQuery::create();
    }

    /**
     * @return \Orm\Zed\Optile\Persistence\SpyPaymentOptileOrderItemQuery
     */
    public function createOptileOrderItemQuery(): SpyPaymentOptileOrderItemQuery
    {
        return SpyPaymentOptileOrderItemQuery::create();
    }

    /**
     * @return \Orm\Zed\Optile\Persistence\SpyPaymentOptileRegistrationQuery
     */
    public function createOptileRegistrationQuery(): SpyPaymentOptileRegistrationQuery
    {
        return SpyPaymentOptileRegistrationQuery::create();
    }

    /**
     * @return \Orm\Zed\Optile\Persistence\SpyPaymentOptileTransactionLogQuery
     */
    public function createOptileTransactionLogQuery(): SpyPaymentOptileTransactionLogQuery
    {
        return SpyPaymentOptileTransactionLogQuery::create();
    }

    /**
     * @return \SprykerEco\Zed\Merchant\Persistence\Mapper\NotificationRequestMapperInterface
     */
    public function createPropelNotificationRequestMapper(): NotificationRequestMapperInterface
    {
        return new NotificationRequestMapper();
    }
}
