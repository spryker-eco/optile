<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\Optile\Form\DataProvider;

use Spryker\Shared\Kernel\Transfer\AbstractTransfer;
use Spryker\Yves\StepEngine\Dependency\Form\StepEngineFormDataProviderInterface;

class OptileCreditCardSubFormDataProvider implements StepEngineFormDataProviderInterface
{
    /**
     * @inheritDoc
     */
    public function getData(AbstractTransfer $quoteTransfer)
    {
        return $quoteTransfer;
    }

    /**
     * @inheritDoc
     */
    public function getOptions(AbstractTransfer $quoteTransfer)
    {
        return [];
    }
}
