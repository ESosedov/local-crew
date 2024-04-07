<?php

namespace App\Service\Notification\Push;

use App\Entity\User;
use App\Service\Notification\NotificationServiceInterface;
use App\Service\PushToken\PushTokenService;
use Symfony\Component\Notifier\Bridge\Expo\ExpoOptions;
use Symfony\Component\Notifier\Exception\TransportExceptionInterface;
use Symfony\Component\Notifier\Message\PushMessage;
use Symfony\Component\Notifier\TexterInterface;

class PushNotificationService implements NotificationServiceInterface
{
    public function __construct(private TexterInterface $texter,
        private PushTokenService $pushTokenService,
    ) {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function send(User $user, string $subject, string $context): void
    {
        $token = $this->pushTokenService->get($user);
        $options = new ExpoOptions($token);
        $push = new PushMessage($subject, $context, $options);
        // todo::
        $message = $this->texter->send($push);
    }
}
