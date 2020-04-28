<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\Optile\Form;

use Spryker\Yves\StepEngine\Dependency\Form\AbstractSubFormType;
use Spryker\Yves\StepEngine\Dependency\Form\SubFormInterface;
use Spryker\Yves\StepEngine\Dependency\Form\SubFormProviderNameInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

/**
 * @method \SprykerEco\Client\Optile\OptileClientInterface getClient()()
 */
class OptileCreditCardSubForm extends AbstractSubFormType implements SubFormInterface, SubFormProviderNameInterface
{
    public const PAYMENT_METHOD = 'OptileHosted';
    public const PAYMENT_PROVIDER = 'Optile';
    public const IFRAME_SRC_VAR_NAME = 'iframe_src';

    /**
     * @inheritDoc
     */
    protected function getTemplatePath()
    {
        return 'optile/hosted';
    }

    /**
     * @inheritDoc
     */
    public function getPropertyPath()
    {
        return static::PAYMENT_METHOD;
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return static::PAYMENT_METHOD;
    }

    /**
     * @inheritDoc
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

        $this->getClient()->makeListRequest();

        $view->vars[static::IFRAME_SRC_VAR_NAME] = $options[static::IFRAME_SRC_VAR_NAME];
    }
}
