<?php

namespace App\Notification\Push;

class RejectedEventRequestNotification extends Push
{
    public const EVENT = 'rejected_even_request';
    public const SUBJECT = 'Sorry 🖕🏾';
    public const CONTEXT_PATTERN = 'Вы не допущены к участию в мероприятии "%s"';
    public const BODY_TEXT_PATTERN = 'Вы не допущены к участию в мероприятии {{%s}}';

    public function getSubject(): string
    {
        return self::SUBJECT;
    }
}
