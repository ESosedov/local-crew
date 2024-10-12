<?php

namespace App\Model\Event;

class EventListModel
{
    public function __construct(
        /**
         * @var EventListItemMode[]
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
