<?php

namespace App\Notification\Push;

class EventRequestNotification extends Push
{
    public const EVENT = 'event_request';
    public const SUBJECT = 'Запрос на участие 👋';
    public const CONTEXT_PATTERN = '%s хочет участвовать в "%s"';
    public const BODY_TEXT_PATTERN = '{{%s}} хочет участвовать в {{%s}}';

    public function getSubject(): string
    {
        return self::SUBJECT;
    }
}
