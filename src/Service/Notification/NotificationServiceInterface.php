<?php

namespace App\Service\Notification;

use App\Entity\User;

interface NotificationServiceInterface
{
    public function send(User $user, string $subject, string $context);
}
