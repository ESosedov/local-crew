<?php

namespace App\Repository;

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
}
