<?php

namespace App\Notification\Push;

class EventRequestNotification extends Push
{
    public const EVENT = 'event_request';
    public const SUBJECT = 'Запрос на участие 👋';

    public function getSubject(): string
    {
        return self::SUBJECT;
    }
}
