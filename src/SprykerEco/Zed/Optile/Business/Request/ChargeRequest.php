<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Optile\Business\Request;

use Generated\Shared\Transfer\OptileRequestTransfer;
use Generated\Shared\Transfer\OptileResponseTransfer;
use Symfony\Component\HttpFoundation\Request;

class ChargeRequest extends AbstractBaseRequest
{
    public const CHARGE_REQUEST_PATH_TEMPLATE = '%s/lists/%s/charge';

    /**
     * @param array $responseData
     * @param \Generated\Shared\Transfer\OptileRequestTransfer $optileRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileResponseTransfer
     */
    protected function handleResponse(
        array $responseData,
        OptileRequestTransfer $optileRequestTransfer
    ): OptileResponseTransfer {
        return (new OptileResponseTransfer())
            ->setPaymentReference($optileRequestTransfer->getPaymentReference())
            ->setOperation($responseData['operation'])
            ->setLongId($responseData['identification']['longId']);
    }

    /**
     * @param \Generated\Shared\Transfer\OptileRequestTransfer $optileRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileRequestTransfer
     */
    protected function configureRequest(OptileRequestTransfer $optileRequestTransfer): OptileRequestTransfer
    {
        $optileRequestTransfer->setRequestUrl(
            sprintf(
                static::CHARGE_REQUEST_PATH_TEMPLATE,
                $this->optileConfig->getBaseApiUrl(),
                $optileRequestTransfer->getLongId()
            )
        );
        $optileRequestTransfer->setRequestPayload($optileRequestTransfer->getRequestPayload());

        return $optileRequestTransfer;
    }

    /**
     * @return string
     */
    protected function getRequestMethod(): string
    {
        return Request::METHOD_POST;
    }
}
