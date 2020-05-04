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
     * Cancel url callback
     */
    public const CONFIG_YVES_CHECKOUT_PAYMENT_CANCEL_URL = 'CONFIG_YVES_CHECKOUT_PAYMENT_FAILED_URL';

    /**
     * Summary step url callback
     */
    public const CONFIG_YVES_CHECKOUT_SUMMARY_STEP_URL = 'CONFIG_YVES_CHECKOUT_SUMMARY_STEP_URL';

    /**
     * Notification handler url url callback
     */
    public const CONFIG_YVES_CHECKOUT_NOTIFICATION_URL = 'CONFIG_YVES_CHECKOUT_NOTIFICATION_URL';

    /**
     * Url for success payment.
     */
    public const CONFIG_YVES_PAYMENT_SUCCESS_URL = 'CONFIG_YVES_CHECKOUT_NOTIFICATION_URL';

    /**
     * Main lists url
     */
    public const CONFIG_BASE_API_URL = 'CONFIG_API_LIST_URL';

    /**
     * Integration type (ex. Hosted, Select Native ...)
     */
    public const CONFIG_YVES_CHECKOUT_INTEGRATION_TYPE = 'CONFIG_YVES_CHECKOUT_INTEGRATION_TYPE';

    /**
     * Is preset flow enabled
     */
    public const IS_PRESET_ENABLED = 'IS_PRESET_ENABLED';
}
