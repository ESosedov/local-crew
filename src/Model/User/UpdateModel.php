<?php

namespace App\Model\User;

use App\Model\Event\EventShortModel;
use App\Model\Location\LocationModel;

class UpdateModel
{
    public function __construct(
        private ?string $name,
        private ?string $about,
        private ?int $age,
        private ?string $gender,
        private ?string $city,
        private ?LocationModel $location,
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

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function getLocation(): ?LocationModel
    {
        return $this->location;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }
}
