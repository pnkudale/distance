<?php
namespace App\Service\Location;

use App\DTO\{Location, LocationCollection};
use App\Service\Location\DistanceCalculator;
use App\Service\Interface\GeoCodingInterface;

/**
 * Process locations.
 */
class LocationProcessor
{
    /** @var GeoCodingInterface */
    protected $geoCoder;

    /** @var DistanceCalculator */
    protected $distanceCalculator;
     
    /**
     * Construct
     *
     * @param GeoCodingInterface $geoCoder
     * @param DistanceCalculator $distanceCalculator
     */
    public function __construct(GeoCodingInterface $geoCoder, DistanceCalculator $distanceCalculator)
    {
        $this->geoCoder = $geoCoder;
        $this->distanceCalculator = $distanceCalculator;
    }

    /**
     * Process locations.
     *
     * @param Location $headQuarter
     * @param LocationCollection $places
     * @return LocationCollection
     */
    public function processsLocations(Location $headQuarter, LocationCollection $places) : LocationCollection
    {
        list($latitude, $longitude) = $this->getLocationLatLon($headQuarter);
        
        if (empty($latitude) || empty($longitude)) {
            return new LocationCollection();
        }
        foreach ($places as $place) {
            list($placeLatitude, $placeLongitude) = $this->getLocationLatLon($place);
            if (empty($placeLatitude) || empty($placeLongitude)) {
                continue;
            }
            $distance = $this->distanceCalculator->haversineDistance($latitude, $longitude, $placeLatitude, $placeLongitude);
            $place->setDistance($distance);
        }
        $locations = $places->sortByDistance();

        return new LocationCollection(iterator_to_array($locations));
    }

    /**
     * Get location data
     *
     * @param Location $location
     * @return array|null
     */
    private function getLocationLatLon(Location $location) : ?array
    {
        $locationData = $this->geoCoder->addressToLocation($location->getAddress());
        if (empty($locationData)) {
            return null;
        }
        $locationData = json_decode($locationData);
        $locationData = $locationData->data[0];

        return [$locationData->latitude, $locationData->longitude];
    }
}