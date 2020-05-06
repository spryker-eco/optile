<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optile\Business;

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\ClientInterface as GuzzleHttpClientInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use SprykerEco\Zed\Optile\Business\Hook\CheckoutDoSaveHook;
use SprykerEco\Zed\Optile\Business\Hook\CheckoutDoSaveHookInterface;
use SprykerEco\Zed\Optile\Business\Mapper\OptileRequestToTransactionLog;
use SprykerEco\Zed\Optile\Business\Mapper\OptileRequestToTransactionLogInterface;
use SprykerEco\Zed\Optile\Business\Processor\NotificationProcessor;
use SprykerEco\Zed\Optile\Business\Processor\NotificationProcessorInterface;
use SprykerEco\Zed\Optile\Business\Reader\PaymentOptileReader;
use SprykerEco\Zed\Optile\Business\Reader\PaymentOptileReaderInterface;
use SprykerEco\Zed\Optile\Business\Request\ApiClient\Client;
use SprykerEco\Zed\Optile\Business\Request\ApiClient\ClientInterface;
use SprykerEco\Zed\Optile\Business\Request\CancelRequest;
use SprykerEco\Zed\Optile\Business\Request\ChargeRequest;
use SprykerEco\Zed\Optile\Business\Request\CloseRequest;
use SprykerEco\Zed\Optile\Business\Request\ListRequest;
use SprykerEco\Zed\Optile\Business\Request\RefundRequest;
use SprykerEco\Zed\Optile\Business\Request\RequestInterface;
use SprykerEco\Zed\Optile\Business\Writer\PaymentOptileWriter;
use SprykerEco\Zed\Optile\Business\Writer\PaymentOptileWriterWriterInterface;
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
        return new NotificationProcessor($this->getEntityManager());
    }

    /**
     * @return \SprykerEco\Zed\Optile\Business\Request\ApiClient\ClientInterface
     */
    public function createListClient(): ClientInterface
    {
        return new Client(
            $this->createHttpClient(),
            $this->getConfig(),
            $this->createTransactionLogWriter(),
            $this->createOptileRequestToTransactionLogMapper(),
            $this->createListRequest()
        );
    }

    /**
     * @return \SprykerEco\Zed\Optile\Business\Request\RequestInterface
     */
    public function createListRequest(): RequestInterface
    {
        return new ListRequest($this->getConfig());
    }

    /**
     * @return \SprykerEco\Zed\Optile\Business\Request\ApiClient\ClientInterface
     */
    public function createChargeClient(): ClientInterface
    {
        return new Client(
            $this->createHttpClient(),
            $this->getConfig(),
            $this->createTransactionLogWriter(),
            $this->createOptileRequestToTransactionLogMapper(),
            $this->createChargeRequest()
        );
    }

    /**
     * @return \SprykerEco\Zed\Optile\Business\Request\RequestInterface
     */
    public function createChargeRequest(): RequestInterface
    {
        return new ChargeRequest($this->getConfig());
    }

    /**
     * @return \SprykerEco\Zed\Optile\Business\Request\ApiClient\ClientInterface
     */
    public function createCancelClient(): ClientInterface
    {
        return new Client(
            $this->createHttpClient(),
            $this->getConfig(),
            $this->createTransactionLogWriter(),
            $this->createOptileRequestToTransactionLogMapper(),
            $this->createCancelRequest()
        );
    }

    /**
     * @return \SprykerEco\Zed\Optile\Business\Request\RequestInterface
     */
    public function createCancelRequest(): RequestInterface
    {
        return new CancelRequest();
    }

    /**
     * @return \SprykerEco\Zed\Optile\Business\Request\ApiClient\ClientInterface
     */
    public function createRefundClient(): ClientInterface
    {
        return new Client(
            $this->createHttpClient(),
            $this->getConfig(),
            $this->createTransactionLogWriter(),
            $this->createOptileRequestToTransactionLogMapper(),
            $this->createRefundRequest()
        );
    }

    /**
     * @return \SprykerEco\Zed\Optile\Business\Request\RequestInterface
     */
    public function createRefundRequest(): RequestInterface
    {
        return new RefundRequest();
    }

    /**
     * @return \SprykerEco\Zed\Optile\Business\Request\ApiClient\ClientInterface
     */
    public function createCloseClient(): ClientInterface
    {
        return new Client(
            $this->createHttpClient(),
            $this->getConfig(),
            $this->createTransactionLogWriter(),
            $this->createOptileRequestToTransactionLogMapper(),
            $this->createCloseRequest()
        );
    }

    /**
     * @return \SprykerEco\Zed\Optile\Business\Request\RequestInterface
     */
    public function createCloseRequest(): RequestInterface
    {
        new CloseRequest();
    }

    /**
     * @return \SprykerEco\Zed\Optile\Business\Hook\CheckoutDoSaveHookInterface
     */
    public function createDoSaveHook(): CheckoutDoSaveHookInterface
    {
        return new CheckoutDoSaveHook($this->createPaymentOptileWriter());
    }

    /**
     * @return \SprykerEco\Zed\Optile\Business\Writer\PaymentOptileWriterWriterInterface
     */
    public function createPaymentOptileWriter(): PaymentOptileWriterWriterInterface
    {
        return new PaymentOptileWriter($this->getEntityManager());
    }

    /**
     * @return \SprykerEco\Zed\Optile\Business\Writer\TransactionLogWriterInterface
     */
    public function createTransactionLogWriter(): TransactionLogWriterInterface
    {
        return new TransactionLogWriter($this->getEntityManager());
    }

    /**
     * @return \SprykerEco\Zed\Optile\Business\Mapper\OptileRequestToTransactionLogInterface
     */
    public function createOptileRequestToTransactionLogMapper(): OptileRequestToTransactionLogInterface
    {
        return new OptileRequestToTransactionLog();
    }

    /**
     * @return \SprykerEco\Zed\Optile\Business\Reader\PaymentOptileReaderInterface
     */
    public function createPaymentOptileReader(): PaymentOptileReaderInterface
    {
        return new PaymentOptileReader($this->getRepository());
    }

    /**
     * @return \GuzzleHttp\ClientInterface
     */
    public function createHttpClient(): GuzzleHttpClientInterface
    {
        return new GuzzleHttpClient();
    }
}
