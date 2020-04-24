<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Client\Optile;

use Generated\Shared\Transfer\OptileListResponseTransfer;
use Generated\Shared\Transfer\OptileNotificationResponseTransfer;

class OptileClient implements OptileClientInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param array $externalResponse
     *
     * @return \Generated\Shared\Transfer\OptileNotificationResponseTransfer
     */
    public function saveNotificationRequest(array $externalResponse): OptileNotificationResponseTransfer
    {
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param array $externalResponse
     *
     * @return \Generated\Shared\Transfer\OptileListResponseTransfer
     */
    public function sendListRequest(array $externalResponse): OptileListResponseTransfer
    {
    }
}
