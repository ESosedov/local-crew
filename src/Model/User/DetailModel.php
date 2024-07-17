<?php

namespace App\Model\User;

use App\Model\City\CityModel;
use App\Model\Event\EventShortModel;
use App\Model\File\FileModel;

class DetailModel
{
    public function __construct(
        private string $id,
        private ?string $name,
        private FileModel|null $avatar,
        private ?string $about,
        private \DateTimeInterface $registrationDate,
        private string $email,
        private ?\DateTimeInterface $birthDate,
        private ?string $gender,
        private ?CityModel $city,
        /**
         * @var EventShortModel[]
         */
        private array $events = [],
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getAvatar(): ?FileModel
    {
        return $this->avatar;
    }

    public function getAbout(): ?string
    {
        return $this->about;
    }

    public function getRegistrationDate(): \DateTimeInterface
    {
        return $this->registrationDate;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getBirthDate(): ?\DateTimeInterface
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

    public function getEvents(): array
    {
        return $this->events;
    }
}
