<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Optile\Mapper;

use Generated\Shared\Transfer\OptileNotificationRequestTransfer;
use Symfony\Component\HttpFoundation\Request;

interface OptileNotificationRequestMapperInterface
{
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Generated\Shared\Transfer\OptileNotificationRequestTransfer
     */
    public function mapExternalRequestToNotificationRequestTransfer(Request $request): OptileNotificationRequestTransfer;
}
