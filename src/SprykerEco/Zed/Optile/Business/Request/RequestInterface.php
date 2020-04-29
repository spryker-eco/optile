<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Optile\Business\Request;

use Generated\Shared\Transfer\OptileRequestTransfer;
use Generated\Shared\Transfer\OptileResponseTransfer;

interface RequestInterface
{
    public const BASE_OPTILE_REQUEST_HEADERS = [
        'Content-Type' => 'application/vnd.optile.payment.enterprise-v1-extensible+json',
        'Accept' => 'application/vnd.optile.payment.enterprise-v1-extensible+json',
    ];

    /**
     * @param \Generated\Shared\Transfer\OptileRequestTransfer $optileRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileResponseTransfer
     */
    public function request(
        OptileRequestTransfer $optileRequestTransfer
    ): OptileResponseTransfer;
}
