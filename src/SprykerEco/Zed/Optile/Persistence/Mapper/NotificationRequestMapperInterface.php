<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Optile\Persistence\Mapper;

use Generated\Shared\Transfer\OptileNotificationRequestTransfer;
use Orm\Zed\Optile\Persistence\SpyPaymentOptileNotification;

interface NotificationRequestMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\OptileNotificationRequestTransfer $optileNotificationRequestTransfer
     * @param \Orm\Zed\Optile\Persistence\SpyPaymentOptileNotification $optileNotification
     *
     * @return \Orm\Zed\Optile\Persistence\SpyPaymentOptileNotification
     */
    public function mapNotificationRequestTransferToEntity(
        OptileNotificationRequestTransfer $optileNotificationRequestTransfer,
        SpyPaymentOptileNotification $optileNotification
    ): SpyPaymentOptileNotification;
}
