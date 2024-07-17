<?php

namespace App\Model\Event\Factory;

use App\Entity\Event;
use App\Entity\User;
use App\Model\Event\EventResponseModel;
use App\Model\File\Factory\FileModelFactory;
use App\Model\Location\Factory\LocationModelFactory;
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
        private LocationModelFactory $locationModelFactory,
    ) {
    }

    public function fromEvent(Event $event, User|null $currentUser): EventResponseModel
    {
        // todo:: add Likes
        $isFavoriteForCurrentUser = false;
        $organizerUserModel = null;
        $isApprovedForCurrentUser = false;
        $isWaitingForApprovalForCurrentUser = false;
        $members = [];
        // $eventMembers = $this->eventMemberRepository->findBy(['event' => $event->getId()]);
        $eventMembers = $event->getMembers();
        foreach ($eventMembers as $eventMember) {
            if (true === $eventMember->isOrganizer()) {
                $organizerUserModel = $this->userPublicModelFactory->fromUser($eventMember->getUser());
            }
            $members[] = $eventMember->getUser();
            if ($eventMember->getUser() === $currentUser) {
                $isApprovedForCurrentUser = true;
            }
        }
        $categoriesIds = [];
        $categories = $event->getCategories();
        foreach ($categories as $category) {
            $categoriesIds[] = $category->getId();
        }
        // $requests = $this->eventRequestRepository->getNewByEvent($event);
        $requests = $event->getRequests();
        foreach ($requests as $request) {
            if ($request->getCreatedBy() === $currentUser) {
                $isWaitingForApprovalForCurrentUser = true;
                break;
            }
        }

        $memberModels = $this->userPublicModelFactory->fromUsers($members);
        $candidateModels = $this->candidateModelFactory->fromEventRequests($requests);
        if (null === $organizerUserModel) {
            $organizerUserModel = $this->userPublicModelFactory->fromUser($event->getCreatedBy());
        }
        $avatar = $this->fileModelFactory->fromFile($event->getAvatar());

        if (Event::TYPE_LOCAL === $event->getType()) {
            $locationModel = $this->locationModelFactory->fromEntity($event->getLocation());
        }

        // frontend options
        $frontendOptions = [
            'isEventReadyToStart' => $eventMembers->count() === $event->getCountMembersMax(),
            'isApprovedForCurrentUser' => $isApprovedForCurrentUser,
            'isWaitingForApprovalForCurrentUser' => $isWaitingForApprovalForCurrentUser,
            'isActiveUserEvent' => $organizerUserModel->getId() === $currentUser?->getId(),
        ];

        return new EventResponseModel(
            $event->getId(),
            $event->getTitle(),
            $event->getDate(),
            $event->getTimeZone(),
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
            $locationModel ?? null,
            $frontendOptions,
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
