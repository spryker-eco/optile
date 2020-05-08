<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Client\Optile;

use Spryker\Client\Kernel\AbstractFactory;
use SprykerEco\Client\Optile\Dependency\Client\OptileToZedRequestClientInterface;
use SprykerEco\Client\Optile\Zed\OptileStub;
use SprykerEco\Client\Optile\Zed\OptileStubInterface;

class OptileFactory extends AbstractFactory
{
    /**
     * @return \SprykerEco\Client\Optile\Zed\OptileStubInterface
     */
    public function createOptileZedStub(): OptileStubInterface
    {
        return new OptileStub($this->getZedRequest());
    }

    /**
     * @return \SprykerEco\Client\Optile\Dependency\Client\OptileToZedRequestClientInterface
     */
    public function getZedRequest(): OptileToZedRequestClientInterface
    {
        return $this->getProvidedDependency(OptileDependencyProvider::CLIENT_ZED_REQUEST);
    }
}
