<?php 
namespace App\Service\Common;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use App\Service\Interface\HttpClientInterface;

/**
 * Guzzle client
 */
class GuzzleHttpClient implements HttpClientInterface
{
    /** @var Client */
    protected $httpClient;

    /**
     * Construct
     *
     * @param Client $httpClient
     */
    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * GET request
     *
     * @param string $url
     * @param array $options
     * @return ResponseInterface
     */
    public function get(string $url, array $options = []): ResponseInterface
    {
        return $this->httpClient->get($url, $options);
    }

    /**
     * POST request
     *
     * @param string $url
     * @param array $options
     * @return ResponseInterface
     */
    public function post(string $url, array $options = []): ResponseInterface
    {
        return $this->httpClient->post($url, $options);
    }

    /**
     * PUT request
     *
     * @param string $url
     * @param array $options
     * @return ResponseInterface
     */
    public function put(string $url, array $options = []): ResponseInterface
    {
        return $this->httpClient->put($url, $options);
    }

    /**
     * DELETE request
     *
     * @param string $url
     * @param array $options
     * @return ResponseInterface
     */
    public function delete(string $url, array $options = []): ResponseInterface
    {
        return $this->httpClient->delete($url, $options);
    }
}