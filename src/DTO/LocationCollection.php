<?php
namespace App\DTO;

use ArrayIterator;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Location collection class
 */
class LocationCollection extends ArrayCollection
{
    /**
     * Sort location collection by distance.
     *
     * @return ArrayIterator
     */
    public function sortByDistance() : ArrayIterator
    {
        $iterator = $this->getIterator();
        $iterator->uasort(function($currentLocation, $nextLocation) {
            return $currentLocation->getDistance() - $nextLocation->getDistance();
        });

        return $iterator;
    }
}