<?php

namespace App\Service\Event;

use App\Entity\Event;
use App\Entity\EventMember;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class EventMemberService
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function addOrganizer(User $user, Event $event): void
    {
        $eventMember = new EventMember();
        $eventMember
            ->setEvent($event)
            ->setUser($user)
            ->setIsApproved(true)
            ->setIsOrganizer(true);

        $this->entityManager->persist($eventMember);
        $this->entityManager->flush();
    }
}
