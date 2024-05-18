<?php

namespace App\Notification\Push;

class ApprovedEventRequestNotification extends Push
{
    public const EVENT = 'approved_even_request';
    public const SUBJECT = 'Welcome 👨‍🦼';
    public const CONTEXT_PATTERN = 'Вас добавили в "%s"';
    public const BODY_TEXT_PATTERN = 'Вас добавили в {{%s}}';

    public function getSubject(): string
    {
        return self::SUBJECT;
    }
}
