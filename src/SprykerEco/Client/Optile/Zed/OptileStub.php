<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Client\Optile\Zed;

use Generated\Shared\Transfer\OptileNotificationRequestTransfer;
use Generated\Shared\Transfer\OptileNotificationResponseTransfer;
use Generated\Shared\Transfer\OptileRequestTransfer;
use Generated\Shared\Transfer\OptileResponseTransfer;
use SprykerEco\Client\Optile\Dependency\Client\OptileToZedRequestClientInterface;

class OptileStub implements OptileStubInterface
{
    protected const ZED_GET_PROCESS_NOTIFICATION_REQUEST = '/optile/gateway/process-notification-request';
    protected const ZED_GET_MAKE_LIST_REQUEST = '/optile/gateway/make-list-request';

    /**
     * @var \SprykerEco\Client\Optile\Dependency\Client\OptileToZedRequestClientInterface
     */
    protected $zedRequestClient;

    /**
     * @param \SprykerEco\Client\Optile\Dependency\Client\OptileToZedRequestClientInterface $zedRequestClient
     */
    public function __construct(OptileToZedRequestClientInterface $zedRequestClient)
    {
        $this->zedRequestClient = $zedRequestClient;
    }

    /**
     * @param \Generated\Shared\Transfer\OptileNotificationRequestTransfer $optileNotificationRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileNotificationResponseTransfer
     */
    public function processNotificationRequest(
        OptileNotificationRequestTransfer $optileNotificationRequestTransfer
    ): OptileNotificationResponseTransfer {
        /** @var \Generated\Shared\Transfer\OptileNotificationResponseTransfer $optileNotificationResponseTransfer */
        $optileNotificationResponseTransfer = $this->zedRequestClient->call(
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
        $optileResponseTransfer = $this->zedRequestClient->call(
            static::ZED_GET_MAKE_LIST_REQUEST,
            $optileRequestTransfer
        );

        return $optileResponseTransfer;
    }
}
