<?php 
namespace App\Tests\Service\Common;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use App\Service\Common\GuzzleHttpClient;
use GuzzleHttp\Psr7\Response;

/**
 * Test GuzzleHttpClient class
 */
final class GuzzleHttpClientTest extends TestCase
{
    /** @var GuzzleHttpClient */
    protected $guzzleHttpClient;

    /** @var Client MockObject */
    protected $clientMock;

    /**
     * Set up test object.
     */
    public function setUp() : void
    {
        $this->clientMock = $this->createMock(Client::class);
        $this->guzzleHttpClient = new GuzzleHttpClient($this->clientMock);
    }

    /**
     * Test `get` method.
     *
     * @return void
     */
    public function testGet(): void
    {
        $url = 'test url';
        $options = ['headers' => ['Authorization' => 'test bearer']];
        $this->clientMock->expects($this->once())
            ->method('get')
            ->with($url, $options)
            ->willReturn(new Response());

        $this->guzzleHttpClient->get($url, $options);
    }

    /**
     * Test `post` method.
     *
     * @return void
     */
    public function testPost(): void
    {
        $url = 'test url';
        $options = ['json' => '{"data": "test data"}'];
        $this->clientMock->expects($this->once())
            ->method('post')
            ->with($url, $options)
            ->willReturn(new Response());

        $this->guzzleHttpClient->post($url, $options);
    }

    /**
     * Test `put` method.
     *
     * @return void
     */
    public function testPut(): void
    {
        $url = 'test url';
        $options = ['json' => '{"data": "test data"}'];
        $this->clientMock->expects($this->once())
            ->method('put')
            ->with($url, $options)
            ->willReturn(new Response());

        $this->guzzleHttpClient->put($url, $options);
    }

    /**
     * Test `delete` method.
     *
     * @return void
     */
    public function testDelete(): void
    {
        $url = 'test url';
        $options = ['headers' => ['Authorization' => 'test bearer']];
        $this->clientMock->expects($this->once())
            ->method('delete')
            ->with($url, $options)
            ->willReturn(new Response());

        $this->guzzleHttpClient->delete($url, $options);
    }
}