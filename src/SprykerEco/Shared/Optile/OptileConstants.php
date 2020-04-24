<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Shared\Optile;

/**
 * Declares global environment configuration keys. Do not use it for other class constants.
 */
interface OptileConstants
{
    /**
     * Secret payment token can be obtained in optile merchant portal.
     */
    public const CONFIG_OPTILE_PAYMENT_TOKEN = 'CONFIG_OPTILE_APPLICATION_TOKEN';

    /**
     * Secret merchant code can be obtained in optile merchant portal.
     */
    public const CONFIG_MERCHANT_CODE = 'CONFIG_MERCHANT_CODE';

    /**
     * Api domain
     */
    public const CONFIG_API_URL = 'CONFIG_API_URL';
}
