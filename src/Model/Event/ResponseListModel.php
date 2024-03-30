<?php

namespace App\Model\Event;

class ResponseListModel
{
    public function __construct(
        /**
         * @var EventResponseModel[]
         */
        private array $events,
        private int $count,
    ) {
    }

    public function getEvents(): array
    {
        return $this->events;
    }

    public function getCount(): int
    {
        return $this->count;
    }
}
