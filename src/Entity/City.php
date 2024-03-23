<?php

namespace App\Entity;

use App\Repository\CityRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CityRepository::class)]
#[ORM\Table(name: 'cities')]
class City extends AbstractBaseUuidEntity
{
    #[ORM\Column(type: 'string', length: 255, nullable: false, options: ['comment' => 'City name'])]
    private string $name;

    #[ORM\Column(type: 'float', nullable: true, options: ['comment' => 'City longitude'])]
    private ?float $longitude = null;

    #[ORM\Column(type: 'float', nullable: true, options: ['comment' => 'City latitude'])]
    private ?float $latitude = null;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }
}
