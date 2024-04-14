<?php

namespace App\Service\Notification;

use App\Entity\User;
use App\Model\Notification\Factory\SentMessageModelFactory;
use App\Model\Notification\SentMessageListModel;
use App\Repository\SentMessageRepository;
use Carbon\Carbon;

class SentMessageService
{
    public function __construct(
        private SentMessageRepository $sentMessageRepository,
        private SentMessageModelFactory $sentMessageModelFactory,
    ) {
    }

    public function getPushAll(User $user): SentMessageListModel
    {
        $sentMessages = $this->sentMessageRepository->getPushByUser($user);
        $models = $this->sentMessageModelFactory->fromSentMessages($sentMessages);

        $result = [];
        foreach ($models as $model) {
            $sentAt = Carbon::instance($model->getSentAt());
            if (true === $sentAt->isToday()) {
                $result['today'][] = $model;

                continue;
            }

            if (true === $sentAt->isYesterday()) {
                $result['yesterday'][] = $model;

                continue;
            }

            $startOfWeek = Carbon::now()->startOfWeek();
            $endOfWeek = Carbon::now()->endOfWeek();
            if (true === $sentAt->between($startOfWeek, $endOfWeek)) {
                $result['week'][] = $model;

                continue;
            }

            $startOfMonth = Carbon::now()->startOfMonth();
            $endOfMonth = Carbon::now()->endOfMonth();
            if (true === $sentAt->between($startOfMonth, $endOfMonth)) {
                $result['month'][] = $model;

                continue;
            }

            $startOfYear = Carbon::now()->startOfYear();
            $endOfYear = Carbon::now()->endOfYear();
            if (true === $sentAt->between($startOfYear, $endOfYear)) {
                $result[$sentAt->monthName][] = $model;

                continue;
            }

            $result['past'][] = $model;
        }

        return new SentMessageListModel($result);
    }
}
