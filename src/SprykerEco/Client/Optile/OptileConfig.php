<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Client\Optile;

use Spryker\Zed\Kernel\AbstractBundleConfig;
use SprykerEco\Shared\Optile\OptileConstants;

class OptileConfig extends AbstractBundleConfig
{
    protected const LISTS_REQUEST__PATH = '/lists';

    /**
     * @api
     *
     * @return string
     */
    public function getMerchantCode()
    {
        return $this->get(OptileConstants::CONFIG_MERCHANT_CODE);
    }

    /**
     * @api
     *
     * @return string
     */
    public function getApiUrl()
    {
        return $this->get(OptileConstants::CONFIG_API_URL);
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
}
