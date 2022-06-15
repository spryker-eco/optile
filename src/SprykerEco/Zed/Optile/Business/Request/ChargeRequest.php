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

class ChargeRequest implements OptileApiRequestInterface
{
    /**
     * @var string
     */
    protected const CHARGE_REQUEST_PATH_TEMPLATE = '%s/lists/%s/charge';

    /**
     * @var string
     */
    protected const ERROR_MESSAGE_LONG_ID_REQUIRED = 'Required field "longId" can\'t be empty';

    /**
     * @var string
     */
    protected const APPROVED_RESULT_INFO = 'Approved';

    /**
     * @var string
     */
    protected const PROCEED_INTERACTION_CODE = 'PROCEED';

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
     * @param array<string,mixed> $responseData
     * @param \Generated\Shared\Transfer\OptileRequestTransfer $optileRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileResponseTransfer
     */
    public function handleResponse(array $responseData, OptileRequestTransfer $optileRequestTransfer): OptileResponseTransfer
    {
        $longId = $this->extractLongIdFromResponseData($responseData);

        if (empty($longId)){
            return (new OptileResponseTransfer())->setIsSuccess(false)
                ->setError(static::ERROR_MESSAGE_LONG_ID_REQUIRED);
        }

        return (new OptileResponseTransfer())
            ->setPaymentReference($optileRequestTransfer->getPaymentReference())
            ->setOperation($responseData['operation'] ?? '')
            ->setLongId($longId)
            ->setIsSuccess(true);
    }

    /**
     * @param \Generated\Shared\Transfer\OptileRequestTransfer $optileRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptileRequestTransfer
     */
    public function configureRequest(OptileRequestTransfer $optileRequestTransfer): OptileRequestTransfer
    {
        $format = '%s/%s/%s/charge';
        $base_url = 'https://api.sandbox.oscato.com/pci/v1';
        $network_code = 'AMEX';
        $optileRequestTransfer->setRequestUrl(
            sprintf(
                $format,
                $base_url,
                $optileRequestTransfer->getLongId(),
                $network_code
            ),
        );

        $optileRequestTransfer->setRequestPayload($this->getRequestPayload());

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
     * @return array<string,mixed>
     */
    protected function getRequestPayload(): array
    {
        return [
            'account' => [
                'holderName' => 'Mohammed Alama',
                'number' => '340000000000009',
                'verificationCode' => '6666',
                'expiryMonth' => '01',
                'expiryYear' => '2024',
            ],
            'autoRegistration' => true,
            'allowRecurrence' => null,
        ];
    }

    /**
     * @param array<string,mixed> $responseData
     *
     * @return bool
     */
    public function isFailedRequest(array $responseData): bool
    {
        return
            $responseData['resultInfo'] != static::APPROVED_RESULT_INFO
            ||
            $responseData['interaction']['code'] != static::PROCEED_INTERACTION_CODE;
    }

    /**
     * @param array<string,mixed> $responseData
     *
     * @return mixed|string
     */
    private function extractLongIdFromResponseData(array $responseData)
    {
        $long_id = '';
        foreach ($responseData['redirect']['parameters'] as $key => $parameter){
            if($parameter['name'] =='longId'){
                $long_id = $responseData['redirect']['parameters'][$key]['value'];
            }
        }
        return $long_id;
    }
}
