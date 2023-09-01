<?php 
namespace App\Tests\DTO;

use App\DTO\LocationCollection;
use App\DTO\Location;
use PHPUnit\Framework\TestCase;

/**
 * Test LocationCollection class
 */
final class LocationCollectionTest extends TestCase
{
    /**
     * Tests, location collection sorting by distances.
     *
     * @return void
     */
    public function testSortingByDistance() : void
    {
        $locationOne = new Location();
        $locationOne->setName('location one')
            ->setAddress('test address')
            ->setDistance(8745.487);

        $locationTwo = new Location();
        $locationTwo->setName('location two')
            ->setAddress('test address two')
            ->setDistance(0);

        $locationThree = new Location();
        $locationThree->setName('location three')
            ->setAddress('test address three')
            ->setDistance(48.76577);
        
        $locationCollection = new LocationCollection([
            $locationOne,
            $locationTwo,
            $locationThree
        ]);
        
        $results = $locationCollection->sortByDistance();
        $counter = 0;
        foreach ($results as $location) {
            if ($counter == 0) {
                $this->assertEquals($locationTwo, $location);
            }
            if ($counter == 1) {
                $this->assertEquals($locationThree, $location);
            }
            if ($counter == 2) {
                $this->assertEquals($locationOne, $location);
            }
            $counter++;
        }
    }
}