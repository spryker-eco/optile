<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Optile\Persistence;

use Generated\Shared\Transfer\PaymentOptileTransfer;

interface OptileRepositoryInterface
{
    /**
     * @param int $optileRequestTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentOptileTransfer
     */
    public function getOptilePaymentByIdSalesOrder(int $optileRequestTransfer): PaymentOptileTransfer;
}
