<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\Optile;

use Spryker\Yves\Kernel\AbstractFactory;
use Spryker\Yves\StepEngine\Dependency\Form\StepEngineFormDataProviderInterface;
use Spryker\Yves\StepEngine\Dependency\Form\SubFormInterface;
use SprykerEco\Yves\Optile\Dependency\Client\OptileToQuoteClientInterface;
use SprykerEco\Yves\Optile\Form\DataProvider\OptileSubFormDataProvider;
use SprykerEco\Yves\Optile\Form\OptileSubForm;
use SprykerEco\Yves\Optile\Mapper\OptileNotificationRequestToOptileNotificationTransfer;
use SprykerEco\Yves\Optile\Mapper\OptileNotificationRequestToOptileNotificationTransferInterface;

/**
 * @method \SprykerEco\Yves\Optile\OptileConfigInterface getConfig()
 */
class OptileFactory extends AbstractFactory
{
    /**
     * @return \Spryker\Yves\StepEngine\Dependency\Form\SubFormInterface
     */
    public function createOptileSubForm(): SubFormInterface
    {
        return new OptileSubForm();
    }

    /**
     * @return \Spryker\Yves\StepEngine\Dependency\Form\StepEngineFormDataProviderInterface
     */
    public function createOptileSubFormDataProvider(): StepEngineFormDataProviderInterface
    {
        return new OptileSubFormDataProvider();
    }

    /**
     * @return \SprykerEco\Yves\Optile\Mapper\OptileNotificationRequestToOptileNotificationTransferInterface
     */
    public function createOptileNotificationRequestToOptileNotificationTransferMapper(): OptileNotificationRequestToOptileNotificationTransferInterface
    {
        return new OptileNotificationRequestToOptileNotificationTransfer();
    }

    /**
     * @return \SprykerEco\Yves\Optile\Dependency\Client\OptileToQuoteClientInterface
     */
    public function getQuoteClient(): OptileToQuoteClientInterface
    {
        return $this->getProvidedDependency(OptileDependencyProvider::CLIENT_QUOTE);
    }
}
