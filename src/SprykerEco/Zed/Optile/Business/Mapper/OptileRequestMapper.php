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
     * @var \Spryker\Service\UtilEncoding\UtilEncodingServiceInterface
     */
    protected $utilEncoding;

    /**
     * @param \SprykerEco\Zed\Optile\Dependency\Service\OptileToUtilEncodingServiceInterface $utilEncoding
     */
    public function __construct(OptileToUtilEncodingServiceInterface $utilEncoding)
    {
        $this->utilEncoding = $utilEncoding;
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
            ->setRequestPayload($this->utilEncoding->encodeJson($optileRequestTransfer->getRequestPayload()))
            ->setRequestUrl($optileRequestTransfer->getRequestUrl())
            ->setPaymentReference($optileRequestTransfer->getPaymentReference());
    }
}
