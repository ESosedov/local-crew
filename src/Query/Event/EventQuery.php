<?php

namespace App\Query\Event;

use App\Entity\EventMember;
use App\Entity\EventRequest;
use App\Entity\User;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Expr\Join;

class EventQuery
{
    public function __construct(
        private EventRepository $eventRepository,
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function getCategoriesById(array $eventIds): array
    {
        $qb = $this->eventRepository->createQueryBuilder('event');
        $qb
            ->select('(event.id) AS eventId', '(category.id) AS categoryId')
            ->innerJoin('event.categories', 'category')
            ->where('event.id IN (:ids)')
            ->setParameter('ids', $eventIds);

        $results = $qb->getQuery()->getResult();

        $eventCategories = [];

        foreach ($results as $result) {
            $eventId = $result['eventId'];
            $categoryId = $result['categoryId'];

            if (!isset($eventCategories[$eventId])) {
                $eventCategories[$eventId] = [];
            }

            $eventCategories[$eventId][] = $categoryId;
        }

        return $eventCategories;
    }

    public function getCandidatesByIds(array $eventIds): array
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb
            ->select('user AS candidate')
            ->addSelect('(event.id) AS eventId')
            ->from(User::class, 'user')
            ->innerJoin(
                EventRequest::class,
                'request',
                Join::WITH,
                'user.id = request.createdBy',
            )
            ->innerJoin('request.event', 'event')
            ->leftJoin('user.avatar', 'avatar')
            ->where('event.id IN (:ids)')
            ->andWhere('request.status = :newStatus')
            ->setParameters([
                'ids' => $eventIds,
                'newStatus' => EventRequest::STATUS_NEW,
            ]);

        $results = $qb->getQuery()->getResult();

        $eventCandidates = [];

        foreach ($results as $result) {
            $candidate = $result['candidate'];
            $eventId = $result['eventId'];

            if (!isset($eventCandidates[$eventId])) {
                $eventCandidates[$eventId] = [];
            }

            $eventCandidates[$eventId][] = $candidate;
        }

        return $eventCandidates;
    }

    public function getMembersByIds(array $eventIds): array
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb
            ->select('user AS member')
            ->addSelect('(event.id) AS eventId')
            ->from(User::class, 'user')
            ->innerJoin(
                EventMember::class,
                'eventMember',
                Join::WITH,
                'user.id = eventMember.user',
            )
            ->innerJoin('eventMember.event', 'event')
            ->leftJoin('user.avatar', 'avatar')
            ->where('event.id IN (:ids)')
            ->setParameter('ids', $eventIds);

        $results = $qb->getQuery()->getResult();

        $eventMembers = [];
        foreach ($results as $result) {
            $member = $result['member'];
            $eventId = $result['eventId'];

            if (!isset($eventMembers[$eventId])) {
                $eventMembers[$eventId] = [];
            }

            $eventMembers[$eventId][] = $member;
        }

        return $eventMembers;
    }
}
