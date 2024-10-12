<?php

namespace App\Service\Notification;

use App\Notification\NotificationInterface;
use App\Notification\Push\Push;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Notifier\Exception\TransportExceptionInterface;

class MessageSender
{
    public function __construct(
        private LoggerInterface $logger,
        private MessageBusInterface $messageBus,
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

    /**
     * @throws TransportExceptionInterface
     */
    private function sendToMessenger(NotificationInterface $notification): void
    {
        $this->messageBus->dispatch($notification);
    }
}
