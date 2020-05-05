<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\Optile\Mapper;

use Generated\Shared\Transfer\OptileNotificationRequestTransfer;
use Symfony\Component\HttpFoundation\Request;

interface OptileNotificationRequestToOptileNotificationTransferInterface
{
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Generated\Shared\Transfer\OptileNotificationRequestTransfer
     */
    public function map(Request $request): OptileNotificationRequestTransfer;
}
