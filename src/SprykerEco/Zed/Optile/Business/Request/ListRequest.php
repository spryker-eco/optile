<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optile\Business\Request;

use Generated\Shared\Transfer\OptileRequestTransfer;
use Generated\Shared\Transfer\OptileResponseTransfer;
use SprykerEco\Zed\Optile\OptileConfig;
use Symfony\Component\HttpFoundation\Request;

class ListRequest implements RequestInterface
{
    protected const LISTS_URL_PATH = '%s/lists';

    /**
     * @var \SprykerEco\Zed\Optile\OptileConfig
     */
    protected $optileConfig;

    /**
     * @param \SprykerEco\Zed\Optile\OptileConfig $optileConfig
     */
    public function __construct(OptileConfig $optileConfig)
    {
        $this->optileConfig = $optileConfig;
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

        $this->setRequestPayload($optileRequestTransfer);

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
                'amount' => $optileRequestTransfer->getPaymentAmount(),
                'currency' => $optileRequestTransfer->getPaymentCurrency(),
                'reference' => $optileRequestTransfer->getPaymentReference(),
            ],
            'callback' => [
                'returnUrl' => $optileRequestTransfer->getCallbackPaymentHandlerUrl(),
                'cancelUrl' => $optileRequestTransfer->getCallbackCancelUrl(),
                'summaryUrl' => $optileRequestTransfer->getCallbackPaymentHandlerUrl(),
                'notificationUrl' => $optileRequestTransfer->getCallbackNotificationUrl(),
            ],
        ];

        if ($optileRequestTransfer->getCustomerScore()) {
            $payload['customerScore'] = $optileRequestTransfer->getCustomerScore();
        }

        return $optileRequestTransfer->setRequestPayload($payload);
    }
}
