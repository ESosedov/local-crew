<?php

namespace App\Model\User;

class PublicModel
{
    public function __construct(
        private string $id,
        private ?string $name,
        private ?string $avatar,
        private ?string $about,
        private \DateTimeInterface $registrationDate,
        private ?int $age,
        private ?string $gender,
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

    public function getAvatar(): ?string
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

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }
}
