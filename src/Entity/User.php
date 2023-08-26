<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: "users")]
    class User extends AbstractBaseUuidEntity implements UserInterface, PasswordAuthenticatedUserInterface
{
    use TimestampableEntity;

    #[ORM\Column(type: 'string', length: 255, unique: true, nullable: false, options: ['comment' => "User`s login"])]
    private string $email;
    #[ORM\Column(type: 'string', nullable: false, options: ['comment' => "User`s password"])]
    private string $password;
    #[ORM\Column(type: 'string', length: 255, nullable: false, options: ['comment' => "User`s name"])]
    private string $name;
    #[ORM\Column(type: 'string', length: 255, nullable: true, options: ['comment' => "User`s city"])]
    private ?string $city;
    #[ORM\Column(type: 'integer', nullable: true, options: ['comment' => "User`s age"])]
    private ?int $age;
    #[ORM\Column(type: 'string', length: 255, nullable: true, options: ['comment' => 'User`s gender'])]
    private ?string $gender;
    #[ORM\Column(type: 'string', nullable: true, options: ['comment' => 'User`s info'])]
    private string $info;

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
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

    public function getInfo(): string
    {
        return $this->info;
    }

    public function getRoles(): array
    {
        return [];
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials(): void
    {
    }

    public function getUsername()
    {
        return $this->email;
    }

    private function getUserIdentifier(): string
    {
        return $this->id;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function setAge(?int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function setGender(?string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function setInfo(string $info): self
    {
        $this->info = $info;

        return $this;
    }
}
