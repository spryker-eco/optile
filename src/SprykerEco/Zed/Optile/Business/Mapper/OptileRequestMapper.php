<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optile\Business\Mapper;

use Generated\Shared\Transfer\OptileRequestTransfer;
use Generated\Shared\Transfer\OptileTransactionLogTransfer;
use SprykerEco\Zed\Optile\Dependency\Service\OptileToUtilEncodingServiceInterface;

class OptileRequestMapper implements OptileRequestMapperInterface
{
    /**
     * @var \SprykerEco\Zed\Optile\Dependency\Service\OptileToUtilEncodingServiceInterface
     */
    protected $utilEncodingService;

    /**
     * @param \SprykerEco\Zed\Optile\Dependency\Service\OptileToUtilEncodingServiceInterface $utilEncodingService
     */
    public function __construct(OptileToUtilEncodingServiceInterface $utilEncodingService)
    {
        $this->utilEncodingService = $utilEncodingService;
    }

    /**
     * @param \Generated\Shared\Transfer\OptileRequestTransfer $optileRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileTransactionLogTransfer
     */
    public function mapOptileRequestToTransactionLog(
        OptileRequestTransfer $optileRequestTransfer
    ): OptileTransactionLogTransfer {
        return (new OptileTransactionLogTransfer())
            ->setRequestPayload($this->utilEncodingService->encodeJson($optileRequestTransfer->getRequestPayload()))
            ->setRequestUrl($optileRequestTransfer->getRequestUrl())
            ->setPaymentReference($optileRequestTransfer->getPaymentReference());
    }
}
