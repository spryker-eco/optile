<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Optile\Business\Processor;

use Generated\Shared\Transfer\OptileNotificationRequestTransfer;
use Generated\Shared\Transfer\OptileNotificationResponseTransfer;

interface NotificationProcessorInterface
{
    /**
     * @param \Generated\Shared\Transfer\OptileNotificationRequestTransfer $optileNotificationRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileNotificationResponseTransfer
     */
    public function process(
        OptileNotificationRequestTransfer $optileNotificationRequestTransfer
    ): OptileNotificationResponseTransfer;
}
