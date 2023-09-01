<?php 
namespace App\Tests\Service\Location;

use App\DTO\{Location, LocationCollection};
use PHPUnit\Framework\TestCase;
use App\Helper\SerializerHelper;
use App\Service\Location\LocationProvider;

/**
 * Test LocationProvider class
 */
final class LocationProviderTest extends TestCase
{
    /** @var LocationProvider */
    protected $locationProvider;

    /** @var SerializerHelper MockObject */
    protected $serializerHelperMock;

    /**
     * Set up test object.
     */
    public function setUp() : void
    {
        $this->serializerHelperMock = $this->createMock(SerializerHelper::class);
        $this->locationProvider = new LocationProvider($this->serializerHelperMock);
    }

    /**
     * Tests, when headquarter location not found.
     *
     * @return void
     */
    public function testHeadquarterIsNull(): void
    {
        $locations = $this->getLocationCollection();
        $this->serializerHelperMock->expects($this->once())
            ->method('deserializeJson')
            ->with($this->getAddresses(), Location::class . '[]')
            ->willReturn($this->getLocationArray());

        $result = $this->locationProvider->getLocationsInFile();
        $this->assertIsArray($result);
        $this->assertNull($result[0]);
        $this->assertEquals($locations, $result[1]);
    }

    /**
     * Tests, get location from file.
     *
     * @return void
     */
    public function testGetLocationsInFile(): void
    {
        $locations = $this->getLocationCollection();
        $this->serializerHelperMock->expects($this->once())
            ->method('deserializeJson')
            ->with($this->getAddresses(), Location::class . '[]')
            ->willReturn($this->getLocationArray(true));

        $result = $this->locationProvider->getLocationsInFile();
        $this->assertIsArray($result);
        $this->assertNotNull($result[0]);
        $this->assertEquals($locations, $result[1]);
    }

    /**
     * Tests, when locations file is empty.
     *
     * @return void
     */
    public function testWhenFileIsEmpty(): void
    {
        $result = $this->locationProvider->getLocationsInFile('');
        $this->assertNull($result);
    }

    /**
     * Create location collection.
     *
     * @return LocationCollection
     */
    private function getLocationCollection() : LocationCollection
    {
        $locationOne = new Location();
        $locationOne->setName('test name')
            ->setAddress('test address')
            ->setIsHeadQuarter(false);

        $locationTwo = new Location();
        $locationTwo->setName('test name two')
            ->setAddress('test address two')
            ->setIsHeadQuarter(false);
        
        return new LocationCollection([
            $locationOne,
            $locationTwo
        ]);
    }

    /**
     * Create locations array
     *
     * @param boolean $addHeadquarter
     * @return array
     */
    private function getLocationArray(bool $addHeadquarter = false) : array
    {
        $locationOne = new Location();
        $locationOne->setName('test name')
            ->setAddress('test address')
            ->setIsHeadQuarter(false);

        $locationTwo = new Location();
        $locationTwo->setName('test name two')
            ->setAddress('test address two')
            ->setIsHeadQuarter(false);

        $location = [
            $locationOne,
            $locationTwo
        ];
        if ($addHeadquarter) {
            $locationThree = new Location();
            $locationThree->setName('test name headquarter')
                ->setAddress('test address headquarter')
                ->setIsHeadQuarter(true);
            $location[] = $locationThree;
        }

        return $location;
    }

    /**
     * Create location
     *
     * @return void
     */
    private function getAddresses()
    {
        return '[{"name":"test name","address":"test address","isHeadQuarter":true},{"name":"test name two","address":"test address two"}]';
    }
}

namespace App\Service\Location;

function file_get_contents($fileName)
{
    if ($fileName) {
        return '[{"name":"test name","address":"test address","isHeadQuarter":true},{"name":"test name two","address":"test address two"}]';
    } else {
        return false;
    }
}