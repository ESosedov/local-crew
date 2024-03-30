<?php

namespace App\Query\Event;

use App\Entity\Event;
use App\Entity\EventMember;
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
            ->select('event')
            ->addSelect('event.date AS HIDDEN date')
            ->orderBy($filterModel->getOrderBy(), $filterModel->getOrderDirection())
            ->setFirstResult(($filterModel->getPage() - 1) * $filterModel->getItemsPerPage())
            ->setMaxResults($filterModel->getItemsPerPage());

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
        if (null !== $filterModel->getOrganizerId()) {
            $qb
                ->innerJoin(
                    EventMember::class,
                    'eventMemberOrganizer',
                    Join::WITH,
                    $qb->expr()->andX(
                        'eventMemberOrganizer.event = event',
                        'eventMemberOrganizer.isOrganizer = :true',
                        'eventMemberOrganizer.user = :organizerId',
                    ),
                )
                ->setParameters([
                    'true' => true,
                    'organizerId' => $filterModel->getOrganizerId(),
                ]);
        }

        return $qb;
    }
}
