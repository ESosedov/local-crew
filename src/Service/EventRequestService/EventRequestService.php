<?php

namespace App\Service\EventRequestService;

use App\Entity\EventRequest;
use App\Entity\User;
use App\EventSubscriber\EventRequest\EventRequestWorkFlowSubscriber;
use App\Repository\EventRepository;
use App\Repository\EventRequestRepository;
use Symfony\Component\Workflow\Event\Event as EventNotification;
use Symfony\Component\Workflow\Marking;

class EventRequestService
{
    public function __construct(
        private EventRequestRepository $eventRequestRepository,
        private EventRepository $eventRepository,
        private EventRequestWorkFlowSubscriber $eventRequestWorkFlowSubscriber,
    ) {
    }

    public function create(string $id, User $user): void
    {
        $event = $this->eventRepository->find($id);
        $eventRequest = new EventRequest();
        $eventRequest
            ->setStatus(EventRequest::STATUS_NEW)
            ->setEvent($event)
            ->setCreatedBy($user);

        $this->eventRequestRepository->save($eventRequest, true);

        $eventNotification = new EventNotification($eventRequest, new Marking());

        // Вызываем метод onEnteredNew вручную
        $this->eventRequestWorkFlowSubscriber->onEnteredNew($eventNotification);
    }
}
