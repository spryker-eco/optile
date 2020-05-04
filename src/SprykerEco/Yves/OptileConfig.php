<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\Optile;

use Spryker\Zed\Kernel\AbstractBundleConfig;
use SprykerEco\Shared\Optile\OptileConstants;

class OptileConfig extends AbstractBundleConfig implements OptileConfigInterface
{
    /**
     * @return string
     */
    public function getYvesCheckoutSummaryStepUrl(): string
    {
        return $this->get(OptileConstants::CONFIG_YVES_CHECKOUT_SUMMARY_STEP_URL);
    }
}
