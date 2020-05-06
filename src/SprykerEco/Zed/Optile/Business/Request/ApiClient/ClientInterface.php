<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optile\Business\Request\ApiClient;

use Generated\Shared\Transfer\OptileRequestTransfer;
use Generated\Shared\Transfer\OptileResponseTransfer;

interface ClientInterface
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
