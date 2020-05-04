<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\Optile\Controller;

use Spryker\Yves\Kernel\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @method \SprykerEco\Yves\Optile\OptileFactory getFactory()
 * @method \SprykerEco\Client\Optile\OptileClientInterface getClient()()
 */
class NotificationController extends AbstractController
{
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function processNotificationAction(Request $request)
    {
        if (!$request->isMethod(Request::METHOD_POST)) {
            throw new NotFoundHttpException();
        }

        $this->getClient()->processNotificationRequest(
            $this->getFactory()->createOptileNotificationRequestToOptileNotificationTransferMapper()->map($request)
        );

        return new Response();
    }
}
