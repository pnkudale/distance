<?php 
namespace App\Tests\Service\Location;

use PHPUnit\Framework\TestCase;
use App\Service\Location\DistanceCalculator;

/**
 * Test DistanceCalculator class
 */
final class DistanceCalculatorTest extends TestCase
{
    /**
     * Tests, distance calculation between two locations.
     *
     * @return void
     */
    public function testDistanceCalculation(): void
    {
        $distanceCalculator = new DistanceCalculator();
        $result = $distanceCalculator->haversineDistance(51.6882, 5.298532, 231.6882, 233.298532);
        $this->assertEquals(12343.6, $result);
    }
}