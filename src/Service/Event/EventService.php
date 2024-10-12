<?php

namespace App\Service\Event;

use App\Entity\Event;
use App\Entity\Location;
use App\Entity\User;
use App\Model\Event\CreateEventModel;
use App\Model\Event\EventListModel;
use App\Model\Event\EventResponseModel;
use App\Model\Event\Factory\EventListItemModelFactory;
use App\Model\Event\Factory\EventResponseModelFactory;
use App\Model\Event\ListFilterModel;
use App\Model\Event\LocalListFilterModel;
use App\Model\Event\ResponseListModel;
use App\Query\Event\EventListQuery;
use App\Repository\CategoryRepository;
use App\Repository\EventRepository;
use App\Service\File\FileService;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;

class EventService
{
    public function __construct(
        private FileService $fileService,
        private EntityManagerInterface $entityManager,
        private EventMemberService $eventMemberService,
        private EventResponseModelFactory $eventResponseModelFactory,
        private EventListQuery $eventListQuery,
        private CategoryRepository $categoryRepository,
        private EventRepository $eventRepository,
        private EventListItemModelFactory $eventListItemModelFactory,
    ) {
    }

    /**
     * @throws \Exception
     */
    public function create(User $user, CreateEventModel $createEventModel): EventResponseModel
    {
        $avatar = $this->fileService->uploadFile($createEventModel->getAvatar());
        $date = \DateTimeImmutable::createFromMutable($createEventModel->getDate());
        $event = new Event();
        $event
            ->setTitle($createEventModel->getTitle())
            ->setDate($date)
            ->setTimeZone($createEventModel->getTimeZone())
            ->setType($createEventModel->getType())
            ->setParticipationTerms($createEventModel->getParticipationTerms())
            ->setDetails($createEventModel->getDetails())
            ->setAvatar($avatar)
            ->setCreatedBy($user)
            ->setCountMembersMax($createEventModel->getCountMembersMax());

        $categories = $this->categoryRepository->getByIds($createEventModel->getCategories());
        foreach ($categories as $category) {
            $event->addCategory($category);
        }

        $this->entityManager->persist($event);

        if (Event::TYPE_LOCAL === $createEventModel->getType()) {
            $location = new Location();
            $location
                ->setLatitude($createEventModel->getLatitude())
                ->setLongitude($createEventModel->getLongitude())
                ->setCity($createEventModel->getCity())
                ->setStreet($createEventModel->getStreet())
                ->setStreetNumber($createEventModel->getStreetNumber())
                ->setPlaceName($createEventModel->getPlaceName());

            $this->entityManager->persist($location);
            $event->setLocation($location);
        }

        $this->eventMemberService->addOrganizer($user, $event);

        return $this->eventResponseModelFactory->fromEvent($event, $user);
    }

    public function getList(ListFilterModel $filterModel, ?User $user): ResponseListModel
    {
        // $listData = $this->eventListQuery->getListData($filterModel, $user);
        $listData = $this->eventListQuery->getNewListDataListFilterModel($filterModel, $user);

        $countList = $this->eventListQuery->getCountList($filterModel, $user);

        $eventsModels = $this->eventResponseModelFactory->fromEventsListData($listData, $user);

        return new ResponseListModel($eventsModels, $countList);
    }

    public function getLocalList(LocalListFilterModel $filters, ?User $user): array
    {
        $listData = $this->eventListQuery->getLocalListData($filters);

        return $this->eventResponseModelFactory->fromEvents($listData, $user);
    }

    public function getById(string $id, User $user): EventResponseModel
    {
        $event = $this->eventRepository->getOneWithFullInfo($id);
        if (null === $event) {
            throw new RuntimeException('Event not fained');
        }

        return $this->eventResponseModelFactory->fromEvent($event, $user);
    }

    public function getEventsList(ListFilterModel $filterModel, ?User $user)
    {
        $listData = $this->eventListQuery->getEventsListData($filterModel, $user);
        $count = $this->eventListQuery->getEventsListCount($filterModel, $user);
        $models = $this->eventListItemModelFactory->fromEventListData($listData, $user);

        return new EventListModel($models, $count);
    }
}
