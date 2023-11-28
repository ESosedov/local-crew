<?php

namespace App\Model\User;

use App\Model\Event\EventShortModel;
use App\Model\City\CityModel;

class UpdateModel
{
    public function __construct(
        private ?string $name,
        private ?string $about,
        private ?int $age,
        private ?string $gender,
        private ?CityModel $city,
        private ?string $avatar,
    ) {
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getAbout(): ?string
    {
        return $this->about;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function getCity(): ?CityModel
    {
        return $this->city;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }
}
