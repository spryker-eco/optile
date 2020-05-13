<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optile\Business\Request;

use Generated\Shared\Transfer\OptileRequestTransfer;
use Generated\Shared\Transfer\OptileResponseTransfer;
use SprykerEco\Zed\Optile\OptileConfig;
use Symfony\Component\HttpFoundation\Request;

class RefundRequest implements OptileApiRequestInterface
{
    protected const REFUND_REQUEST_PATH_TEMPLATE = '%s/charges/%s/payout';

    /**
     * @var \SprykerEco\Zed\Optile\OptileConfig
     */
    protected $optileConfig;

    /**
     * @param \SprykerEco\Zed\Optile\OptileConfig $optileConfig
     */
    public function __construct(OptileConfig $optileConfig)
    {
        $this->optileConfig = $optileConfig;
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
                static::REFUND_REQUEST_PATH_TEMPLATE,
                $this->optileConfig->getBaseApiUrl(),
                $optileRequestTransfer->getLongId()
            )
        );

        return $optileRequestTransfer;
    }

    /**
     * @return string
     */
    public function getRequestMethod(): string
    {
        return Request::METHOD_POST;
    }
}
