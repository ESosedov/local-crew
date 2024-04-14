<?php

namespace App\EventSubscriber\EventRequest;

use App\Entity\EventRequest;
use App\Notification\Push\EventRequestNotification;
use App\Repository\EventMemberRepository;
use App\Service\Event\EventMemberService;
use App\Service\Notification\MessageSender;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Workflow\Event\Event;

class EventRequestWorkFlowSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private EventMemberRepository $eventMemberRepository,
        private EventMemberService $eventMemberService,
        private MessageSender $messageSender,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'workflow.event_request.entered.new' => 'onEnteredNew',
            'workflow.event_request.transition.submit' => 'onSubmit',
            'workflow.event_request.transition.reject' => 'onReject',
            'workflow.event_request.guard.submit' => 'guardSubmit',
        ];
    }

    public function guardSubmit(Event $event): void
    {
        /** @var EventRequest $subject */
        $subject = $event->getSubject();
        $eventEntity = $subject->getEvent();
        $count = $this->eventMemberRepository->getCountApproved($eventEntity);
        if ($count >= $eventEntity->getCountMembersMax()) {
            $event->setBlocked(true, 'Превышено допустимое количество участников');
        }
    }

    public function onEnteredNew(Event $event): void
    {
        /** @var EventRequest $subject */
        $subject = $event->getSubject();
        $eventEntity = $subject->getEvent();
        $user = $subject->getCreatedBy();

        $this->eventMemberService->createCandidate($eventEntity, $user);
        $organizer = $this->eventMemberService->getOrganizer($eventEntity);
        $context = sprintf('%s хочет участвовать в %s', $user->getName(), $eventEntity->getTitle());

        $notification = new EventRequestNotification(
            $organizer->getId(),
            $context,
            $eventEntity->getId(),
            $user->getId(),
        );
        $this->messageSender->sentNotification($notification);
    }

    public function onReject(): void
    {
    }

    public function onSubmit(Event $event): void
    {
        /** @var EventRequest $subject */
        $subject = $event->getSubject();
        $eventEntity = $subject->getEvent();
        $user = $subject->getCreatedAt();
        $this->eventMemberService->submitCandidate($eventEntity, $user);
    }
}
