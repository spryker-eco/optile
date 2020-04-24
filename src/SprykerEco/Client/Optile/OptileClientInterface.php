<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Client\Optile;

use Generated\Shared\Transfer\OptileListResponseTransfer;
use Generated\Shared\Transfer\OptileNotificationResponseTransfer;

interface OptileClientInterface
{
    /**
     * Specification:
     *  - Save the external Optile notification request, transforming it to the transfer object.
     *
     * @api
     *
     * @param array $externalResponse
     *
     * @return \Generated\Shared\Transfer\OptileNotificationResponseTransfer
     */
    public function saveNotificationRequest(array $externalResponse): OptileNotificationResponseTransfer;

    /**
     * Specification:
     *  - Send initial Optile payment request.
     *
     * @api
     *
     * @param array $externalResponse
     *
     * @return \Generated\Shared\Transfer\OptileListResponseTransfer
     */
    public function sendListRequest(array $externalResponse): OptileListResponseTransfer;
}
