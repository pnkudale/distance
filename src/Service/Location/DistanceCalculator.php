<?php
namespace App\Service\Location;

/**
 * Calculate distances between places.
 */
class DistanceCalculator 
{
    const EARTH_RADIUS = 6371;// Radius of the Earth in kilometers

    /**
     * Get distance between two places
     *
     * @param float $fromLatitude
     * @param float $fromLongitude
     * @param float $toLatitude
     * @param float $toLongitude
     * @return float
     */
    public function haversineDistance(float $fromLatitude, float $fromLongitude, float $toLatitude, float $toLongitude) : float
    {
        $destinationLatitude = deg2rad($toLatitude -  $fromLatitude);
        $destinationLongitude = deg2rad($toLongitude - $fromLongitude);
    
        $result = sin($destinationLatitude / 2) * 
            sin($destinationLatitude / 2) + 
            cos(deg2rad($fromLatitude)) * 
            cos(deg2rad($toLatitude)) * 
            sin($destinationLongitude / 2) * 
            sin($destinationLongitude / 2);
        $placeRadius = 2 * atan2(sqrt($result), sqrt(1 - $result));
    
        $distance = self::EARTH_RADIUS * $placeRadius; // Distance in kilometers
        $distance = (float)number_format((float)$distance, 2, '.', '');

        return $distance;
    }
}