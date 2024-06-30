<?php

namespace App\Service\Event;

use App\Entity\Event;
use App\Entity\EventMember;
use App\Entity\User;
use App\Repository\EventMemberRepository;

class EventMemberService
{
    public function __construct(
        private EventMemberRepository $eventMemberRepository,
    ) {
    }

    public function addOrganizer(User $user, Event $event): void
    {
        $eventMember = new EventMember();
        $eventMember
            ->setEvent($event)
            ->setUser($user)
            ->setIsOrganizer(true);

        $this->eventMemberRepository->save($eventMember, true);
    }

    public function getOrganizer(Event $event): User
    {
        return $this->eventMemberRepository->getOrganizer($event)->getUser();
    }

    public function add(Event $event, User $user): EventMember
    {
        $eventMember = new EventMember();
        $eventMember
            ->setEvent($event)
            ->setUser($user)
            ->setIsOrganizer(false);

        $this->eventMemberRepository->save($eventMember, true);

        return $eventMember;
    }
}
