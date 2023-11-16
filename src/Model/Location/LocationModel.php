<?php

namespace App\Model\Location;

class LocationModel
{
    public function __construct(
        private ?string $longitude = null,
        private ?string $latitude = null,
    ) {
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

}
