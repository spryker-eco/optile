<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Optile\Business;

use Generated\Shared\Transfer\OptileNotificationRequestTransfer;
use Generated\Shared\Transfer\OptileNotificationResponseTransfer;
use Generated\Shared\Transfer\OptileRequestTransfer;
use Generated\Shared\Transfer\OptileResponseTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \SprykerEco\Zed\Optile\Business\OptileBusinessFactory getFactory()
 * @method \SprykerEco\Zed\Optile\Persistence\OptileEntityManagerInterface getEntityManager()
 * @method \SprykerEco\Zed\Optile\Persistence\OptileRepositoryInterface getRepository()
 */
class OptileFacade extends AbstractFacade implements OptileFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\OptileNotificationRequestTransfer $optileNotificationRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileNotificationResponseTransfer
     */
    public function processNotificationRequest(
        OptileNotificationRequestTransfer $optileNotificationRequestTransfer
    ): OptileNotificationResponseTransfer {
        return $this->getFactory()->createNotificationProcessor()->process($optileNotificationRequestTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\OptileRequestTransfer $optileRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileResponseTransfer
     */
    public function makeListRequest(OptileRequestTransfer $optileRequestTransfer): OptileResponseTransfer
    {
        return $this->getFactory()->createListRequest()->request($optileRequestTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\OptileRequestTransfer $optileRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileResponseTransfer
     */
    public function makeChargeRequest(OptileRequestTransfer $optileRequestTransfer): OptileResponseTransfer
    {
        // TODO: Implement makeChargeRequest() method.
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\OptileRequestTransfer $optileRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileResponseTransfer
     */
    public function makeCloseRequest(OptileRequestTransfer $optileRequestTransfer): OptileResponseTransfer
    {
        // TODO: Implement makeCloseRequest() method.
    }
}
