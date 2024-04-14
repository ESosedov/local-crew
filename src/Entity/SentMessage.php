<?php

namespace App\Entity;

use App\Entity\Traits\CreatedTrait;
use App\Repository\SentMessageRepository;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SentMessageRepository::class)]
#[ORM\Table(name: 'sent_messages')]
class SentMessage extends AbstractBaseUuidEntity
{
    use CreatedTrait;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private User $user;

    #[ORM\ManyToOne(targetEntity: Event::class)]
    private Event $event;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private string|null $address;

    #[ORM\Column(type: Types::STRING, length: 50, nullable: false)]
    private string $type;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private string|null $source = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private string|null $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private string|null $message = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private string|null $identifier = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private DateTimeInterface|null $noticedAt = null;

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getEvent(): Event
    {
        return $this->event;
    }

    public function setEvent(Event $event): self
    {
        $this->event = $event;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(?string $source): self
    {
        $this->source = $source;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getNoticedAt(): ?DateTimeInterface
    {
        return $this->noticedAt;
    }

    public function getIdentifier(): ?string
    {
        return $this->identifier;
    }

    public function setIdentifier(?string $identifier): self
    {
        $this->identifier = $identifier;

        return $this;
    }

    public function setNoticedAt(?DateTimeInterface $noticedAt): self
    {
        $this->noticedAt = $noticedAt;

        return $this;
    }
}
