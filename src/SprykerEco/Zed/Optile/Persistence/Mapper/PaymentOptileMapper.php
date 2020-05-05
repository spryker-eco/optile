<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Optile\Persistence\Mapper;

use Generated\Shared\Transfer\PaymentOptileTransfer;
use Orm\Zed\Optile\Persistence\SpyPaymentOptile;

class PaymentOptileMapper implements PaymentOptileMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\PaymentOptileTransfer $paymentOptileTransfer
     * @param \Orm\Zed\Optile\Persistence\SpyPaymentOptile $spyPaymentOptile
     *
     * @return \Orm\Zed\Optile\Persistence\SpyPaymentOptile
     */
    public function mapPaymentOptileTransferToEntity(
        PaymentOptileTransfer $paymentOptileTransfer,
        SpyPaymentOptile $spyPaymentOptile
    ): SpyPaymentOptile {
        $spyPaymentOptile->fromArray(
            $paymentOptileTransfer->toArray()
        );

        return $spyPaymentOptile;
    }

    /**
     * @param \Generated\Shared\Transfer\PaymentOptileTransfer $paymentOptileTransfer
     * @param \Orm\Zed\Optile\Persistence\SpyPaymentOptile $spyPaymentOptile
     *
     * @return \Generated\Shared\Transfer\PaymentOptileTransfer
     */
    public function mapPaymentOptileEntityToTransfer(
        PaymentOptileTransfer $paymentOptileTransfer,
        SpyPaymentOptile $spyPaymentOptile
    ): PaymentOptileTransfer {
        return $paymentOptileTransfer->fromArray(
            $spyPaymentOptile->toArray()
        );
    }
}
