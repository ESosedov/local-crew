<?php

namespace App\Model\Location;

class LocationModel
{
    public function __construct(
        private float $latitude,
        private float $longitude,
        private string $city,
        private string $street,
        private string $streetNumber,
        private ?string $placeName,
    ) {
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function getStreetNumber(): string
    {
        return $this->streetNumber;
    }

    public function getPlaceName(): ?string
    {
        return $this->placeName;
    }
}
