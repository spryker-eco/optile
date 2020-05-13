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

class ChargeRequest implements OptileApiRequestInterface
{
    protected const CHARGE_REQUEST_PATH_TEMPLATE = '%s/lists/%s/charge';
    protected const ERROR_MESSAGE_LONG_ID_REQUIRED = 'Required field "longId" can\'t be empty';

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
        if (empty($responseData['identification']['longId'])) {
            return (new OptileResponseTransfer())->setIsSuccess(false)
                ->setError(static::ERROR_MESSAGE_LONG_ID_REQUIRED);
        }

        return (new OptileResponseTransfer())
            ->setPaymentReference($optileRequestTransfer->getPaymentReference())
            ->setOperation($responseData['operation'] ?? '')
            ->setLongId($responseData['identification']['longId']);
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
                static::CHARGE_REQUEST_PATH_TEMPLATE,
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
