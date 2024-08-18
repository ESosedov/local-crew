<?php

namespace App\Service\Event;

use App\Entity\Event;
use App\Entity\FavoriteEvent;
use App\Entity\User;
use App\Repository\EventRepository;
use App\Repository\FavoriteEventRepository;

class FavoriteEventsService
{
    public function __construct(
        private FavoriteEventRepository $favoriteEventRepository,
        private EventRepository $eventRepository,
    ) {
    }

    public function add(Event|string $event, User $user): void
    {
        $favoriteEvent = $this->favoriteEventRepository->findOneBy(['user' => $user, 'event' => $event]);
        if (null !== $favoriteEvent) {
            return;
        }
        if (!$event instanceof Event) {
            $event = $this->eventRepository->find($event);
        }
        $favoriteEvent = new FavoriteEvent();
        $favoriteEvent
            ->setEvent($event)
            ->setUser($user);

        $this->favoriteEventRepository->save($favoriteEvent, true);
    }

    public function remove(Event|string $event, User $user): void
    {
        $favoriteEvent = $this->favoriteEventRepository->findOneBy(['user' => $user, 'event' => $event]);
        if (null === $favoriteEvent) {
            return;
        }

        $this->favoriteEventRepository->remove($favoriteEvent, true);
    }
}
