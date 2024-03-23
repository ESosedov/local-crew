<?php

namespace App\Service\Event;

use App\Entity\Event;
use App\Entity\User;
use App\Model\Event\CreateEventModel;
use App\Model\Event\EventResponseModel;
use App\Model\Event\Factory\EventResponseModelFactory;
use App\Service\File\FileService;
use Doctrine\ORM\EntityManagerInterface;

class EventService
{
    public function __construct(
        private FileService $fileService,
        private EntityManagerInterface $entityManager,
        private EventMemberService $eventMemberService,
        private EventResponseModelFactory $eventResponseModelFactory,
    ) {
    }

    /**
     * @throws \Exception
     */
    public function create(User $user, CreateEventModel $createEventModel): EventResponseModel
    {
        $avatar = $this->fileService->uploadFile($createEventModel->getAvatar());

        $event = new Event();
        $event
            ->setTitle($createEventModel->getTitle())
            ->setDate($createEventModel->getDate())
            ->setType($createEventModel->getType())
            ->setParticipationTerms($createEventModel->getParticipationTerms())
            ->setDetails($createEventModel->getDetails())
            ->setAvatar($avatar);

        $this->entityManager->persist($event);

        $this->eventMemberService->addOrganizer($user, $event);

        return $this->eventResponseModelFactory->fromEvent($event);
    }
}
