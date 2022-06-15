<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optile\Business\Request;

use Generated\Shared\Transfer\OptileRequestTransfer;
use Generated\Shared\Transfer\OptileResponseTransfer;
use SprykerEco\Zed\Optile\Dependency\Service\OptileToUtilEncodingServiceInterface;
use SprykerEco\Zed\Optile\OptileConfig;
use SprykerEco\Zed\Optile\Persistence\OptileRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;

class ListRequest implements OptileApiRequestInterface
{
    /**
     * @var string
     */
    protected const SUCCESS_RESPONSE_CODE = 'OK';

    /**
     * @var string
     */
    protected const LISTS_URL_PATH = '%s/lists';

    /**
     * @var string
     */
    protected const ERROR_MESSAGE_LONG_ID_OR_SELF_LINK_EMPTY = 'Required fields: identification.longId, links.self  can\'t be empty';

    /**
     * @var array<string,string>
     */
    protected const PRESELECTION_PAYLOAD = [
        'deferral' => 'DEFERRED',
        'direction' => 'CHARGE',
    ];

    /**
     * @var \SprykerEco\Zed\Optile\OptileConfig
     */
    protected $optileConfig;

    /**
     * @var \SprykerEco\Zed\Optile\Persistence\OptileRepositoryInterface
     */
    protected $optileRepository;

    /**
     * @var \SprykerEco\Zed\Optile\Dependency\Service\OptileToUtilEncodingServiceInterface
     */
    protected $utilEncodingService;

    /**
     * @param \SprykerEco\Zed\Optile\OptileConfig $optileConfig
     * @param \SprykerEco\Zed\Optile\Persistence\OptileRepositoryInterface $optileRepository
     * @param \SprykerEco\Zed\Optile\Dependency\Service\OptileToUtilEncodingServiceInterface $utilEncodingService
     */
    public function __construct(
        OptileConfig                         $optileConfig,
        OptileRepositoryInterface            $optileRepository,
        OptileToUtilEncodingServiceInterface $utilEncodingService
    )
    {
        $this->optileConfig = $optileConfig;
        $this->optileRepository = $optileRepository;
        $this->utilEncodingService = $utilEncodingService;
    }

    /**
     * @param array<string,mixed> $responseData
     * @param \Generated\Shared\Transfer\OptileRequestTransfer $optileRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileResponseTransfer
     */
    public function handleResponse(array $responseData, OptileRequestTransfer $optileRequestTransfer): OptileResponseTransfer
    {
        if (empty($responseData['identification']['longId'] || empty($responseData['links']['self']))) {
            return (new OptileResponseTransfer())->setIsSuccess(false)
                ->setError(static::ERROR_MESSAGE_LONG_ID_OR_SELF_LINK_EMPTY);
        }

        return (new OptileResponseTransfer())
            ->setPaymentReference($optileRequestTransfer->getPaymentReference())
            ->setIsSuccess(true)
            ->setOperation($responseData['operation'] ?? '')
            ->setLongId($responseData['identification']['longId'])
            ->setSelfLink($responseData['links']['self']);
    }

    /**
     * @param \Generated\Shared\Transfer\OptileRequestTransfer $optileRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileRequestTransfer
     */
    public function configureRequest(OptileRequestTransfer $optileRequestTransfer): OptileRequestTransfer
    {
        $optileRequestTransfer
            ->setIntegration($this->optileConfig->getIntegrationType())
            ->setCallbackNotificationUrl($this->optileConfig->getNotificationUrl())
            ->setCallbackPaymentHandlerUrl($this->optileConfig->getPaymentHandlerStepUrl())
            ->setCallbackCancelUrl($this->optileConfig->getCheckoutCancelUrl())
            ->setRequestUrl(sprintf(static::LISTS_URL_PATH, $this->optileConfig->getBaseApiUrl()))
            ->setPresetFirst($this->optileConfig->isPresetEnabled());

        if (!$optileRequestTransfer->getCustomerScore()) {
            $optileRequestTransfer->setCustomerScore($this->optileConfig->getMax3dSecureScore());
        }

        $requestPayload = $this->getRequestPayload($optileRequestTransfer);

        $optileRequestTransfer->setRequestPayload($requestPayload);

        return $optileRequestTransfer;
    }

    /**
     * @return string
     */
    public function getRequestMethod(): string
    {
        return Request::METHOD_POST;
    }

    /**
     * @param \Generated\Shared\Transfer\OptileRequestTransfer $optileRequestTransfer
     *
     * @return array
     */
    protected function getRequestPayload(OptileRequestTransfer $optileRequestTransfer): array
    {
        $payload = [
            'transactionId' => $optileRequestTransfer->getTransactionId(),
            'integration' => $optileRequestTransfer->getIntegration(),
            'presetFirst' => $optileRequestTransfer->getPresetFirst(),
            'country' => $optileRequestTransfer->getCountry(),
            'customer' => [
                'number' => $optileRequestTransfer->getIdCustomer(),
                'email' => $optileRequestTransfer->getCustomerEmail(),
            ],
            'payment' => [
                'amount' => $this->getPaymentAmount($optileRequestTransfer->getPaymentAmount()),
                'currency' => $optileRequestTransfer->getPaymentCurrency(),
                'reference' => $optileRequestTransfer->getPaymentReference(),
            ],
            'callback' => [
                'returnUrl' => $optileRequestTransfer->getCallbackPaymentHandlerUrl(),
                'cancelUrl' => $optileRequestTransfer->getCallbackCancelUrl(),
                'summaryUrl' => $optileRequestTransfer->getCallbackPaymentHandlerUrl(),
                'notificationUrl' => $optileRequestTransfer->getCallbackNotificationUrl(),
            ],
            'clientInfo' => [
                'ip' => $optileRequestTransfer->getCustomerIp(),
                'userAgent' => $optileRequestTransfer->getClientUserAgent(),
                'acceptHeader' => $this->utilEncodingService->encodeJson(
                    $optileRequestTransfer->getClientAcceptableContentTypes(),
                ),
            ],
            'products' => $this->getOrderItemsPayload($optileRequestTransfer),
            'customerScore' => $optileRequestTransfer->getCustomerScore(),
        ];

        $payload = $this->addPreselectToRequestPayload($payload);
        $payload = $this->addRegistrationToRequestPayload($optileRequestTransfer, $payload);

        return $payload;
    }

    /**
     * @param \Generated\Shared\Transfer\OptileRequestTransfer $optileRequestTransfer
     *
     * @return array
     */
    protected function getOrderItemsPayload(OptileRequestTransfer $optileRequestTransfer): array
    {
        $products = [];

        foreach ($optileRequestTransfer->getOrderItems() as $orderItem) {
            $products[] = [
                'code' => $orderItem['code'],
                'name' => $orderItem['name'],
                'quantity' => $orderItem['quantity'],
                'amount' => $this->getPaymentAmount($orderItem['amount']),
            ];
        }

        return $products;
    }

    /**
     * @param int $amount
     *
     * @return float
     */
    protected function getPaymentAmount(int $amount): float
    {
        return $amount / 100;
    }

    /**
     * @param array $payload
     *
     * @return array
     */
    protected function addPreselectToRequestPayload(array $payload): array
    {
        if ($this->optileConfig->isPreselectEnabled()) {
            $payload['preselection'] = static::PRESELECTION_PAYLOAD;
        }

        return $payload;
    }

    /**
     * @param \Generated\Shared\Transfer\OptileRequestTransfer $optileRequestTransfer
     * @param array $payload
     *
     * @return array
     */
    protected function addRegistrationToRequestPayload(OptileRequestTransfer $optileRequestTransfer, array $payload): array
    {
        $customerRegistration = $this->optileRepository->findOptileCustomerRegistrationByEmail(
            $optileRequestTransfer->getCustomerEmail(),
        );

        if ($customerRegistration) {
            $payload['customer']['registration'] = [
                'id' => $customerRegistration->getCustomerRegistrationId(),
                'password' => $customerRegistration->getCustomerRegistrationHash(),
            ];
        }

        return $payload;
    }

    /**
     * @param array<string,mixed> $responseData
     *
     * @return bool
     */
    public function isFailedRequest(array $responseData): bool
    {
        return
            empty($responseData['returnCode']['name'])
            ||
            $responseData['returnCode']['name'] != static::SUCCESS_RESPONSE_CODE;
    }
}
