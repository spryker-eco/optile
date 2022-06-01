<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Optile;

use Spryker\Yves\Kernel\AbstractFactory;
use Spryker\Yves\StepEngine\Dependency\Form\StepEngineFormDataProviderInterface;
use Spryker\Yves\StepEngine\Dependency\Form\SubFormInterface;
use SprykerEco\Yves\Optile\Dependency\Client\OptileToQuoteClientInterface;
use SprykerEco\Yves\Optile\Form\DataProvider\OptileSubFormDataProvider;
use SprykerEco\Yves\Optile\Form\OptileSubForm;
use SprykerEco\Yves\Optile\Mapper\OptileNotificationRequestMapper;
use SprykerEco\Yves\Optile\Mapper\OptileNotificationRequestMapperInterface;
use SprykerEco\Yves\Optile\QouteSetter\OptileQouteSetter;

/**
 * @method \SprykerEco\Yves\Optile\OptileConfig getConfig()
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
     * @return \SprykerEco\Yves\Optile\Mapper\OptileNotificationRequestMapperInterface
     */
    public function createOptileNotificationRequestMapper(): OptileNotificationRequestMapperInterface
    {
        return new OptileNotificationRequestMapper();
    }

    /**
     * @return \SprykerEco\Yves\Optile\QouteSetter\OptileQouteSetterInterface
     */
    public function createOptileQouteSetter()
    {
        return new OptileQouteSetter();
    }

    /**
     * @return \SprykerEco\Yves\Optile\Dependency\Client\OptileToQuoteClientInterface
     */
    public function getQuoteClient(): OptileToQuoteClientInterface
    {
        return $this->getProvidedDependency(OptileDependencyProvider::CLIENT_QUOTE);
    }
}
