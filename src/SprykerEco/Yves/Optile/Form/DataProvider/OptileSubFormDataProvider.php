<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Optile\Form\DataProvider;

use Generated\Shared\Transfer\OptileSelectNativeTransfer;
use Generated\Shared\Transfer\PaymentTransfer;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;
use Spryker\Yves\StepEngine\Dependency\Form\StepEngineFormDataProviderInterface;
use SprykerEco\Yves\Optile\Form\OptileSubForm;

class OptileSubFormDataProvider implements StepEngineFormDataProviderInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function getData(AbstractTransfer $quoteTransfer)
    {
        if ($quoteTransfer->getPayment() === null) {
            $quoteTransfer->setPayment(new PaymentTransfer());
        }

        if ($quoteTransfer->getPayment()->getOptileSelectNative() === null) {
            $quoteTransfer->getPayment()->setOptileSelectNative(new OptileSelectNativeTransfer());
        }

        return $quoteTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return array
     */
    public function getOptions(AbstractTransfer $quoteTransfer)
    {
        return [
            OptileSubForm::FORM_FIELD_LONG_ID => $quoteTransfer->getOptileInitResponse()->getLongId(),
        ];
    }
}
