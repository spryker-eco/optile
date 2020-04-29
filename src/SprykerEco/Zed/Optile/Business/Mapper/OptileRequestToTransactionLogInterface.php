<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Optile\Business\Mapper;

use Generated\Shared\Transfer\OptileRequestTransfer;
use Generated\Shared\Transfer\OptileTransactionLogTransfer;

interface OptileRequestToTransactionLogInterface
{
    /**
     * @param \Generated\Shared\Transfer\OptileRequestTransfer $optileRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileTransactionLogTransfer
     */
    public function map(
        OptileRequestTransfer $optileRequestTransfer
    ): OptileTransactionLogTransfer;

    /**
     * @param \Generated\Shared\Transfer\OptileRequestTransfer $optileRequestTransfer
     *
     * @return array
     */
    public function getPayload(OptileRequestTransfer $optileRequestTransfer): array;
}
