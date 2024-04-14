<?php

namespace App\Notification\Push;

class EventRequestNotification extends Push
{
    public const EVENT = 'event_request';
    public const SUBJECT = 'Запрос на участие 👋';

    public function __construct(
        protected string $userId,
        protected string $message,
        private string $eventId,
        private string $createdBy,
    ) {
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getSubject(): string
    {
        return self::SUBJECT;
    }

    public function getEventId(): string
    {
        return $this->eventId;
    }

    public function getCreatedBy(): string
    {
        return $this->createdBy;
    }
}
