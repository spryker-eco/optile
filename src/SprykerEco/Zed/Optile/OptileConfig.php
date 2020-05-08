<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optile;

use Spryker\Zed\Kernel\AbstractBundleConfig;
use SprykerEco\Shared\Optile\OptileConfig as SharedOptileConfig;
use SprykerEco\Shared\Optile\OptileConstants;

class OptileConfig extends AbstractBundleConfig
{
    /**
     * Max value in Optile system.
     */
    protected const MAX_3D_SECURE_CUSTOMER_SCORE = 1000;

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
    public function getPaymentHandlerStepUrl(): string
    {
        return $this->get(OptileConstants::CONFIG_YVES_CHECKOUT_PAYMENT_HANDLER_STEP_URL);
    }

    /**
     * @api
     *
     * @return string
     */
    public function getCheckoutCancelUrl(): string
    {
        return $this->get(OptileConstants::CONFIG_YVES_CHECKOUT_PAYMENT_CANCEL_URL);
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
     * @api
     *
     * @return int
     */
    public function getMax3dSecureScore(): int
    {
        return static::MAX_3D_SECURE_CUSTOMER_SCORE;
    }

    /**
     * @api
     *
     * @return string
     */
    public function getPaymentProviderName(): string
    {
        return SharedOptileConfig::PAYMENT_PROVIDER_NAME;
    }

    /**
     * @api
     *
     * @return bool
     */
    public function isPresetEnabled(): bool
    {
        return $this->get(OptileConstants::IS_PRESET_ENABLED);
    }
}
