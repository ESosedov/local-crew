<?php

namespace App\Repository;

use App\Entity\Event;
use App\Entity\EventRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EventRequest|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventRequest|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventRequest[] findAll()
 * @method EventRequest[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRequestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventRequest::class);
    }

    public function save(EventRequest $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return EventRequest[]
     */
    public function getNewByEvent(Event|string $event): array
    {
        $qb = $this->createQueryBuilder('eventRequest');
        $qb
            ->select('eventRequest')
            ->innerJoin('eventRequest.createdBy', 'user')
            ->where('eventRequest.event = :event')
            ->andWhere('eventRequest.status = :new')
            ->setParameters([
                'event' => $event,
                'new' => EventRequest::STATUS_NEW,
            ]);

        return $qb->getQuery()->getResult();
    }
}
