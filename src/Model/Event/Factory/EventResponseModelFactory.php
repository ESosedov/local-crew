<?php

namespace App\Model\Event\Factory;

use App\Entity\Event;
use App\Entity\User;
use App\Model\Event\EventResponseModel;
use App\Model\User\Factory\ShortModelFactory;
use App\Model\User\PublicModel;
use App\Repository\EventMemberRepository;

class EventResponseModelFactory
{
    public function __construct(
        private EventMemberRepository $eventMemberRepository,
        private ShortModelFactory $userShortModelFactory,
    ) {
    }

    public function fromEvent(Event $event, User|null $currentUser): EventResponseModel
    {
        $members = [];
        $candidates = [];
        $isFavoriteForCurrentUser = false;
        $organizerModel = null;
        $eventMembers = $this->eventMemberRepository->findBy(['event' => $event->getId()]);
        foreach ($eventMembers as $eventMember) {
            $user = $eventMember->getUser();
            if (true === $eventMember->isOrganizer()) {
                $organizerModel = new PublicModel(
                    $user->getId(),
                    $user->getName(),
                    $user->getAvatar()?->getUrl(),
                    $user->getInfo(),
                    $user->getCreatedAt(),
                    $user->getAge(),
                    $user->getGender(),
                );
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
            $organizerModel,
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
