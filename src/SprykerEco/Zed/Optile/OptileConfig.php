<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Optile;

use Spryker\Zed\Kernel\AbstractBundleConfig;
use SprykerEco\Shared\Optile\OptileConstants;

class OptileConfig extends AbstractBundleConfig implements OptileConfigInterface
{
    public const PAYMENT_PROVIDER_NAME = 'Optile';
    /**
     * Max value in Optile system.
     */
    public const MAX_3D_SECURE_CUSTOMER_SCORE = 1000;

    /**
     * @api
     *
     * @return string
     */
    public function getMerchantCode(): string
    {
        return $this->get(OptileConstants::CONFIG_MERCHANT_CODE);
    }

    /**
     * @api
     *
     * @return string
     */
    public function getPaymentToken(): string
    {
        return $this->get(OptileConstants::CONFIG_OPTILE_PAYMENT_TOKEN);
    }

    /**
     * @api
     *
     * @return string
     */
    public function getPaymentSummaryUrl(): string
    {
        return $this->get(OptileConstants::CONFIG_YVES_CHECKOUT_SUMMARY_STEP_URL);
    }

    /**
     * @api
     *
     * @return string
     */
    public function getNotificationUrl(): string
    {
        return $this->get(OptileConstants::CONFIG_YVES_CHECKOUT_NOTIFICATION_URL);
    }

    /**
     * @api
     *
     * @return string
     */
    public function getBaseApiUrl(): string
    {
        return $this->get(OptileConstants::CONFIG_BASE_API_URL);
    }

    /**
     * @api
     *
     * @return string
     */
    public function getIntegrationType(): string
    {
        return $this->get(OptileConstants::CONFIG_YVES_CHECKOUT_INTEGRATION_TYPE);
    }

    /**
     * @return int
     */
    public function getMax3dSecureScore(): int
    {
        return static::MAX_3D_SECURE_CUSTOMER_SCORE;
    }

    /**
     * @return string
     */
    public function getPaymentProviderName(): string
    {
        return static::PAYMENT_PROVIDER_NAME;
    }

    /**
     * @return bool
     */
    public function isPresetEnabled(): bool
    {
        return $this->get(OptileConstants::IS_PRESET_ENABLED);
    }
}
