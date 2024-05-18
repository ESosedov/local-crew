<?php

namespace App\Model\Event\Factory;

use App\Entity\Event;
use App\Entity\User;
use App\Model\Event\EventResponseModel;
use App\Model\File\Factory\FileModelFactory;
use App\Model\User\Factory\CandidateModelFactory;
use App\Model\User\Factory\UserPublicModelFactory;
use App\Repository\EventMemberRepository;
use App\Repository\EventRequestRepository;

class EventResponseModelFactory
{
    public function __construct(
        private EventMemberRepository $eventMemberRepository,
        private UserPublicModelFactory $userPublicModelFactory,
        private FileModelFactory $fileModelFactory,
        private EventRequestRepository $eventRequestRepository,
        private CandidateModelFactory $candidateModelFactory,
    ) {
    }

    public function fromEvent(Event $event, User|null $currentUser): EventResponseModel
    {
        // todo:: add Likes
        $isFavoriteForCurrentUser = false;
        $organizerUserModel = null;
        $members = [];
        $eventMembers = $this->eventMemberRepository->findBy(['event' => $event->getId()]);
        foreach ($eventMembers as $eventMember) {
            if (true === $eventMember->isOrganizer()) {
                $organizerUserModel = $this->userPublicModelFactory->fromUser($eventMember->getUser());
            }
            $members[] = $eventMember->getUser();
        }
        $categoriesIds = [];
        $categories = $event->getCategories();
        foreach ($categories as $category) {
            $categoriesIds[] = $category->getId();
        }
        $candidates = $this->eventRequestRepository->getNewByEvent($event);

        $memberModels = $this->userPublicModelFactory->fromUsers($members);
        $candidateModels = $this->candidateModelFactory->fromEventRequests($candidates);

        $avatar = $this->fileModelFactory->fromFile($event->getAvatar());

        return new EventResponseModel(
            $event->getId(),
            $event->getTitle(),
            $event->getDate(),
            $event->getType(),
            $event->getParticipationTerms(),
            $event->getDetails(),
            $avatar,
            $organizerUserModel,
            $memberModels,
            $candidateModels,
            $event->getCountMembersMax(),
            $categoriesIds,
            $isFavoriteForCurrentUser,
        );
    }

    /**
     * @param Event[] $events
     *
     * @return EventResponseModel[]
     */
    public function fromEvents(array $events, User|null $currentUser): array
    {
        $eventModels = [];
        if ([] === $events) {
            return $eventModels;
        }

        foreach ($events as $event) {
            $eventModels[] = $this->fromEvent($event, $currentUser);
        }

        return $eventModels;
    }
}
