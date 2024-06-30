<?php

namespace App\Notification;

interface NotificationInterface
{
    public static function getType(): string;

    public static function getEvent(): string;
}
