<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Client\Optile;

use Spryker\Client\Kernel\AbstractFactory;
use Spryker\Client\ZedRequest\ZedRequestClientFactoryTrait;
use SprykerEco\Client\Optile\Zed\OptileStub;
use SprykerEco\Client\Optile\Zed\OptileStubInterface;

class OptileFactory extends AbstractFactory
{
    use ZedRequestClientFactoryTrait;

    /**
     * @return \SprykerEco\Client\Optile\Zed\OptileStubInterface
     */
    public function createZedStub(): OptileStubInterface
    {
        return new OptileStub($this->getZedRequestClient());
    }
}
