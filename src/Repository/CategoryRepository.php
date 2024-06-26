<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[] findAll()
 * @method Category[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    /**
     * @param string[] $ids
     *
     * @return Category[]
     */
    public function getByIds(array $ids): array
    {
        $qb = $this->createQueryBuilder('category');
        $qb
            ->select('category')
            ->where('category.id IN (:ids)')
            ->setParameter('ids', $ids);

        return $qb->getQuery()->getResult();
    }

    public function getAllTitlesById(): array
    {
        $qb = $this->createQueryBuilder('category');
        $qb
            ->select('CAST(category.id AS string) AS id')
            ->addSelect('category.title AS title');

        $result = $qb->getQuery()->getArrayResult();

        return array_column($result, 'title', 'id');
    }

    public function getAllIds(): array
    {
        $qb = $this->createQueryBuilder('category');
        $qb->select('CAST(category.id AS string) AS id');

        $result = $qb->getQuery()->getArrayResult();

        return array_column($result, 'id');
    }
}
