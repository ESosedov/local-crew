<?php

namespace App\Model\Event\Factory;

use App\Entity\Event;
use App\Entity\User;
use App\Model\Event\EventResponseModel;
use App\Model\File\Factory\FileModelFactory;
use App\Model\Location\Factory\LocationModelFactory;
use App\Model\User\Factory\CandidateModelFactory;
use App\Model\User\Factory\UserPublicModelFactory;
use App\Model\User\UserPublicModel;
use App\Query\Event\EventQuery;
use App\Repository\CategoryRepository;
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
        private CategoryRepository $categoryRepository,
        private EventQuery $eventQuery,
    ) {
    }

    public function fromEvent(Event $event, ?User $currentUser): EventResponseModel
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
            $event->getCountMembersMax(),
            $event->getCategories(),
            $isFavoriteForCurrentUser,
            $avatar,
            $organizerUserModel,
            $memberModels,
            $candidateModels,
            $locationModel ?? null,
            $frontendOptions,
        );
    }

    public function fromEventsListData(array $eventsData, ?User $currentUser): array
    {
        $result = [];
        $eventsIs = array_map(static function ($row) {
            return $row['eventModel']->getId();
        }, $eventsData);

        $candidatesMap = $this->eventQuery->getCandidatesByIds($eventsIs);
        $membersMap = $this->eventQuery->getMembersByIds($eventsIs);
        foreach ($eventsData as $row) {
            /** @var EventResponseModel $eventModel */
            $eventModel = $row['eventModel'];

            /** @var UserPublicModel $organizerModel */
            $organizerModel = $row['organizerModel'];
            $organizerAvatar = $this->fileModelFactory->fromFileDTO($row['organizerAvatarDTO']);
            $eventModel->setAvatar($organizerAvatar);

            $isFavorite = false;
            if (array_key_exists('isFavorite', $row)) {
                $isFavorite = $row['isFavorite'];
            }
            $eventModel->setIsFavorite($isFavorite);

            $eventAvatar = $this->fileModelFactory->fromFileDTO($row['eventAvatarDTO']);
            $candidates = [];
            $members = [];
            if (true === array_key_exists($eventModel->getId(), $candidatesMap)) {
                $candidates = $this->candidateModelFactory->fromUsers(
                    $candidatesMap[$eventModel->getId()], $eventModel->getId(),
                );
            }

            if (true === array_key_exists($eventModel->getId(), $membersMap)) {
                $members = $this->userPublicModelFactory->fromUsers($membersMap[$eventModel->getId()]);
            }

            $isWaitingForApprovalForCurrentUser = false;
            foreach ($candidates as $candidate) {
                if ($candidate->getUser()->getId() === $currentUser?->getId()) {
                    $isWaitingForApprovalForCurrentUser = true;
                    break;
                }
            }
            $isApprovedForCurrentUser = false;
            foreach ($members as $member) {
                if ($member->getId() === $currentUser?->getId()) {
                    $isApprovedForCurrentUser = true;
                    break;
                }
            }

            // frontend options
            $frontendOptions = [
                'isEventReadyToStart' => count($members) === $eventModel->getCountMembersMax(),
                'isApprovedForCurrentUser' => $isApprovedForCurrentUser,
                'isWaitingForApprovalForCurrentUser' => $isWaitingForApprovalForCurrentUser,
                'isActiveUserEvent' => $organizerModel->getId() === $currentUser?->getId(),
            ];

            $eventModel
                ->setFrontendOptions($frontendOptions)
                ->setMembers($members)
                ->setCandidates($candidates)
                ->setAvatar($eventAvatar)
                ->setOrganizer($organizerModel);

            $result[] = $eventModel;
        }

        return $result;
    }

    /**
     * @param Event[] $events
     *
     * @return EventResponseModel[]
     */
    public function fromEvents(array $events, ?User $currentUser): array
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
