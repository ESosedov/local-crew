<?php

namespace App\Notification;

abstract class Notification implements NotificationInterface
{
    public const TYPE = 'general';

    public const EVENT = 'general';

    public static function getType(): string
    {
        return static::TYPE;
    }

    public static function getEvent(): string
    {
        return static::EVENT;
    }
}
