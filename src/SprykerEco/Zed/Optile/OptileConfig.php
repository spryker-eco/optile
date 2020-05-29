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
     * Flag specify that oms event was triggered by internal system (automatically).
     */
    protected const AUTOMATIC_OMS_TRIGGER = 'AUTOMATIC_OMS_TRIGGER';

    /**
     * Oms close request sent state name.
     */
    protected const OMS_EVENT_SEND_CLOSE_REQUEST = 'send close request';

    /**
     * Oms cancel request sent state name.
     */
    protected const OMS_EVENT_SEND_CANCEL_REQUEST = 'send cancel request';

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
    public function getOptileAutomaticOmsTrigger(): string
    {
        return static::AUTOMATIC_OMS_TRIGGER;
    }

    /**
     * @api
     *
     * @return string
     */
    public function getOmsEventNameSendCloseRequest(): string
    {
        return static::OMS_EVENT_SEND_CLOSE_REQUEST;
    }

    /**
     * @api
     *
     * @return string
     */
    public function getOmsEventNameSendCancelRequest(): string
    {
        return static::OMS_EVENT_SEND_CANCEL_REQUEST;
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

    /**
     * @api
     *
     * @return bool
     */
    public function isPreselectEnabled(): bool
    {
        return $this->get(OptileConstants::IS_PRESELECT_ENABLED);
    }
}
