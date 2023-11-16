<?php

namespace App\Model\User;

use App\Model\Event\EventShortModel;
use App\Model\Location\LocationModel;
use DateTimeInterface;

class DetailModel
{
    public function __construct(
        private ?string $name,
        private ?string $avatar,
        private ?string $about,
        private DateTimeInterface $registrationDate,
        private string $email,
        private ?string $city,
        private ?int $age,
        private ?string $gender,
        private ?LocationModel $location,
        /**
         * @var EventShortModel[]
         */
        private array $events = [],
    ) {
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function getAbout(): ?string
    {
        return $this->about;
    }

    public function getRegistrationDate(): DateTimeInterface
    {
        return $this->registrationDate;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function getLocation(): ?LocationModel
    {
        return $this->location;
    }

    public function getEvents(): array
    {
        return $this->events;
    }
}
