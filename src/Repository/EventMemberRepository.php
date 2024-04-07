<?php

namespace App\Repository;

use App\Entity\Event;
use App\Entity\EventMember;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EventMember|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventMember|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventMember[] findAll()
 * @method EventMember[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventMemberRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventMember::class);
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function getCountApproved(Event $event): int
    {
        $qb = $this->createQueryBuilder('eventMember');
        $qb
            ->select('COUNT(eventMember.id')
            ->where('eventMember.event = :event')
            ->andWhere('eventMember.isApproved = :isApproved')
            ->setParameters([
                'event' => $event,
                'isApproved' => true,
            ])
            ->setMaxResults(1);

        return $qb->getQuery()->getSingleScalarResult();
    }

    /**
     * @throws NonUniqueResultException
     */
    public function getOneByEventAndUser(Event $event, User $user): ?EventMember
    {
        $qb = $this->createQueryBuilder('eventMember');
        $qb
            ->select('eventMember')
            ->where('eventMember.event = :event')
            ->andWhere('eventMember.user = :user')
            ->setParameters([
                'event' => $event,
                'user' => $user,
            ])
            ->setMaxResults(1);

        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @throws NonUniqueResultException
     */
    public function getOrganizer(Event $event): EventMember
    {
        $qb = $this->createQueryBuilder('eventMember');
        $qb
            ->select('eventMember')
            ->where('eventMember.event = :event')
            ->andWhere('eventMember.isOrganizer = :isOrganizer')
            ->setParameters([
                'event' => $event,
                'isOrganizer' => true,
            ])
            ->setMaxResults(1);

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function save(EventMember $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
