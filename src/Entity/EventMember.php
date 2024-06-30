<?php

namespace App\Entity;

use App\Repository\EventMemberRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: EventMemberRepository::class)]
#[ORM\Table(name: 'event_members')]
class EventMember extends AbstractBaseUuidEntity
{
    use TimestampableEntity;

    #[ORM\ManyToOne(targetEntity: Event::class, inversedBy: 'members')]
    #[ORM\JoinColumn(nullable: false)]
    private Event $event;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private User $user;

    #[ORM\Column(type: 'boolean', nullable: false)]
    private bool $isOrganizer;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private bool $isApproved;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private bool $isMember;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private bool $isFavorite;

    public function getEvent(): Event
    {
        return $this->event;
    }

    public function setEvent(Event $event): self
    {
        $this->event = $event;

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function isOrganizer(): bool
    {
        return $this->isOrganizer;
    }

    public function setIsOrganizer(bool $isOrganizer): self
    {
        $this->isOrganizer = $isOrganizer;

        return $this;
    }

    public function isApproved(): bool
    {
        return $this->isApproved;
    }

    public function setIsApproved(bool $isApproved): self
    {
        $this->isApproved = $isApproved;

        return $this;
    }

    public function isMember(): bool
    {
        return $this->isMember;
    }

    public function setIsMember(bool $isMember): self
    {
        $this->isMember = $isMember;

        return $this;
    }

    public function isFavorite(): bool
    {
        return $this->isFavorite;
    }

    public function setIsFavorite(bool $isFavorite): self
    {
        $this->isFavorite = $isFavorite;

        return $this;
    }
}
