<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\Optile\Plugin\Subform;

use Spryker\Yves\Kernel\AbstractPlugin;
use Spryker\Yves\StepEngine\Dependency\Plugin\Form\SubFormPluginInterface;

/**
 * @method \SprykerEco\Yves\Optile\OptileFactory getFactory()
 */
class OptileSubFormPlugin extends AbstractPlugin implements SubFormPluginInterface
{
    /**
     * @inheritDoc
     */
    public function createSubForm()
    {
        return $this->getFactory()->createOptileSubForm();
    }

    /**
     * @inheritDoc
     */
    public function createSubFormDataProvider()
    {
        return $this->getFactory()->createOptileSubFormDataProvider();
    }
}
