<?php

namespace App\Entity;

use App\Entity\Traits\IdTrait;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity]
#[ORM\Table(name: "event_members")]
class EventMember extends AbstractBaseUuidEntity
{
    use TimestampableEntity;

    #[ORM\ManyToOne(targetEntity: Event::class)]
    #[ORM\JoinColumn(unique: true)]
    private Event $event;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(unique: true)]
    private User $user;

    #[ORM\Column(type: 'boolean',nullable: false)]
    private bool $isAuthor;

    #[ORM\Column(type: 'boolean',nullable: false)]
    private bool $isApproved;
}