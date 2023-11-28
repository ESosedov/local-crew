<?php

namespace App\Model\City;

class CityModel
{
    public function __construct(
        private ?string $name = null,
        private ?float $longitude = null,
        private ?float $latitude = null,
    ) {
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }
}
