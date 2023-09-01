<?php
namespace App\DTO;

/**
 * Location class
 */
class Location 
{
    /** @var string */
    protected $name;

    /** @var string */
    protected $address;

    /** @var bool */
    protected $isHeadQuarter = false;

    /** @var float */
    protected $distance = 0.0;

    /**
     * Get name
     *
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Location
     */
    public function setName(string $name) : Location
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress() : string 
    {
        return $this->address;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Location
     */
    public function setAddress(string $address) : Location
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Check if location is headquarter
     *
     * @return boolean
     */
    public function getIsHeadQuarter() : bool
    {
        return $this->isHeadQuarter;
    }

    /**
     * Set headquarter
     *
     * @param boolean $isHeadQuarter
     * @return Location
     */
    public function setIsHeadQuarter(bool $isHeadQuarter) : Location
    {
        $this->isHeadQuarter = $isHeadQuarter;

        return $this;
    }

    /**
     * Get location distance.
     *
     * @return float
     */
    public function getDistance() : float
    {
        return $this->distance;
    }

    /**
     * Set location distance.
     *
     * @param float $distance
     * @return Location
     */
    public function setDistance(float $distance) : Location
    {
        $this->distance = $distance;

        return $this;
    }
}