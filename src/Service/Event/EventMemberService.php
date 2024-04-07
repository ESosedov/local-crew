<?php

namespace App\Service\Event;

use App\Entity\Event;
use App\Entity\EventMember;
use App\Entity\User;
use App\Repository\EventMemberRepository;
use Doctrine\ORM\NonUniqueResultException;

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
            ->setIsApproved(true)
            ->setIsOrganizer(true)
            ->setIsMember(true)
            ->setIsFavorite(true);

        $this->eventMemberRepository->save($eventMember, true);
    }

    public function getOrganizer(Event $event): User
    {
        return $this->eventMemberRepository->getOrganizer($event)->getUser();
    }

    /**
     * @throws NonUniqueResultException
     */
    public function submitCandidate(Event $event, User $user): void
    {
        $eventMember = $this->eventMemberRepository->getOneByEventAndUser($event, $user);
        if (null === $eventMember) {
            return;
        }
        $eventMember->setIsApproved(true);

        $this->eventMemberRepository->save($eventMember, true);
    }

    public function createCandidate(Event $event, User $user): EventMember
    {
        $eventMember = new EventMember();
        $eventMember
            ->setEvent($event)
            ->setUser($user)
            ->setIsApproved(false)
            ->setIsOrganizer(false)
            ->setIsMember(true)
            ->setIsFavorite(false);

        $this->eventMemberRepository->save($eventMember, true);

        return $eventMember;
    }
}
