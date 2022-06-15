<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optile\Business\Request;

use Generated\Shared\Transfer\OptileRequestTransfer;
use Generated\Shared\Transfer\OptileResponseTransfer;
use SprykerEco\Zed\Optile\Business\Oms\OmsEventTriggerInterface;
use SprykerEco\Zed\Optile\OptileConfig;
use Symfony\Component\HttpFoundation\Request;

class CancelRequest implements OptileApiRequestInterface
{
    /**
     * @var string
     */
    protected const CANCEL_REQUEST_PATH_TEMPLATE = '%s/charges/%s';

    /**
     * @var \SprykerEco\Zed\Optile\OptileConfig
     */
    protected $optileConfig;

    /**
     * @var \SprykerEco\Zed\Optile\Business\Oms\OmsEventTriggerInterface
     */
    protected $omsEventTrigger;

    /**
     * @param \SprykerEco\Zed\Optile\OptileConfig $optileConfig
     * @param \SprykerEco\Zed\Optile\Business\Oms\OmsEventTriggerInterface $omsEventTrigger
     */
    public function __construct(
        OptileConfig $optileConfig,
        OmsEventTriggerInterface $omsEventTrigger
    ) {
        $this->optileConfig = $optileConfig;
        $this->omsEventTrigger = $omsEventTrigger;
    }

    /**
     * @param array $responseData
     * @param \Generated\Shared\Transfer\OptileRequestTransfer $optileRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileResponseTransfer
     */
    public function handleResponse(
        array $responseData,
        OptileRequestTransfer $optileRequestTransfer
    ): OptileResponseTransfer {
        $this->omsEventTrigger->triggerOmsEventForRemainingItems(
            $optileRequestTransfer->getSalesOrderReference(),
            $this->optileConfig->getOmsEventNameSendCancelRequest(),
        );

        return (new OptileResponseTransfer())->setIsSuccess(true);
    }

    /**
     * @param \Generated\Shared\Transfer\OptileRequestTransfer $optileRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileRequestTransfer
     */
    public function configureRequest(OptileRequestTransfer $optileRequestTransfer): OptileRequestTransfer
    {
        $optileRequestTransfer->setRequestUrl(
            sprintf(
                static::CANCEL_REQUEST_PATH_TEMPLATE,
                $this->optileConfig->getBaseApiUrl(),
                $optileRequestTransfer->getLongId(),
            ),
        );

        return $optileRequestTransfer;
    }

    /**
     * @return string
     */
    public function getRequestMethod(): string
    {
        return Request::METHOD_DELETE;
    }

    /**
     * @param array<string,mixed> $responseData
     *
     * @return bool
     */
    public function isFailedRequest(array $responseData): bool
    {
        return false;
    }
}
