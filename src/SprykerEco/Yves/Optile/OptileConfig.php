<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\Optile;

use Spryker\Yves\Kernel\AbstractBundleConfig;
use SprykerEco\Shared\Optile\OptileConstants;

class OptileConfig extends AbstractBundleConfig implements OptileConfigInterface
{
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
    public function getPaymentReturnUrl(): string
    {
        return $this->get(OptileConstants::CONFIG_YVES_CHECKOUT_PAYMENT_RETURN_URL);
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
}
