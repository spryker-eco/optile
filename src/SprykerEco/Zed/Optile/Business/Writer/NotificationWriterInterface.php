<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Optile\Business\Writer;

use Generated\Shared\Transfer\OptileNotificationRequestTransfer;

interface NotificationWriterInterface
{
    /**
     * @param \Generated\Shared\Transfer\OptileNotificationRequestTransfer $optileNotificationRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileNotificationRequestTransfer
     */
    public function saveNotification(
        OptileNotificationRequestTransfer $optileNotificationRequestTransfer
    ): OptileNotificationRequestTransfer;
}
