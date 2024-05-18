<?php

namespace App\Notification\Push;

class RejectedEventRequestNotification extends Push
{
    public const EVENT = 'rejected_even_request';
    public const SUBJECT = 'Sorry 🖕🏾';

    public function getSubject(): string
    {
        return self::SUBJECT;
    }
}
