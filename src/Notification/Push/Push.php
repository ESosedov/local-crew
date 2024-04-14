<?php

namespace App\Notification\Push;

use App\Notification\Notification;

abstract class Push extends Notification
{
    public const TYPE = 'push';
}
