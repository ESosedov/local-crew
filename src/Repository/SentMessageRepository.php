<?php

namespace App\Repository;

use App\Entity\SentMessage;
use App\Entity\User;
use App\Notification\Push\Push;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SentMessage|null find($id, $lockMode = null, $lockVersion = null)
 * @method SentMessage|null findOneBy(array $criteria, array $orderBy = null)
 * @method SentMessage[] findAll()
 * @method SentMessage[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SentMessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SentMessage::class);
    }

    public function getPushByUser(User $user): array
    {
        $qb = $this->createQueryBuilder('sentMessage');
        $qb
            ->select('sentMessage')
            ->where('sentMessage.user = :user')
            ->andWhere('sentMessage.type = :pushType')
            ->orderBy('sentMessage.createdAt', Criteria::DESC)
            ->setParameters([
                'user' => $user,
                'pushType' => Push::TYPE,
            ]);

        return $qb->getQuery()->getResult();
    }

    public function save(SentMessage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
