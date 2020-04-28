<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\Optile;

use Spryker\Yves\Kernel\AbstractFactory;
use Spryker\Yves\StepEngine\Dependency\Form\StepEngineFormDataProviderInterface;
use Spryker\Yves\StepEngine\Dependency\Form\SubFormInterface;
use SprykerEco\Yves\Optile\Form\DataProvider\OptileCreditCardSubFormDataProvider;
use SprykerEco\Yves\Optile\Form\OptileCreditCardSubForm;

class OptileFactory extends AbstractFactory
{
    /**
     * @return \Spryker\Yves\StepEngine\Dependency\Form\SubFormInterface
     */
    public function createOptileCreditCardSubForm(): SubFormInterface
    {
        return new OptileCreditCardSubForm();
    }

    /**
     * @return \Spryker\Yves\StepEngine\Dependency\Form\StepEngineFormDataProviderInterface
     */
    public function createOptileCreditCardSubFormDataProvider(): StepEngineFormDataProviderInterface
    {
        return new OptileCreditCardSubFormDataProvider();
    }
}
