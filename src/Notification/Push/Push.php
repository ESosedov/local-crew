<?php

namespace App\Notification\Push;

use App\Notification\Notification;

abstract class Push extends Notification
{
    public const TYPE = 'push';

    public function __construct(
        protected string $userId,
        protected string $message,
        private string $eventId,
        private string $createdBy,
        private string $bodyText,
    ) {
    }

    abstract public function getSubject(): string;

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getEventId(): string
    {
        return $this->eventId;
    }

    public function getCreatedBy(): string
    {
        return $this->createdBy;
    }

    public function getBodyText(): string
    {
        return $this->bodyText;
    }
}
