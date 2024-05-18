<?php

namespace App\Service\Event;

use App\Entity\Event;
use App\Entity\User;
use App\Model\Event\CreateEventModel;
use App\Model\Event\EventResponseModel;
use App\Model\Event\Factory\EventResponseModelFactory;
use App\Model\Event\ListFilterModel;
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

        $this->eventMemberService->addOrganizer($user, $event);

        return $this->eventResponseModelFactory->fromEvent($event, $user);
    }

    public function getList(ListFilterModel $filterModel, User|null $user): ResponseListModel
    {
        $listData = $this->eventListQuery->getListData($filterModel);
        $countList = $this->eventListQuery->getCountList($filterModel);

        $eventsModels = $this->eventResponseModelFactory->fromEvents($listData, $user);

        return new ResponseListModel($eventsModels, $countList);
    }

    public function getById(string $id, User $user): EventResponseModel
    {
        $event = $this->eventRepository->find($id);
        if (null === $event) {
            throw new RuntimeException('Event not fained');
        }

        return $this->eventResponseModelFactory->fromEvent($event, $user);
    }
}
