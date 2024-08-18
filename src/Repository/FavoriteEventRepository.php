<?php

namespace App\Repository;

use App\Entity\FavoriteEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FavoriteEvent|null find($id, $lockMode = null, $lockVersion = null)
 * @method FavoriteEvent|null findOneBy(array $criteria, array $orderBy = null)
 * @method FavoriteEvent[] findAll()
 * @method FavoriteEvent[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FavoriteEventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FavoriteEvent::class);
    }

    public function save(FavoriteEvent $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(FavoriteEvent $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
