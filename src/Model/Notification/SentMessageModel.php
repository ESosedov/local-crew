<?php

namespace App\Model\Notification;

use App\Model\User\UserPublicModel;

class SentMessageModel
{
    public function __construct(
        private string $title,
        private string $body,
        private UserPublicModel $sentBy,
        private \DateTimeInterface $sentAt,
        private string $type,
        private string $eventId,
    ) {
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getSentBy(): UserPublicModel
    {
        return $this->sentBy;
    }

    public function getSentAt(): \DateTimeInterface
    {
        return $this->sentAt;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getEventId(): string
    {
        return $this->eventId;
    }
}
