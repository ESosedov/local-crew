<?php

namespace App\Model\Location\Factory;

use App\Entity\Location;
use App\Model\Location\LocationModel;

class LocationModelFactory
{
    public function fromEntity(Location $location): LocationModel
    {
        return new LocationModel(
            $location->getLatitude(),
            $location->getLongitude(),
            $location->getCity(),
            $location->getStreet(),
            $location->getStreetNumber(),
            $location->getPlaceName(),
        );
    }
}
