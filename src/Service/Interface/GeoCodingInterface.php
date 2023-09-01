<?php
namespace App\Service\Interface;

/**
 * Interface for location clients.
 */
interface GeoCodingInterface
{
    /**
     * Get location data from address.
     *
     * @param string $address
     * @return string|null
     */
    public function addressToLocation(string $address): ?string;

    /**
     * Get location data from coordinates.
     *
     * @param float $latitude
     * @param float $longitude
     * @return string|null
     */
    public function coordinatesToLocation(float $latitude, float $longitude): ?string;
}