<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Shared\Optile;

/**
 * Declares global environment configuration keys. Do not use it for other class constants.
 */
interface OptileConstants
{
    /**
     * Secret payment token can be obtained in optile merchant portal.
     *
     * @api
     */
    public const CONFIG_OPTILE_PAYMENT_TOKEN = 'CONFIG_OPTILE_APPLICATION_TOKEN';

    /**
     * Secret merchant code can be obtained in optile merchant portal.
     *
     * @api
     */
    public const CONFIG_MERCHANT_CODE = 'CONFIG_MERCHANT_CODE';

    /**
     * Cancel url callback.
     *
     * @api
     */
    public const CONFIG_YVES_CHECKOUT_PAYMENT_CANCEL_URL = 'CONFIG_YVES_CHECKOUT_PAYMENT_FAILED_URL';

    /**
     * Summary step url callback.
     *
     * @api
     */
    public const CONFIG_YVES_CHECKOUT_SUMMARY_STEP_URL = 'CONFIG_YVES_CHECKOUT_SUMMARY_STEP_URL';

    /**
     * Url where user will be directed after success payment, to process response from Optile.
     *
     * @api
     */
    public const CONFIG_YVES_CHECKOUT_PAYMENT_HANDLER_STEP_URL = 'CONFIG_YVES_CHECKOUT_PAYMENT_HANDLER_STEP_URL';

    /**
     * Notification handler url url callback.
     *
     * @api
     */
    public const CONFIG_YVES_CHECKOUT_NOTIFICATION_URL = 'CONFIG_YVES_CHECKOUT_NOTIFICATION_URL';

    /**
     * Url for success payment.
     *
     * @api
     */
    public const CONFIG_YVES_PAYMENT_SUCCESS_URL = 'CONFIG_YVES_CHECKOUT_NOTIFICATION_URL';

    /**
     * Main lists url.
     *
     * @api
     */
    public const CONFIG_BASE_API_URL = 'CONFIG_API_LIST_URL';

    /**
     * Integration type (ex. Hosted, Select Native ...).
     *
     * @api
     */
    public const CONFIG_YVES_CHECKOUT_INTEGRATION_TYPE = 'CONFIG_YVES_CHECKOUT_INTEGRATION_TYPE';

    /**
     * Is preset flow enabled.
     *
     * @api
     */
    public const IS_PRESET_ENABLED = 'IS_PRESET_ENABLED';

    /**
     * Is preselect flow enabled.
     *
     * @api
     */
    public const IS_PRESELECT_ENABLED = 'IS_PRESELECT_ENABLED';
}
