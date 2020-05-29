<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optile\Communication\Plugin\Checkout\Oms\Command;

use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\Oms\Business\Util\ReadOnlyArrayObject;

/**
 * @method \SprykerEco\Zed\Optile\OptileConfig getConfig()
 */
abstract class AbstractOptilePaymentPlugin extends AbstractPlugin
{
    /**
     * @param \Spryker\Zed\Oms\Business\Util\ReadOnlyArrayObject $data
     *
     * @return bool
     */
    protected function isAutomaticOmsTrigger(ReadOnlyArrayObject $data): bool
    {
        return $data->offsetExists($this->getConfig()->getOptileAutomaticOmsTrigger());
    }
}
