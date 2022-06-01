<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optile\Business\HttpClient;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use SprykerEco\Zed\Optile\Business\HttpClient\Exception\OptileHttpRequestException;

class OptileGuzzleHttpClient implements OptileHttpClientInterface
{
    /**
     * @var \GuzzleHttp\ClientInterface
     */
    protected $guzzleHttpClient;

    /**
     * @param \GuzzleHttp\ClientInterface $guzzleHttpClient
     */
    public function __construct(ClientInterface $guzzleHttpClient)
    {
        $this->guzzleHttpClient = $guzzleHttpClient;
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array $options
     *
     * @throws \SprykerEco\Zed\Optile\Business\HttpClient\Exception\OptileHttpRequestException
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function request(string $method, string $uri, array $options = []): ResponseInterface
    {
        try {
            return $this->guzzleHttpClient->request($method, $uri, $options);
        } catch (GuzzleException $exception) {
            throw new OptileHttpRequestException(
                $exception->getMessage(),
                $exception->getCode(),
                $exception,
            );
        }
    }
}
