<?php
namespace App\Service\Location;

use Psr\Log\LoggerInterface;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\GuzzleException;
use App\Service\Interface\{GeoCodingInterface, HttpClientInterface};
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

/**
 * Position Stack Geo Client.
 */
class PositionStackGeoCoder implements GeoCodingInterface
{
    /** @var HttpClientInterface */
    protected $httpClient;

    /** @var LoggerInterface */
    protected $logger;

    /** @var string */
    protected $apiUrl;

    /** @var string */
    protected $accessKey;

    /**
     * Construct
     *
     * @param HttpClientInterface $httpClient
     * @param LoggerInterface $logger
     * @param string $apiUrl
     * @param string $accessKey
     */
    public function __construct(HttpClientInterface $httpClient, LoggerInterface $logger, string $apiUrl, string $accessKey)
    {
        $this->httpClient = $httpClient;
        $this->logger = $logger;
        $this->apiUrl = $apiUrl;
        $this->accessKey = $accessKey;
    }

    /**
     * Get address geo location.
     *
     * @param string $address
     * @return string
     */
    public function addressToLocation(string $address): ?string
    {   
        if (empty($address)) {
            return null;
        }
        $parameters = [
            'access_key' => $this->accessKey,
            'query' => $address,
            'limit' => 1
        ];
        $url = $this->apiUrl . '/forward?' . http_build_query($parameters);
      
        try {
            $response =$this->httpClient->get($url);
        } catch (GuzzleException $exception) {
            $this->logger->error($exception->getMessage());
            
            throw new ServiceUnavailableHttpException(5, 'Location service not available.');
        }
       
        return $this->getResponseContent($response);
    }

    public function coordinatesToLocation(float $latitude, float $longitude): ?string
    {
        //Define if required
    }

    /**
     * Process response
     *
     * @param ResponseInterface $rawResponse
     * @return string
     */
    private function getResponseContent(ResponseInterface $rawResponse): string
    {
        return $rawResponse->getBody()->getContents();
    }
}