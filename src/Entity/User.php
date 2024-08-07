<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'users')]
class User extends AbstractBaseUuidEntity implements UserInterface, PasswordAuthenticatedUserInterface
{
    use TimestampableEntity;

    #[ORM\Column(type: 'string', length: 255, unique: true, nullable: false, options: ['comment' => 'User`s login'])]
    private string $email;

    #[ORM\Column(type: 'string', nullable: false, options: ['comment' => 'User`s password'])]
    private string $password;

    #[ORM\Column(type: 'string', length: 255, nullable: true, options: ['comment' => 'User`s name'])]
    private string $name;

    #[ORM\ManyToOne(targetEntity: City::class)]
    private City $city;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?\DateTimeInterface $birthDate;

    #[ORM\Column(type: 'string', length: 255, nullable: true, options: ['comment' => 'User`s gender'])]
    private ?string $gender;

    #[ORM\Column(type: 'string', nullable: true, options: ['comment' => 'User`s info'])]
    private ?string $info;

    #[ORM\OneToOne(targetEntity: File::class)]
    #[ORM\JoinColumn(onDelete: 'SET NULL')]
    private ?File $avatar;

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCity(): City
    {
        return $this->city;
    }

    public function setCity(City $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(?\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getInfo(): ?string
    {
        return $this->info;
    }

    public function setInfo(?string $info): self
    {
        $this->info = $info;

        return $this;
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

    public function getUsername(): string
    {
        return $this->email;
    }

    public function getUserIdentifier(): ?string
    {
        return $this->email;
    }

    public function getAvatar(): ?File
    {
        return $this->avatar;
    }

    public function setAvatar(File $avatar): void
    {
        $this->avatar = $avatar;
    }
}
