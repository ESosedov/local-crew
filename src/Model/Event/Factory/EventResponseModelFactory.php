<?php

namespace App\Model\Event\Factory;

use App\Entity\Event;
use App\Model\Event\EventResponseModel;
use App\Model\User\Factory\ShortModelFactory;
use App\Repository\EventMemberRepository;

class EventResponseModelFactory
{
    public function __construct(
        private EventMemberRepository $eventMemberRepository,
        private ShortModelFactory $userShortModelFactory,
    ) {
    }

    public function fromEvent(Event $event): EventResponseModel
    {
        $members = [];
        $candidates = [];
        $eventMembers = $this->eventMemberRepository->findBy(['event' => $event]);
        foreach ($eventMembers as $eventMember) {
            $user = $eventMember->getUser();
            if (true === $eventMember->isOrganizer()) {
                $organizerShortModel = $this->userShortModelFactory->fromUser($user);
            }
            if (true === $eventMember->isApproved()) {
                $members[] = $user;
            } else {
                $candidates[] = $user;
            }
        }

        $memberModels = $this->userShortModelFactory->fromUsers($members);
        $candidateModels = $this->userShortModelFactory->fromUsers($candidates);

        return new EventResponseModel(
            $event->getId(),
            $event->getTitle(),
            $event->getDate(),
            $event->getType(),
            $event->getParticipationTerms(),
            $event->getDetails(),
            $event->getAvatar()?->getUrl(),
            $organizerShortModel,
            $memberModels,
            $candidateModels,
        );
    }
}
