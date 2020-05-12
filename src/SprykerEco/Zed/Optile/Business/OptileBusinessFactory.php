<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optile\Business;

use Spryker\Service\UtilEncoding\UtilEncodingServiceInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use SprykerEco\Zed\Optile\Business\Hook\CheckoutDoSaveHook;
use SprykerEco\Zed\Optile\Business\Hook\CheckoutDoSaveHookInterface;
use SprykerEco\Zed\Optile\Business\Hook\CheckoutPostSaveHook;
use SprykerEco\Zed\Optile\Business\Hook\CheckoutPostSaveHookInterface;
use SprykerEco\Zed\Optile\Business\HttpClient\OptileGuzzleHttpClient;
use SprykerEco\Zed\Optile\Business\HttpClient\OptileHttpClientInterface;
use SprykerEco\Zed\Optile\Business\Mapper\OptileRequestMapper;
use SprykerEco\Zed\Optile\Business\Mapper\OptileRequestMapperInterface;
use SprykerEco\Zed\Optile\Business\Processor\NotificationProcessor;
use SprykerEco\Zed\Optile\Business\Processor\NotificationProcessorInterface;
use SprykerEco\Zed\Optile\Business\Reader\PaymentOptileReader;
use SprykerEco\Zed\Optile\Business\Reader\PaymentOptileReaderInterface;
use SprykerEco\Zed\Optile\Business\Request\ApiClient\OptileApiClient;
use SprykerEco\Zed\Optile\Business\Request\ApiClient\OptileApiClientInterface;
use SprykerEco\Zed\Optile\Business\Request\CancelRequest;
use SprykerEco\Zed\Optile\Business\Request\ChargeRequest;
use SprykerEco\Zed\Optile\Business\Request\CloseRequest;
use SprykerEco\Zed\Optile\Business\Request\ListRequest;
use SprykerEco\Zed\Optile\Business\Request\RefundRequest;
use SprykerEco\Zed\Optile\Business\Request\RequestInterface;
use SprykerEco\Zed\Optile\Business\Writer\TransactionLogWriter;
use SprykerEco\Zed\Optile\Business\Writer\TransactionLogWriterInterface;
use SprykerEco\Zed\Optile\OptileDependencyProvider;

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
     * @return \SprykerEco\Zed\Optile\Business\Request\ApiClient\OptileApiClientInterface
     */
    public function createListClient(): OptileApiClientInterface
    {
        return new OptileApiClient(
            $this->createGuzzleHttpClient(),
            $this->getConfig(),
            $this->createTransactionLogWriter(),
            $this->createOptileRequestMapper(),
            $this->createListRequest(),
            $this->getUtilEncodingService()
        );
    }

    /**
     * @return \SprykerEco\Zed\Optile\Business\Request\RequestInterface
     */
    public function createListRequest(): RequestInterface
    {
        return new ListRequest($this->getConfig(), $this->getRepository());
    }

    /**
     * @return \SprykerEco\Zed\Optile\Business\Request\ApiClient\OptileApiClientInterface
     */
    public function createChargeClient(): OptileApiClientInterface
    {
        return new OptileApiClient(
            $this->createGuzzleHttpClient(),
            $this->getConfig(),
            $this->createTransactionLogWriter(),
            $this->createOptileRequestMapper(),
            $this->createChargeRequest(),
            $this->getUtilEncodingService()
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
     * @return \SprykerEco\Zed\Optile\Business\Request\ApiClient\OptileApiClientInterface
     */
    public function createCancelClient(): OptileApiClientInterface
    {
        return new OptileApiClient(
            $this->createGuzzleHttpClient(),
            $this->getConfig(),
            $this->createTransactionLogWriter(),
            $this->createOptileRequestMapper(),
            $this->createCancelRequest(),
            $this->getUtilEncodingService()
        );
    }

    /**
     * @return \SprykerEco\Zed\Optile\Business\Request\RequestInterface
     */
    public function createCancelRequest(): RequestInterface
    {
        return new CancelRequest($this->getConfig());
    }

    /**
     * @return \SprykerEco\Zed\Optile\Business\Request\ApiClient\OptileApiClientInterface
     */
    public function createRefundClient(): OptileApiClientInterface
    {
        return new OptileApiClient(
            $this->createGuzzleHttpClient(),
            $this->getConfig(),
            $this->createTransactionLogWriter(),
            $this->createOptileRequestMapper(),
            $this->createRefundRequest(),
            $this->getUtilEncodingService()
        );
    }

    /**
     * @return \SprykerEco\Zed\Optile\Business\Request\RequestInterface
     */
    public function createRefundRequest(): RequestInterface
    {
        return new RefundRequest($this->getConfig());
    }

    /**
     * @return \SprykerEco\Zed\Optile\Business\Request\ApiClient\OptileApiClientInterface
     */
    public function createCloseClient(): OptileApiClientInterface
    {
        return new OptileApiClient(
            $this->createGuzzleHttpClient(),
            $this->getConfig(),
            $this->createTransactionLogWriter(),
            $this->createOptileRequestMapper(),
            $this->createCloseRequest(),
            $this->getUtilEncodingService()
        );
    }

    /**
     * @return \SprykerEco\Zed\Optile\Business\Request\RequestInterface
     */
    public function createCloseRequest(): RequestInterface
    {
        return new CloseRequest($this->getConfig());
    }

    /**
     * @return \SprykerEco\Zed\Optile\Business\Hook\CheckoutDoSaveHookInterface
     */
    public function createCheckoutDoSaveHook(): CheckoutDoSaveHookInterface
    {
        return new CheckoutDoSaveHook($this->getEntityManager());
    }

    /**
     * @return \SprykerEco\Zed\Optile\Business\Hook\CheckoutPostSaveHookInterface
     */
    public function createCheckoutPostSaveHook(): CheckoutPostSaveHookInterface
    {
        return new CheckoutPostSaveHook($this->createChargeClient());
    }

    /**
     * @return \SprykerEco\Zed\Optile\Business\HttpClient\OptileHttpClientInterface
     */
    public function createGuzzleHttpClient(): OptileHttpClientInterface
    {
        return new OptileGuzzleHttpClient($this->getGuzzleClient());
    }

    public function getGuzzleClient()
    {
        return $this->getProvidedDependency(OptileDependencyProvider::GUZZLE_CLIENT);
    }

    /**
     * @return \SprykerEco\Zed\Optile\Business\Writer\TransactionLogWriterInterface
     */
    public function createTransactionLogWriter(): TransactionLogWriterInterface
    {
        return new TransactionLogWriter($this->getEntityManager());
    }

    /**
     * @return \SprykerEco\Zed\Optile\Business\Mapper\OptileRequestMapperInterface
     */
    public function createOptileRequestMapper(): OptileRequestMapperInterface
    {
        return new OptileRequestMapper($this->getUtilEncodingService());
    }

    /**
     * @return \SprykerEco\Zed\Optile\Business\Reader\PaymentOptileReaderInterface
     */
    public function createPaymentOptileReader(): PaymentOptileReaderInterface
    {
        return new PaymentOptileReader($this->getRepository());
    }

    /**
     * @return \Spryker\Service\UtilEncoding\UtilEncodingServiceInterface
     */
    public function getUtilEncodingService(): UtilEncodingServiceInterface
    {
        return $this->getProvidedDependency(OptileDependencyProvider::UTIL_ENCODING_SERVICE);
    }
}
