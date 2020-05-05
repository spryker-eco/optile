<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\Optile\Form;

use Generated\Shared\Transfer\OptileHostedPaymentTransfer;
use Spryker\Yves\StepEngine\Dependency\Form\AbstractSubFormType;
use Spryker\Yves\StepEngine\Dependency\Form\SubFormInterface;
use Spryker\Yves\StepEngine\Dependency\Form\SubFormProviderNameInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @method \SprykerEco\Client\Optile\OptileClientInterface getClient()()
 */
class OptileSubForm extends AbstractSubFormType implements SubFormInterface, SubFormProviderNameInterface
{
    public const PAYMENT_METHOD = 'OptileHosted';
    public const PAYMENT_PROVIDER = 'Optile';
    public const LONG_ID = 'longId';

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
           'data_class' => OptileHostedPaymentTransfer::class,
            SubFormInterface::OPTIONS_FIELD_NAME => []
        ]);
    }

    /**
     * @return string
     */
    protected function getTemplatePath()
    {
        return 'optile/hosted';
    }

    /**
     * @return string
     */
    public function getPropertyPath()
    {
        return static::PAYMENT_METHOD;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return static::PAYMENT_METHOD;
    }

    /**
     * @return string
     */
    public function getProviderName()
    {
        return static::PAYMENT_PROVIDER;
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

        $view->vars[static::LONG_ID] = $options[static::OPTIONS_FIELD_NAME][static::LONG_ID];
    }
}