<?php

namespace App\Service\Notification;

use App\Notification\NotificationInterface;
use App\Notification\Push\Push;
use App\Service\Notification\Push\PushNotificationService;
use Psr\Log\LoggerInterface;
use Symfony\Component\Notifier\Exception\TransportExceptionInterface;

class MessageSender
{
    public function __construct(
        private LoggerInterface $logger,
        private PushNotificationService $pushNotificationService,
        private SaveNotificationService $saveNotificationService,
    ) {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sentNotification(NotificationInterface $notification): void
    {
        if ($notification instanceof Push) {
            $this->sendToMessenger($notification);

            return;
        }

        $this->logger->error('Notification has not been dispatched', ['notification' => $notification]);
    }

    // todo:: тут должна быть отправка в очереди пока сразу напрямую шлю

    /**
     * @throws TransportExceptionInterface
     */
    private function sendToMessenger(NotificationInterface $notification): void
    {
        $messageId = $this->pushNotificationService->send(
            $notification->getUserId(),
            $notification->getSubject(),
            $notification->getMessage(),
        );

        if (null !== $messageId) {
            $this->saveNotificationService->savePush(
                $notification->getUserId(),
                $notification->getEventId(),
                $notification->getType(),
                $notification->getEvent(),
                $notification->getSubject(),
                $notification->getMessage(),
                $messageId,
                $notification->getCreatedBy(),
            );
        } else {
            $this->logger->error('Notification has not been sent', ['notification' => $notification]);
        }
    }
}
