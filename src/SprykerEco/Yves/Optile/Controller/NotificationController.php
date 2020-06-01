<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Optile\Controller;

use Spryker\Yves\Kernel\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @method \SprykerEco\Yves\Optile\OptileFactory getFactory()
 * @method \SprykerEco\Client\Optile\OptileClientInterface getClient()()
 */
class NotificationController extends AbstractController
{
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function processNotificationAction(Request $request): Response
    {
        $optileNotificationRequestTransfer = $this->getFactory()
            ->createOptileNotificationRequestMapper()
            ->mapExternalRequestToNotificationRequestTransfer($request);

        $this->getClient()->processNotificationRequest($optileNotificationRequestTransfer);

        return new Response();
    }
}
