<?php

namespace App\Repository;

use App\Entity\EventMember;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EventMember|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventMember|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventMember[]    findAll()
 * @method EventMember[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventMemberRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventMember::class);
    }
}
