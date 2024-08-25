<?php

namespace App\Messenger\MessageHandler;

use App\Notification\Push\Push;
use App\Service\Notification\Push\PushNotificationService;
use App\Service\Notification\SaveNotificationService;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class PushMessageHandler
{
    public function __construct(
        private LoggerInterface $logger,
        private PushNotificationService $pushNotificationService,
        private SaveNotificationService $saveNotificationService,
    ) {
    }

    public function __invoke(Push $notification): void
    {
        try {
            $messageId = $this->pushNotificationService->send(
                $notification->getUserId(),
                $notification->getSubject(),
                $notification->getMessage(),
            );
        } catch (Exception $exception) {
            $this->logger->error(
                $exception->getMessage(),
                [
                    'notification' => $notification,
                    'exception' => $exception,
                ],
            );
        }

        $this->saveNotificationService->savePush(
            $notification->getUserId(),
            $notification->getEventId(),
            $notification->getType(),
            $notification->getEvent(),
            $notification->getSubject(),
            $notification->getMessage(),
            $messageId ?? null,
            $notification->getCreatedBy(),
            $notification->getBodyText(),
        );
    }
}
