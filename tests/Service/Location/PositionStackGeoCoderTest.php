<?php 
namespace App\Tests\Service\Location;

use GuzzleHttp\Psr7\Request;
use Psr\Log\LoggerInterface;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use App\Service\Common\GuzzleHttpClient;
use GuzzleHttp\Exception\ClientException;
use App\Service\Interface\GeoCodingInterface;
use App\Service\Location\PositionStackGeoCoder;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

/**
 * Test PositionStackGeoCoder class
 */
final class PositionStackGeoCoderTest extends TestCase
{
    /** @var PositionStackGeoCoder */
    protected $positionStackGeoCoder;

    /** @var GuzzleClient MockObject */
    protected $guzzleHttpClientMock;

    /** @var Logger MockObject */
    protected $loggerMock;

    /**
     * Set up test object.
     */
    public function setUp() : void
    {
        $this->guzzleHttpClientMock = $this->createMock(GuzzleHttpClient::class);
        $this->loggerMock = $this->createMock(LoggerInterface::class);
        $this->positionStackGeoCoder = new PositionStackGeoCoder($this->guzzleHttpClientMock, $this->loggerMock, 'test url', 'test key');
    }

    /**
     * Tests, class implements necessary methods.
     *
     * @return void
     */
    public function testImplementsInterfaceAndMethods() : void
    {
        $this->assertInstanceOf(GeoCodingInterface::class, $this->positionStackGeoCoder);
        $this->assertTrue(method_exists($this->positionStackGeoCoder, 'addressToLocation'));
        $this->assertTrue(method_exists($this->positionStackGeoCoder, 'coordinatesToLocation'));
    }

    /**
     * Tests, get locations data.
     *
     * @return void
     */
    public function testAddressToLocation(): void
    {
        $response = '{"data":[{"latitude":51.6882,"longitude":5.298532,"type":"address","name":"test name","postal_code":"5211DA","street":"test street","confidence":1,"region":"North","region_code":"TE","county":null,"locality":"test","administrative_area":"test","neighbourhood":"test","country":"test","country_code":"test","continent":"Europe","label":"test"}]}';
        $this->guzzleHttpClientMock->expects($this->once())
            ->method('get')
            ->with('test url/forward?access_key=test+key&query=test+addresss&limit=1')
            ->willReturn(new Response(200, [], $response));

        $result = $this->positionStackGeoCoder->addressToLocation('test addresss');
        $this->assertNotNull($result);
        $this->assertEquals($response, $result);
    }

    /**
     * Tests, get locations data for invalid address.
     *
     * @return void
     */
    public function testEmptyAddress(): void
    {
        $result = $this->positionStackGeoCoder->addressToLocation('');
        $this->assertNull($result);
    }

    /**
     * Tests, get locations for exceptions.
     *
     * @return void
     */
    public function testGuzzleErrorAddress(): void
    {
        $this->expectException(ServiceUnavailableHttpException::class);
        $this->guzzleHttpClientMock->expects($this->once())
            ->method('get')
            ->with('test url/forward?access_key=test+key&query=test+address&limit=1')
            ->will($this->throwException(new ClientException('invalid api', new Request('GET', 'url'), new Response())));

        $this->loggerMock->expects($this->once())
            ->method('error')
            ->with('invalid api');

        $this->positionStackGeoCoder->addressToLocation('test address');
    }
}