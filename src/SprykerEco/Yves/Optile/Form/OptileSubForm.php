<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Optile\Form;

use Generated\Shared\Transfer\OptileSelectNativeTransfer;
use Spryker\Yves\StepEngine\Dependency\Form\AbstractSubFormType;
use Spryker\Yves\StepEngine\Dependency\Form\SubFormInterface;
use Spryker\Yves\StepEngine\Dependency\Form\SubFormProviderNameInterface;
use SprykerEco\Shared\Optile\OptileConfig;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @method \SprykerEco\Client\Optile\OptileClientInterface getClient()
 */
class OptileSubForm extends AbstractSubFormType implements SubFormInterface, SubFormProviderNameInterface
{
    public const FORM_FIELD_LONG_ID = 'longId';

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
           'data_class' => OptileSelectNativeTransfer::class,
            SubFormInterface::OPTIONS_FIELD_NAME => [],
        ]);
    }

    /**
     * @return string
     */
    protected function getTemplatePath()
    {
        return 'optile/select-native';
    }

    /**
     * @return string
     */
    public function getPropertyPath()
    {
        return OptileConfig::PAYMENT_METHOD_NAME;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return OptileConfig::PAYMENT_METHOD_NAME;
    }

    /**
     * @return string
     */
    public function getProviderName()
    {
        return OptileConfig::PAYMENT_PROVIDER_NAME;
    }

    /**
     * @param \Symfony\Component\Form\FormView $view
     * @param \Symfony\Component\Form\FormInterface $form
     * @param array $options
     *
     * @return void
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);

        $view->vars[static::FORM_FIELD_LONG_ID] = $options[static::OPTIONS_FIELD_NAME][static::FORM_FIELD_LONG_ID];
    }
}
