<?php

namespace App\Notification\Push;

class ApprovedEventRequestNotification extends Push
{
    public const EVENT = 'approved_even_request';
    public const SUBJECT = 'Welcome 👨‍🦼';

    public function getSubject(): string
    {
        return self::SUBJECT;
    }
}
