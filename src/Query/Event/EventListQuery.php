<?php

namespace App\Query\Event;

use App\Entity\Event;
use App\Entity\EventRequest;
use App\Model\Event\ListFilterModel;
use App\Repository\EventRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;

class EventListQuery
{
    public function __construct(private EventRepository $eventRepository)
    {
    }

    /**
     * @return Event[]
     */
    public function getListData(ListFilterModel $filterModel): array
    {
        $qb = $this->getQBList($filterModel);
        $qb
            ->select('event', 'eventMember', 'members', 'requests', 'candidates', 'categories')
            ->addSelect('event.date AS HIDDEN date')
            ->addSelect('event.createdAt AS HIDDEN createdAt')
            ->orderBy($filterModel->getOrderBy(), $filterModel->getOrderDirection());
        // ->setFirstResult(($filterModel->getPage() - 1) * $filterModel->getItemsPerPage())
        // ->setMaxResults($filterModel->getItemsPerPage());

        return $qb->getQuery()->getResult();
    }

    public function getCountList(ListFilterModel $filterModel): int
    {
        $qb = $this->getQBList($filterModel);

        return $qb
            ->select('COUNT(DISTINCT(event.id))')
            ->setMaxResults(1)
            ->getQuery()
            ->getSingleScalarResult();
    }

    private function getQBList(ListFilterModel $filterModel): QueryBuilder
    {
        $qb = $this->eventRepository->createQueryBuilder('event');
        $qb
            ->leftJoin('event.members', 'eventMember')
            ->leftJoin('eventMember.user', 'members')
            ->leftJoin(
                'event.requests',
                'requests',
                Join::WITH,
                $qb->expr()->andX(
                    'requests.status = :newEventRequest',
                    'requests.event = event',
                ),
            )
            ->leftJoin('requests.createdBy', 'candidates')
            ->leftJoin('event.categories', 'categories')
            ->setParameters([
                'newEventRequest' => EventRequest::STATUS_NEW,
            ]);

        if (null !== $filterModel->getOrganizerId()) {
            $qb
                ->innerJoin(
                    'event.members',
                    'eventMemberOrganizer',
                    Join::WITH,
                    $qb->expr()->andX(
                        'eventMemberOrganizer.isOrganizer = :true',
                        'eventMemberOrganizer.user = :organizerId',
                    ),
                )
                ->setParameter('true', true)
                ->setParameter('organizerId', $filterModel->getOrganizerId());
        }

        return $qb;
    }

    public function getFullEvent(string $id)
    {
        $qb = $this->eventRepository->createQueryBuilder('event');
        $qb
            ->select('event', 'eventMember', 'members', 'requests', 'candidates', 'categories')
            ->leftJoin('event.members', 'eventMember')
            ->leftJoin('eventMember.user', 'members')
            ->leftJoin(
                'event.requests',
                'requests',
                Join::WITH,
                $qb->expr()->andX(
                    'requests.status = :newEventRequest',
                    'requests.event = event',
                ),
            )
            ->leftJoin('requests.createdBy', 'candidates')
            ->leftJoin('event.categories', 'categories')
            ->setParameters([
                'newEventRequest' => EventRequest::STATUS_NEW,
            ]);

        return $qb->getQuery()->getResult();
    }
}
