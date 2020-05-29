<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optile\Business;

use GuzzleHttp\ClientInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use SprykerEco\Zed\Optile\Business\Oms\Conditions\OmsConditionInterface;
use SprykerEco\Zed\Optile\Business\Oms\Conditions\IsOrderCanceledOmsCondition;
use SprykerEco\Zed\Optile\Business\Oms\Conditions\IsOrderChargedOmsCondition;
use SprykerEco\Zed\Optile\Business\Oms\Conditions\IsOrderClosedOmsCondition;
use SprykerEco\Zed\Optile\Business\Oms\Conditions\IsOrderRefundedOmsCondition;
use SprykerEco\Zed\Optile\Business\Hook\CheckoutDoSaveHook;
use SprykerEco\Zed\Optile\Business\Hook\CheckoutDoSaveHookInterface;
use SprykerEco\Zed\Optile\Business\Hook\CheckoutPostSaveHook;
use SprykerEco\Zed\Optile\Business\Hook\CheckoutPostSaveHookInterface;
use SprykerEco\Zed\Optile\Business\HttpClient\OptileGuzzleHttpClient;
use SprykerEco\Zed\Optile\Business\HttpClient\OptileHttpClientInterface;
use SprykerEco\Zed\Optile\Business\Mapper\OptileRequestMapper;
use SprykerEco\Zed\Optile\Business\Mapper\OptileRequestMapperInterface;
use SprykerEco\Zed\Optile\Business\Oms\OmsEventTrigger;
use SprykerEco\Zed\Optile\Business\Oms\OmsEventTriggerInterface;
use SprykerEco\Zed\Optile\Business\Processor\NotificationProcessor;
use SprykerEco\Zed\Optile\Business\Processor\NotificationProcessorInterface;
use SprykerEco\Zed\Optile\Business\Request\ApiClient\OptileApiClient;
use SprykerEco\Zed\Optile\Business\Request\ApiClient\OptileApiClientInterface;
use SprykerEco\Zed\Optile\Business\Request\CancelRequest;
use SprykerEco\Zed\Optile\Business\Request\ChargeRequest;
use SprykerEco\Zed\Optile\Business\Request\CloseRequest;
use SprykerEco\Zed\Optile\Business\Request\ListRequest;
use SprykerEco\Zed\Optile\Business\Request\OptileApiRequestInterface;
use SprykerEco\Zed\Optile\Business\Request\RefundRequest;
use SprykerEco\Zed\Optile\Business\Writer\TransactionLogWriter;
use SprykerEco\Zed\Optile\Business\Writer\TransactionLogWriterInterface;
use SprykerEco\Zed\Optile\Dependency\Facade\OptileToOmsFacadeInterface;
use SprykerEco\Zed\Optile\Dependency\Facade\OptileToSalesFacadeInterface;
use SprykerEco\Zed\Optile\Dependency\Service\OptileToUtilEncodingServiceInterface;
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
            $this->createOptileGuzzleHttpClient(),
            $this->getConfig(),
            $this->createTransactionLogWriter(),
            $this->createOptileRequestMapper(),
            $this->createListRequest(),
            $this->getUtilEncodingService()
        );
    }

    /**
     * @return \SprykerEco\Zed\Optile\Business\Request\OptileApiRequestInterface
     */
    public function createListRequest(): OptileApiRequestInterface
    {
        return new ListRequest($this->getConfig(), $this->getRepository(), $this->getUtilEncodingService());
    }

    /**
     * @return \SprykerEco\Zed\Optile\Business\Request\ApiClient\OptileApiClientInterface
     */
    public function createChargeClient(): OptileApiClientInterface
    {
        return new OptileApiClient(
            $this->createOptileGuzzleHttpClient(),
            $this->getConfig(),
            $this->createTransactionLogWriter(),
            $this->createOptileRequestMapper(),
            $this->createChargeRequest(),
            $this->getUtilEncodingService()
        );
    }

    /**
     * @return \SprykerEco\Zed\Optile\Business\Request\OptileApiRequestInterface
     */
    public function createChargeRequest(): OptileApiRequestInterface
    {
        return new ChargeRequest($this->getConfig());
    }

    /**
     * @return \SprykerEco\Zed\Optile\Business\Request\ApiClient\OptileApiClientInterface
     */
    public function createCancelClient(): OptileApiClientInterface
    {
        return new OptileApiClient(
            $this->createOptileGuzzleHttpClient(),
            $this->getConfig(),
            $this->createTransactionLogWriter(),
            $this->createOptileRequestMapper(),
            $this->createCancelRequest(),
            $this->getUtilEncodingService()
        );
    }

    /**
     * @return \SprykerEco\Zed\Optile\Business\Request\OptileApiRequestInterface
     */
    public function createCancelRequest(): OptileApiRequestInterface
    {
        return new CancelRequest($this->getConfig(), $this->createOmsEventTrigger());
    }

    /**
     * @return \SprykerEco\Zed\Optile\Business\Request\ApiClient\OptileApiClientInterface
     */
    public function createRefundClient(): OptileApiClientInterface
    {
        return new OptileApiClient(
            $this->createOptileGuzzleHttpClient(),
            $this->getConfig(),
            $this->createTransactionLogWriter(),
            $this->createOptileRequestMapper(),
            $this->createRefundRequest(),
            $this->getUtilEncodingService()
        );
    }

    /**
     * @return \SprykerEco\Zed\Optile\Business\Request\OptileApiRequestInterface
     */
    public function createRefundRequest(): OptileApiRequestInterface
    {
        return new RefundRequest($this->getConfig(), $this->getEntityManager());
    }

    /**
     * @return \SprykerEco\Zed\Optile\Business\Request\ApiClient\OptileApiClientInterface
     */
    public function createCloseClient(): OptileApiClientInterface
    {
        return new OptileApiClient(
            $this->createOptileGuzzleHttpClient(),
            $this->getConfig(),
            $this->createTransactionLogWriter(),
            $this->createOptileRequestMapper(),
            $this->createCloseRequest(),
            $this->getUtilEncodingService()
        );
    }

    /**
     * @return \SprykerEco\Zed\Optile\Business\Request\OptileApiRequestInterface
     */
    public function createCloseRequest(): OptileApiRequestInterface
    {
        return new CloseRequest($this->getConfig(), $this->createOmsEventTrigger());
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
    public function createOptileGuzzleHttpClient(): OptileHttpClientInterface
    {
        return new OptileGuzzleHttpClient($this->getGuzzleClient());
    }

    /**
     * @return \GuzzleHttp\ClientInterface
     */
    public function getGuzzleClient(): ClientInterface
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
     * @return \SprykerEco\Zed\Optile\Business\Oms\Conditions\OmsConditionInterface
     */
    public function createIsOrderChargedCondition(): OmsConditionInterface
    {
        return new IsOrderChargedOmsCondition($this->getRepository());
    }

    /**
     * @return \SprykerEco\Zed\Optile\Business\Oms\Conditions\OmsConditionInterface
     */
    public function createIsOrderClosedCondition(): OmsConditionInterface
    {
        return new IsOrderClosedOmsCondition($this->getRepository());
    }

    /**
     * @return \SprykerEco\Zed\Optile\Business\Oms\Conditions\OmsConditionInterface
     */
    public function createIsOrderCanceledCondition(): OmsConditionInterface
    {
        return new IsOrderCanceledOmsCondition($this->getRepository());
    }

    /**
     * @return \SprykerEco\Zed\Optile\Business\Oms\Conditions\OmsConditionInterface
     */
    public function createIsOrderRefundedCondition(): OmsConditionInterface
    {
        return new IsOrderRefundedOmsCondition($this->getRepository());
    }

    /**
     * @return \SprykerEco\Zed\Optile\Dependency\Service\OptileToUtilEncodingServiceInterface
     */
    public function getUtilEncodingService(): OptileToUtilEncodingServiceInterface
    {
        return $this->getProvidedDependency(OptileDependencyProvider::SERVICE_UTIL_ENCODING);
    }

    /**
     * @return \SprykerEco\Zed\Optile\Dependency\Facade\OptileToSalesFacadeInterface
     */
    public function getSalesFacade(): OptileToSalesFacadeInterface
    {
        return $this->getProvidedDependency(OptileDependencyProvider::FACADE_SALES);
    }

    /**
     * @return \SprykerEco\Zed\Optile\Dependency\Facade\OptileToOmsFacadeInterface
     */
    public function getOmsFacade(): OptileToOmsFacadeInterface
    {
        return $this->getProvidedDependency(OptileDependencyProvider::FACADE_OMS);
    }

    /**
     * @return \SprykerEco\Zed\Optile\Business\Oms\OmsEventTriggerInterface
     */
    public function createOmsEventTrigger(): OmsEventTriggerInterface
    {
        return new OmsEventTrigger($this->getConfig(), $this->getSalesFacade(), $this->getOmsFacade());
    }
}
