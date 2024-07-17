<?php

namespace App\Model\User;

use App\Model\City\CityModel;
use DateTimeInterface;

class UpdateModel
{
    public function __construct(
        private ?string $name,
        private ?string $about,
        private ?DateTimeInterface $birthDate,
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

    public function getBirthDate(): ?DateTimeInterface
    {
        return $this->birthDate;
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
