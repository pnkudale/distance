<?php 
namespace App\Tests\Helper;

use App\DTO\Location;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use App\Helper\SerializerHelper;

/**
 * Test SerializerHelper class
 */
final class SerializerHelperTest extends TestCase
{
    /** @var SerializerHelper */
    protected $serializerHelper;

    /** @var Client MockObject */
    protected $clientMock;

    /**
     * Set up test object.
     */
    public function setUp() : void
    {
        $this->clientMock = $this->createMock(Client::class);
        $this->serializerHelper = new SerializerHelper($this->clientMock);
    }

    /**
     * Tests, deserializing into array.
     *
     * @return void
     */
    public function testDeserializeArray(): void
    {
        $data = '[
            {
              "name": "Adchieve Rotterdam",
              "address": "Weena 505, 3013 Rotterdam, The Netherlands"
            },
            {
              "name": "Sherlock Holmes",
              "address": "221B Baker St., London, United Kingdom"
            }
          ]';
        $locationOne = new Location();
        $locationOne->setName('Adchieve Rotterdam')
            ->setAddress('Weena 505, 3013 Rotterdam, The Netherlands');

        $locationTwo = new Location();
        $locationTwo->setName('Sherlock Holmes')
            ->setAddress('221B Baker St., London, United Kingdom');
        $expectedResult = [
            $locationOne,
            $locationTwo
        ];
        $result = $this->serializerHelper->deserializeJson($data, Location::class . '[]', 'json');
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * Tests, deserializing into object
     */
    public function testDeserializeObject(): void
    {
        $data = '{
            "name": "Adchieve Rotterdam",
            "address": "Weena 505, 3013 Rotterdam, The Netherlands"
        }';
        $expectedResult = new Location();
        $expectedResult->setName('Adchieve Rotterdam')
            ->setAddress('Weena 505, 3013 Rotterdam, The Netherlands');

        $result = $this->serializerHelper->deserializeJson($data, Location::class, 'json');
        $this->assertEquals($expectedResult, $result);
    }
}