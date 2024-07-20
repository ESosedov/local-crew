<?php

namespace App\Query\Event;

use App\Entity\Event;
use App\Entity\EventRequest;
use App\Model\Event\ListFilterModel;
use App\Model\Event\LocalListFilterModel;
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

    public function getLocalListData(LocalListFilterModel $filters): array
    {
        $coordinates = array_map(static function ($coordinate) {
            return [$coordinate->getLatitude(), $coordinate->getLongitude()];
        }, $filters->getPoints());

        $qb = $this->eventRepository->createQueryBuilder('event');
        $qb
            ->select('event')
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


        if ([] !== $filters->getPoints()) {
            $qb
                ->innerJoin('event.location', 'location')
                ->where(
                    $qb->expr()->andX(
                        $qb->expr()->gte('location.latitude', ':minLat'),
                        $qb->expr()->lte('location.latitude', ':maxLat'),
                        $qb->expr()->gte('location.longitude', ':minLon'),
                        $qb->expr()->lte('location.longitude', ':maxLon'),
                    ),
                )
                ->setParameter('minLat', min(array_column($coordinates, 0)))
                ->setParameter('maxLat', max(array_column($coordinates, 0)))
                ->setParameter('minLon', min(array_column($coordinates, 1)))
                ->setParameter('maxLon', max(array_column($coordinates, 1)));
        }

        return $qb->getQuery()->getResult();
    }
}
