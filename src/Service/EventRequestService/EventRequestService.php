<?php

namespace App\Service\EventRequestService;

use App\Entity\EventRequest;
use App\Entity\User;
use App\EventSubscriber\EventRequest\EventRequestWorkFlowSubscriber;
use App\Repository\EventRepository;
use App\Repository\EventRequestRepository;
use Symfony\Component\Workflow\Event\Event as EventNotification;
use Symfony\Component\Workflow\Marking;
use Symfony\Component\Workflow\WorkflowInterface;
use Symfony\Component\Yaml\Exception\RuntimeException;

class EventRequestService
{
    public function __construct(
        private EventRequestRepository $eventRequestRepository,
        private EventRepository $eventRepository,
        private EventRequestWorkFlowSubscriber $eventRequestWorkFlowSubscriber,
        private WorkflowInterface $eventRequestStateMachine,
    ) {
    }

    public function create(string $id, User $user): void
    {
        $event = $this->eventRepository->find($id);
        if (null === $event) {
            throw new RuntimeException('Event not found');
        }
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

    public function approve(string $id): void
    {
        $eventRequest = $this->eventRequestRepository->find($id);
        if (null === $eventRequest) {
            throw new RuntimeException('Request participation not found');
        }
        if ($this->eventRequestStateMachine->can($eventRequest, 'approve')) {
            $this->eventRequestStateMachine->apply($eventRequest, 'approve');
        }

        $this->eventRequestRepository->save($eventRequest, true);
    }

    public function reject(string $id): void
    {
        $eventRequest = $this->eventRequestRepository->find($id);
        if (null === $eventRequest) {
            throw new RuntimeException('Request participation not found');
        }

        $this->eventRequestStateMachine->apply($eventRequest, 'reject');

        $this->eventRequestRepository->save($eventRequest, true);
    }
}
