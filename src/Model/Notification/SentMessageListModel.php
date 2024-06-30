<?php

namespace App\Model\Notification;

class SentMessageListModel
{
    public function __construct(
        /**
         * @var SentMessageModel[]
         */
        private array $notification,
    ) {
    }

    public function getNotification(): array
    {
        return $this->notification;
    }
}
