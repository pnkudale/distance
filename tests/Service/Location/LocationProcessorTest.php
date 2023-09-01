<?php 
namespace App\Tests\Service\Location;

use App\DTO\Location;
use App\DTO\LocationCollection;
use PHPUnit\Framework\TestCase;
use App\Service\Location\LocationProcessor;
use App\Service\Location\DistanceCalculator;
use App\Service\Location\PositionStackGeoCoder;

/**
 * Test LocationProcessor class
 */
final class LocationProcessorTest extends TestCase
{
    /** @var LocationProcessor */
    protected $locationProcessor;

    /** @var DistanceCalculator MockObject */
    protected $distanceCalculatorMock;

    /** @var PositionStackGeoCoder MockObject */
    protected $positionStackGeoCoderMock;

    /**
     * Set up test object.
     */
    public function setUp() : void
    {
        $this->distanceCalculatorMock = $this->createMock(DistanceCalculator::class);
        $this->positionStackGeoCoderMock = $this->createMock(PositionStackGeoCoder::class);
        $this->locationProcessor = new LocationProcessor($this->positionStackGeoCoderMock, $this->distanceCalculatorMock);
    }

    /**
     * Tests, location processing.
     *
     * @return void
     */
    public function testProcesssLocations(): void
    {
        $headquarter = new Location();
        $headquarter->setName('test name headquarter')
            ->setAddress('test address headquarter')
            ->setIsHeadQuarter(true);

        $locationOne = new Location();
        $locationOne->setName('test name one')
            ->setAddress('test address one')
            ->setIsHeadQuarter(false);
        $locationTwo = new Location();
        $locationTwo->setName('test name two')
            ->setAddress('test address two')
            ->setIsHeadQuarter(false);
        $locationCollection = new LocationCollection([
            $locationOne,
            $locationTwo
        ]);

        $headquarterData = '{"data":[{"latitude":51.6882,"longitude":5.298532,"type":"address","name":"test name headquarter"}]}';
        $locationOneData = '{"data":[{"latitude":231.6882,"longitude":233.298532,"type":"address","name":"test name one"}]}';
        $locationTwoData = '{"data":[{"latitude":31.82,"longitude":33.8532,"type":"address","name":"test name two"}]}';
        $this->positionStackGeoCoderMock->expects($this->exactly(3))
            ->method('addressToLocation')
            ->withConsecutive(['test address headquarter'], ['test address one'], ['test address two'])
            ->willReturnOnConsecutiveCalls($headquarterData, $locationOneData, $locationTwoData);
        $this->distanceCalculatorMock->expects($this->exactly(2))
            ->method('haversineDistance')
            ->withConsecutive(
                [51.6882, 5.298532, 231.6882, 233.298532], 
                [51.6882, 5.298532, 31.82, 33.8532]
            )
            ->willReturnOnConsecutiveCalls(835476.73, 766.3);

        $minDistanceLocation = new Location();
        $minDistanceLocation->setName('test name two')
            ->setAddress('test address two')
            ->setIsHeadQuarter(false)
            ->setDistance(766.3);

        $result = $this->locationProcessor->processsLocations($headquarter, $locationCollection);
        $this->assertInstanceOf(LocationCollection::class, $result);
        $this->assertEquals($minDistanceLocation, $result->current());
    }

    /**
     * Tests, when location data not found.
     *
     * @return void
     */
    public function testWhenLocationDataNotFound() : void
    {
        $headquarter = new Location();
        $headquarter->setName('test name headquarter')
            ->setAddress('test address headquarter')
            ->setIsHeadQuarter(true);
        $locationOne = new Location();
        $locationOne->setName('test name one')
            ->setAddress('test address one')
            ->setIsHeadQuarter(false);
        $locationCollection = new LocationCollection([
            $locationOne,
        ]);
        $headquarterData = '{"data":[{"latitude":51.6882,"longitude":5.298532,"type":"address","name":"test name headquarter"}]}';
        
        $this->positionStackGeoCoderMock->expects($this->exactly(2))
            ->method('addressToLocation')
            ->withConsecutive(['test address headquarter'], ['test address one'])
            ->willReturnOnConsecutiveCalls($headquarterData, null);

        $result = $this->locationProcessor->processsLocations($headquarter, $locationCollection);
        $this->assertInstanceOf(LocationCollection::class, $result);
        $this->assertEquals(0, $result[0]->getDistance());
    }

    /**
     * Tests, when headquarter location data not found.
     *
     * @return void
     */
    public function testWhenHeadquarterDataNotFound() : void
    {
        $headquarter = new Location();
        $headquarter->setName('test name headquarter')
            ->setAddress('test address headquarter')
            ->setIsHeadQuarter(true);
        $locationOne = new Location();
        $locationOne->setName('test name one')
            ->setAddress('test address one')
            ->setIsHeadQuarter(false);
        $locationCollection = new LocationCollection([
            $locationOne,
        ]);
        
        $this->positionStackGeoCoderMock->expects($this->once())
            ->method('addressToLocation')
            ->with('test address headquarter')
            ->willReturn(null);

        $result = $this->locationProcessor->processsLocations($headquarter, $locationCollection);
        $this->assertInstanceOf(LocationCollection::class, $result);
        $this->assertCount(0, $result);
    }
}