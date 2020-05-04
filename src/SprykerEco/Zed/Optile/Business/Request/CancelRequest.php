<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Optile\Business\Request;

use Generated\Shared\Transfer\OptileRequestTransfer;
use Generated\Shared\Transfer\OptileResponseTransfer;
use Symfony\Component\HttpFoundation\Request;

class CancelRequest extends AbstractBaseRequest
{
    public const CANCEL_REQUEST_PATH_TEMPLATE = '/charges/%s';

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
        return (new OptileResponseTransfer())->setIsSuccess(true);
    }

    /**
     * @param \Generated\Shared\Transfer\OptileRequestTransfer $optileRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileRequestTransfer
     */
    protected function configureRequest(OptileRequestTransfer $optileRequestTransfer): OptileRequestTransfer
    {
        $optileRequestTransfer->setRequestUrl(
            sprintf(static::CANCEL_REQUEST_PATH_TEMPLATE, $optileRequestTransfer->getLongId())
        );

        return $optileRequestTransfer;
    }

    /**
     * @return string
     */
    protected function getRequestMethod(): string
    {
        return Request::METHOD_DELETE;
    }
}
