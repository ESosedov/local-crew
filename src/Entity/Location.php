<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity()]
#[ORM\Table(name: 'locations')]
class Location extends AbstractBaseUuidEntity
{
    #[ORM\Column(type: 'float', nullable: false)]
    private float $longitude;

    #[ORM\Column(type: 'float', nullable: false)]
    private float $latitude;

    #[ORM\Column(type: 'string', length: 100, nullable: false)]
    private string $city;

    #[ORM\Column(type: 'string', length: 100, nullable: false)]
    private string $street;

    #[ORM\Column(type: 'string', length: 50, nullable: false)]
    private string $streetNumber;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private string|null $placeName = null;

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getStreetNumber(): string
    {
        return $this->streetNumber;
    }

    public function setStreetNumber(string $streetNumber): self
    {
        $this->streetNumber = $streetNumber;

        return $this;
    }

    public function getPlaceName(): ?string
    {
        return $this->placeName;
    }

    public function setPlaceName(?string $placeName): self
    {
        $this->placeName = $placeName;

        return $this;
    }
}
