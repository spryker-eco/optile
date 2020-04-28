<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\Optile;

interface OptileConfigInterface
{
    /**
     * @return string
     */
    public function getBaseApiUrl(): string;

    /**
     * @return string
     */
    public function getMerchantCode(): string;

    /**
     * @return string
     */
    public function getPaymentToken(): string;

    /**
     * @return string
     */
    public function getPaymentSummaryUrl(): string;

    /**
     * @return string
     */
    public function getPaymentReturnUrl(): string;

    /**
     * @return string
     */
    public function getNotificationUrl(): string;

    /**
     * @return string
     */
    public function getIntegrationType(): string;
}
