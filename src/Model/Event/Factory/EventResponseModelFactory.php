<?php

namespace App\Model\Event\Factory;

use App\Entity\Event;
use App\Entity\User;
use App\Model\Event\EventResponseModel;
use App\Model\File\Factory\FileModelFactory;
use App\Model\User\Factory\UserPublicModelFactory;
use App\Repository\EventMemberRepository;

class EventResponseModelFactory
{
    public function __construct(
        private EventMemberRepository $eventMemberRepository,
        private UserPublicModelFactory $userPublicModelFactory,
        private FileModelFactory $fileModelFactory,
    ) {
    }

    public function fromEvent(Event $event, User|null $currentUser): EventResponseModel
    {
        $members = [];
        $candidates = [];
        $isFavoriteForCurrentUser = false;
        $organizerUserModel = null;
        $eventMembers = $this->eventMemberRepository->findBy(['event' => $event->getId()]);
        foreach ($eventMembers as $eventMember) {
            $user = $eventMember->getUser();
            if (true === $eventMember->isOrganizer()) {
                $organizerUserModel = $this->userPublicModelFactory->fromUser($eventMember->getUser());
            }
            if ($user === $currentUser) {
                $isFavoriteForCurrentUser = $eventMember->isFavorite();
            }
            if (true === $eventMember->isApproved()) {
                $members[] = $user;
            } else {
                $candidates[] = $user;
            }
        }
        $categoriesIds = [];
        $categories = $event->getCategories();
        foreach ($categories as $category) {
            $categoriesIds[] = $category->getId();
        }

        $memberModels = $this->userPublicModelFactory->fromUsers($members);
        $candidateModels = $this->userPublicModelFactory->fromUsers($candidates);

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
