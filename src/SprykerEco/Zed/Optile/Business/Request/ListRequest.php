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
    protected const LISTS_URL_PATH = '%s/lists';

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
    private $utilEncodingService;

    /**
     * @param \SprykerEco\Zed\Optile\OptileConfig $optileConfig
     * @param \SprykerEco\Zed\Optile\Persistence\OptileRepositoryInterface $optileRepository
     * @param \SprykerEco\Zed\Optile\Dependency\Service\OptileToUtilEncodingServiceInterface $utilEncodingService
     */
    public function __construct(
        OptileConfig $optileConfig,
        OptileRepositoryInterface $optileRepository,
        OptileToUtilEncodingServiceInterface $utilEncodingService
    ) {
        $this->optileConfig = $optileConfig;
        $this->optileRepository = $optileRepository;
        $this->utilEncodingService = $utilEncodingService;
    }

    /**
     * @param array $responseData
     * @param \Generated\Shared\Transfer\OptileRequestTransfer $optileRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileResponseTransfer
     */
    public function handleResponse(
        array $responseData,
        OptileRequestTransfer $optileRequestTransfer
    ): OptileResponseTransfer {
        if (
            empty($responseData['identification']['longId']
            || empty($responseData['links']['self']))
        ) {
            return (new OptileResponseTransfer())->setIsSuccess(false)
                ->setError('Required fields: identification.longId, links.self  can\'t be empty');
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

        $optileRequestTransfer = $this->setRequestPayload($optileRequestTransfer);
        $optileRequestTransfer = $this->addScoreToRequestPayload($optileRequestTransfer);
        $optileRequestTransfer = $this->addPreselectToRequestPayload($optileRequestTransfer);
        $optileRequestTransfer = $this->addRegistrationToRequestPayload($optileRequestTransfer);

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
     * @return \Generated\Shared\Transfer\OptileRequestTransfer
     */
    protected function setRequestPayload(OptileRequestTransfer $optileRequestTransfer): OptileRequestTransfer
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
                'amount' => $optileRequestTransfer->getPaymentAmount() / 100,
                'currency' => $optileRequestTransfer->getPaymentCurrency(),
                'reference' => $optileRequestTransfer->getPaymentReference(),
            ],
            'callback' => [
                'returnUrl' => $optileRequestTransfer->getCallbackPaymentHandlerUrl(),
                'cancelUrl' => $optileRequestTransfer->getCallbackCancelUrl(),
                'summaryUrl' => $optileRequestTransfer->getCallbackPaymentHandlerUrl(),
                'notificationUrl' => $optileRequestTransfer->getCallbackNotificationUrl(),
            ],

            "clientInfo" => [
                    "ip" => $optileRequestTransfer->getCustomerIp(),
                    "userAgent" => $optileRequestTransfer->getClientUserAgent(),
                    "acceptHeader" => $this->utilEncodingService->encodeJson(
                        $optileRequestTransfer->getClientAcceptableContentTypes()
                    ),
              ],
        ];

        return $optileRequestTransfer->setRequestPayload($payload);
    }

    /**
     * @param \Generated\Shared\Transfer\OptileRequestTransfer $optileRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileRequestTransfer
     */
    protected function addScoreToRequestPayload(OptileRequestTransfer $optileRequestTransfer)
    {
        $payload = $optileRequestTransfer->getRequestPayload();

        if ($optileRequestTransfer->getCustomerScore()) {
            $payload['customerScore'] = $optileRequestTransfer->getCustomerScore();
        }

        return $optileRequestTransfer->setRequestPayload($payload);
    }

    /**
     * @param \Generated\Shared\Transfer\OptileRequestTransfer $optileRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileRequestTransfer
     */
    protected function addPreselectToRequestPayload(OptileRequestTransfer $optileRequestTransfer)
    {
        $payload = $optileRequestTransfer->getRequestPayload();

        if ($this->optileConfig->isPreselectEnabled()) {
            $payload['preselection'] = [
                "deferral" => "DEFERRED",
                "direction" => "CHARGE",
            ];
        }

        return $optileRequestTransfer->setRequestPayload($payload);
    }

    /**
     * @param \Generated\Shared\Transfer\OptileRequestTransfer $optileRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileRequestTransfer
     */
    protected function addRegistrationToRequestPayload(OptileRequestTransfer $optileRequestTransfer)
    {
        $payload = $optileRequestTransfer->getRequestPayload();

        $customerRegistration = $this->optileRepository
            ->findCustomerRegistrationTransferByEmail($optileRequestTransfer->getCustomerEmail());

        if ($customerRegistration) {
            $payload['customer']['registration'] = [
                "id" => $customerRegistration->getCustomerRegistrationId(),
                "password" => $customerRegistration->getCustomerRegistrationHash(),
            ];
        }

        return $optileRequestTransfer->setRequestPayload($payload);
    }
}
