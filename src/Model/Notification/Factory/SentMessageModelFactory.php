<?php

namespace App\Model\Notification\Factory;

use App\Entity\SentMessage;
use App\Model\Notification\SentMessageModel;
use App\Model\User\Factory\UserPublicModelFactory;

class SentMessageModelFactory
{
    public function __construct(private UserPublicModelFactory $userPublicModelFactory)
    {
    }

    public function fromSentMessage(SentMessage $sentMessage): SentMessageModel
    {
        $sentBy = $this->userPublicModelFactory->fromUser($sentMessage->getCreatedBy());

        return new SentMessageModel(
            $sentMessage->getTitle(),
            $sentMessage->getMessage(),
            $sentBy,
            $sentMessage->getCreatedAt(),
            $sentMessage->getType(),
            $sentMessage->getEvent()->getId(),
        );
    }

    /**
     * @return SentMessageModel[]
     */
    public function fromSentMessages(array $sentMessages): array
    {
        $result = [];
        foreach ($sentMessages as $sentMessage) {
            $result[] = $this->fromSentMessage($sentMessage);
        }

        return $result;
    }
}
