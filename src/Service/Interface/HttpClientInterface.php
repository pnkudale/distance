<?php 
namespace App\Service\Interface;

use Psr\Http\Message\ResponseInterface;

/**
 * Interface for http client.
 */
interface HttpClientInterface
{
    /**
     * GET request.
     *
     * @param string $url
     * @param array $options
     * @return ResponseInterface
     */
    public function get(string $url, array $options = []): ResponseInterface;

    /**
     * POST request.
     *
     * @param string $url
     * @param array $options
     * @return ResponseInterface
     */
    public function post(string $url, array $options = []): ResponseInterface;

    /**
     * PUT request.
     *
     * @param string $uri
     * @param array $options
     * @return ResponseInterface
     */
    public function put(string $uri, array $options = []): ResponseInterface;

    /**
     * DELETE request.
     *
     * @param string $uri
     * @param array $options
     * @return ResponseInterface
     */
    public function delete(string $uri, array $options = []): ResponseInterface;
}