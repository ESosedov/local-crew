<?php

namespace App\Entity;

use App\Entity\Traits\IdTrait;
use App\Repository\PushTokenRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PushTokenRepository::class)]
#[ORM\Table(name: 'push_tokens')]
class PushToken extends AbstractBaseUuidEntity
{
    use IdTrait;

    #[ORM\OneToOne(targetEntity: User::class)]
    private User $user;

    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private string $token;

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }
}
