<?php

namespace App\Repository;

use App\Entity\PushToken;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PushToken|null find($id, $lockMode = null, $lockVersion = null)
 * @method PushToken|null findOneBy(array $criteria, array $orderBy = null)
 * @method PushToken[] findAll()
 * @method PushToken[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PushTokenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PushToken::class);
    }

    public function save(PushToken $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function removeByUser(User $user): void
    {
        $qb = $this->createQueryBuilder('pushToken');
        $qb
            ->delete()
            ->where('pushToken.user = :user')
            ->setParameter('user', $user);

        $qb->getQuery()->execute();
    }
}
