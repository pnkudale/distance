<?php
namespace App\Service\Location;

use App\DTO\{Location, LocationCollection};
use App\Helper\SerializerHelper;

/**
 * Provides locations.
 */
class LocationProvider 
{
    const DATA_FILE_NAME = __DIR__ . '/../../Data/address.json';

    /** @var SerializerHelper */
    protected $serializerHelper;

    /**
     * Construct
     *
     * @param SerializerHelper $serializerHelper
     */
    public function __construct(SerializerHelper $serializerHelper)
    {
        $this->serializerHelper = $serializerHelper;
    }

    /**
     * Get locations in file.
     *
     * @param string $fileName
     * @return null|array
     */
    public function getLocationsInFile(string $fileName = self::DATA_FILE_NAME) : ?array
    {
        $locations = file_get_contents($fileName);
        if (empty($locations)) {
            return null;
        }
        $locations = $this->serializerHelper->deserializeJson($locations, Location::class . '[]');
        $places = new LocationCollection();
        $headQuarter = null;
        foreach ($locations as $location) {
            if ($location->getIsHeadQuarter()) {
                $headQuarter = $location;
                continue;
            }
            $places->add($location);
        }

        return [$headQuarter, $places];
    }
}