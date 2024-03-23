<?php

namespace App\Repository;

use App\Entity\City;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method City|null find($id, $lockMode = null, $lockVersion = null)
 * @method City|null findOneBy(array $criteria, array $orderBy = null)
 * @method City[]    findAll()
 * @method City[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, City::class);
    }

    public function findOneByNameCoordinates(
        string $name,
        float $longitude,
        float $latitude,
    ): ?City {
        $qb = $this->createQueryBuilder('city');
        $qb
            ->select('city')
            ->where(
                $qb->expr()->eq(
                    $qb->expr()->lower('city.name'),
                    ':name',
                )
            )
            ->andWhere(
                $qb->expr()->eq(
                    'city.latitude',
                    ':latitude'
                )
            )
            ->andWhere(
                $qb->expr()->eq(
                    'city.longitude',
                    ':longitude',
                )
            )
            ->setParameters([
                'name' => sprintf('%%%s%%', mb_strtolower($name)),
                'longitude' => $longitude,
                'latitude' => $latitude,
            ])
            ->setMaxResults(1);

        return $qb->getQuery()->getOneOrNullResult();
    }
}
