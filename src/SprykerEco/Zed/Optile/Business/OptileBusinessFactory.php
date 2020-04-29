<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Optile\Business;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use SprykerEco\Zed\Optile\Business\Mapper\OptileListsRequestToTransactionLog;
use SprykerEco\Zed\Optile\Business\Mapper\OptileRequestToTransactionLogInterface;
use SprykerEco\Zed\Optile\Business\Processor\NotificationProcessor;
use SprykerEco\Zed\Optile\Business\Processor\NotificationProcessorInterface;
use SprykerEco\Zed\Optile\Business\Request\ListRequest;
use SprykerEco\Zed\Optile\Business\Request\RequestInterface;
use SprykerEco\Zed\Optile\Business\Writer\NotificationWriter;
use SprykerEco\Zed\Optile\Business\Writer\NotificationWriterInterface;
use SprykerEco\Zed\Optile\Business\Writer\TransactionLogWriter;
use SprykerEco\Zed\Optile\Business\Writer\TransactionLogWriterInterface;

/**
 * @method \SprykerEco\Zed\Optile\OptileConfig getConfig()
 * @method \SprykerEco\Zed\Optile\Persistence\OptileEntityManagerInterface getEntityManager()
 * @method \SprykerEco\Zed\Optile\Persistence\OptileRepositoryInterface getRepository()
 */
class OptileBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \SprykerEco\Zed\Optile\Business\Processor\NotificationProcessor
     */
    public function createNotificationProcessor(): NotificationProcessorInterface
    {
        return new NotificationProcessor($this->createNotificationWriter());
    }

    /**
     * @return \SprykerEco\Zed\Optile\Business\Request\RequestInterface
     */
    public function createListRequest(): RequestInterface
    {
        return new ListRequest(
            $this->createHttpClient(),
            $this->getConfig(),
            $this->createTransactionLogWriter(),
            $this->createOptileListsRequestToTransactionLogMapper()
        );
    }

    /**
     * @return \SprykerEco\Zed\Optile\Business\Writer\NotificationWriterInterface
     */
    protected function createNotificationWriter(): NotificationWriterInterface
    {
        return new NotificationWriter($this->getEntityManager());
    }

    /**
     * @return \SprykerEco\Zed\Optile\Business\Writer\TransactionLogWriterInterface
     */
    protected function createTransactionLogWriter(): TransactionLogWriterInterface
    {
        return new TransactionLogWriter($this->getEntityManager());
    }

    /**
     * @return \SprykerEco\Zed\Optile\Business\Mapper\OptileRequestToTransactionLogInterface
     */
    protected function createOptileListsRequestToTransactionLogMapper(): OptileRequestToTransactionLogInterface
    {
        return new OptileListsRequestToTransactionLog();
    }

    /**
     * @return \GuzzleHttp\ClientInterface
     */
    protected function createHttpClient(): ClientInterface
    {
        return new Client();
    }
}
