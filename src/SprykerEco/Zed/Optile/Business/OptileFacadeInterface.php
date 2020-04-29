<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Optile\Business;

use Generated\Shared\Transfer\OptileNotificationRequestTransfer;
use Generated\Shared\Transfer\OptileNotificationResponseTransfer;
use Generated\Shared\Transfer\OptileRequestTransfer;
use Generated\Shared\Transfer\OptileResponseTransfer;

interface OptileFacadeInterface
{
    /**
     * Specification:
     * - Handles process based on the notification type.
     * - Saves notification request data.
     * - Returns response with result code.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\OptileNotificationRequestTransfer $optileNotificationRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileNotificationResponseTransfer
     */
    public function processNotificationRequest(
        OptileNotificationRequestTransfer $optileNotificationRequestTransfer
    ): OptileNotificationResponseTransfer;

    /**
     * Specification:
     * - Sends "List" request to the Optile api.
     * - Logs request and response to the transaction log table.
     * - Returns api response.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\OptileRequestTransfer $optileRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileResponseTransfer
     */
    public function makeListRequest(OptileRequestTransfer $optileRequestTransfer): OptileResponseTransfer;

    /**
     * Specification:
     * - Sends "Charge" request to the Optile api.
     * - Logs request and response to the transaction log table.
     * - Returns api response.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\OptileRequestTransfer $optileRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileResponseTransfer
     */
    public function makeChargeRequest(OptileRequestTransfer $optileRequestTransfer): OptileResponseTransfer;

    /**
     * Specification:
     * - Sends "Close" request to the Optile api.
     * - Logs request and response to the transaction log table.
     * - Returns api response.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\OptileRequestTransfer $optileRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileResponseTransfer
     */
    public function makeCloseRequest(OptileRequestTransfer $optileRequestTransfer): OptileResponseTransfer;
}
