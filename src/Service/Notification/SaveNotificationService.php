<?php

namespace App\Service\Notification;

use App\Entity\Event;
use App\Entity\SentMessage;
use App\Entity\User;
use App\Repository\EventRepository;
use App\Repository\SentMessageRepository;
use App\Repository\UserRepository;

class SaveNotificationService
{
    public function __construct(
        private SentMessageRepository $sentMessageRepository,
        private UserRepository $userRepository,
        private EventRepository $eventRepository,
    ) {
    }

    public function savePush(
        User|string $user,
        Event|string $event,
        string $type,
        string|null $source,
        string|null $subject,
        string|null $message,
        string|null $identifier,
        User|string $createdBy,
    ): void {
        if (!$user instanceof User) {
            $user = $this->userRepository->find($user);
        }
        if (!$createdBy instanceof User) {
            $createdBy = $this->userRepository->find($createdBy);
        }
        if (!$event instanceof Event) {
            $event = $this->eventRepository->find($event);
        }

        $sentMessage = new SentMessage();
        $sentMessage
            ->setUser($user)
            ->setEvent($event)
            ->setType($type)
            ->setSource($source)
            ->setTitle($subject)
            ->setMessage($message)
            ->setIdentifier($identifier)
            ->setCreatedBy($createdBy);

        $this->sentMessageRepository->save($sentMessage, true);
    }
}
