<?php

namespace App\Repository;

use App\Entity\Event;
use App\Entity\EventRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[] findAll()
 * @method Event[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function save(Event $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getOneWithFullInfo(string $id): ?Event
    {
        $qb = $this->createQueryBuilder('event');
        $qb
            ->select('event', 'eventMember', 'members', 'requests', 'candidates')
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
            ->where('event.id = :id')
            ->setParameters([
                'id' => $id,
                'newEventRequest' => EventRequest::STATUS_NEW,
            ]);

        return $qb->getQuery()->getOneOrNullResult();
    }
}
