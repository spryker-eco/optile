<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Client\Optile\Zed;

use Generated\Shared\Transfer\OptileNotificationRequestTransfer;
use Generated\Shared\Transfer\OptileNotificationResponseTransfer;
use Generated\Shared\Transfer\OptileRequestTransfer;
use Generated\Shared\Transfer\OptileResponseTransfer;
use Spryker\Client\ZedRequest\Stub\ZedRequestStub;

class OptileStub extends ZedRequestStub implements OptileStubInterface
{
    protected const ZED_GET_PROCESS_NOTIFICATION_REQUEST = '/optile/gateway/process-notification-request';
    protected const ZED_GET_MAKE_LIST_REQUEST = '/optile/gateway/make-list-request';

    /**
     * @param \Generated\Shared\Transfer\OptileNotificationRequestTransfer $optileNotificationRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileNotificationResponseTransfer
     */
    public function processNotificationRequest(
        OptileNotificationRequestTransfer $optileNotificationRequestTransfer
    ): OptileNotificationResponseTransfer {
        /** @var \Generated\Shared\Transfer\OptileNotificationResponseTransfer $optileNotificationResponseTransfer */
        $optileNotificationResponseTransfer = $this->zedStub->call(
            static::ZED_GET_PROCESS_NOTIFICATION_REQUEST,
            $optileNotificationRequestTransfer
        );

        return $optileNotificationResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\OptileRequestTransfer $optileRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileResponseTransfer
     */
    public function makeListRequest(OptileRequestTransfer $optileRequestTransfer): OptileResponseTransfer
    {
        /** @var \Generated\Shared\Transfer\OptileResponseTransfer $optileResponseTransfer */
        $optileResponseTransfer = $this->zedStub->call(
            static::ZED_GET_MAKE_LIST_REQUEST,
            $optileRequestTransfer
        );

        return $optileResponseTransfer;
    }
}
