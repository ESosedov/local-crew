<?php

namespace App\Model\Event;

use App\Entity\Event;
use App\Security\Voter\EventVoter;
use App\Validator\Entity\EntityAccessConstraint;
use Symfony\Component\Validator\Constraints as Assert;

class ParticipationApproveModel
{
    public function __construct(
        #[Assert\NotBlank]
        #[EntityAccessConstraint(
            dataClass: Event::class,
            permission: EventVoter::PERMISSION_ORGANIZER,
        )]
        private string $event,
        #[Assert\NotBlank]
        private string $user,
    ) {
    }

    public function getEvent(): string
    {
        return $this->event;
    }

    public function getUser(): string
    {
        return $this->user;
    }
}
