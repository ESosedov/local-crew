<?php

namespace App\Query\Event;

use App\Entity\Event;
use App\Entity\EventMember;
use App\Entity\EventRequest;
use App\Entity\FavoriteEvent;
use App\Entity\User;
use App\Model\Event\EventListItemMode;
use App\Model\Event\EventResponseModel;
use App\Model\Event\ListFilterModel;
use App\Model\Event\LocalListFilterModel;
use App\Model\File\FileDTO;
use App\Model\User\UserPublicModel;
use App\Repository\EventRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;

class EventListQuery
{
    public function __construct(private EventRepository $eventRepository)
    {
    }

    /**
     * @return Event[]
     */
    public function getListData(ListFilterModel $filterModel, ?User $user = null): array
    {
        $qb = $this->getQBList($filterModel, $user);
        $qb
            ->select('event', 'eventMember', 'members', 'requests', 'candidates', 'categories')
            ->addSelect('event.date AS HIDDEN date')
            ->addSelect('event.createdAt AS HIDDEN createdAt')
            ->orderBy($filterModel->getOrderBy(), $filterModel->getOrderDirection())
            ->setFirstResult(($filterModel->getPage() - 1) * $filterModel->getItemsPerPage())
            ->setMaxResults($filterModel->getItemsPerPage());

        return $qb->getQuery()->getResult();
    }

    public function getCountList(ListFilterModel $filterModel, ?User $user = null): int
    {
        $qb = $this->getQBListNew($filterModel, $user);

        return $qb
            ->select('COUNT(DISTINCT(event.id))')
            ->setMaxResults(1)
            ->getQuery()
            ->getSingleScalarResult();
    }

    private function getQBList(ListFilterModel $filterModel, ?User $user = null): QueryBuilder
    {
        $qb = $this->eventRepository->createQueryBuilder('event');
        $qb
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
            ->leftJoin('event.categories', 'categories')
            ->setParameters([
                'newEventRequest' => EventRequest::STATUS_NEW,
                'true' => true,
            ]);

        if (null !== $user) {
            $qb
                ->leftJoin(
                    FavoriteEvent::class,
                    'favoriteEvent',
                    Join::WITH,
                    $qb->expr()->andX(
                        'favoriteEvent.event = event',
                        'favoriteEvent.user = :user',
                    ),
                )
                ->setParameter('user', $user);
        }
        if (null !== $filterModel->getOrganizerId()) {
            $qb
                ->andWhere('eventMemberOrganizer.user = :organizerId')
                ->setParameter('organizerId', $filterModel->getOrganizerId());
        }

        if (true === $filterModel->isFavoriteOnly() && null !== $user) {
            $qb->andWhere($qb->expr()->isNotNull('favoriteEvent.id'));
        }

        if (null !== $filterModel->getType()) {
            $qb
                ->andWhere($qb->expr()->eq('event.type', ':type'))
                ->setParameter('type', $filterModel->getType());
        }

        return $qb;
    }

    public function getFullEvent(string $id)
    {
        $qb = $this->eventRepository->createQueryBuilder('event');
        $qb
            ->select('event', 'eventMember', 'members', 'requests', 'candidates', 'categories')
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
            ->leftJoin('event.categories', 'categories')
            ->setParameters([
                'newEventRequest' => EventRequest::STATUS_NEW,
            ]);

        return $qb->getQuery()->getResult();
    }

    public function getLocalListData(LocalListFilterModel $filters): array
    {
        $coordinates = array_map(static function ($coordinate) {
            return [$coordinate->getLatitude(), $coordinate->getLongitude()];
        }, $filters->getPoints());

        $qb = $this->eventRepository->createQueryBuilder('event');
        $qb
            ->select('event')
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
            ->setParameters([
                'newEventRequest' => EventRequest::STATUS_NEW,
            ]);

        if ([] !== $filters->getPoints()) {
            $qb
                ->innerJoin('event.location', 'location')
                ->where(
                    $qb->expr()->andX(
                        $qb->expr()->gte('location.latitude', ':minLat'),
                        $qb->expr()->lte('location.latitude', ':maxLat'),
                        $qb->expr()->gte('location.longitude', ':minLon'),
                        $qb->expr()->lte('location.longitude', ':maxLon'),
                    ),
                )
                ->setParameter('minLat', min(array_column($coordinates, 0)))
                ->setParameter('maxLat', max(array_column($coordinates, 0)))
                ->setParameter('minLon', min(array_column($coordinates, 1)))
                ->setParameter('maxLon', max(array_column($coordinates, 1)));
        }

        return $qb->getQuery()->getResult();
    }

    public function getQBListNew(ListFilterModel $filterModel, ?User $user): QueryBuilder
    {
        $qb = $this->eventRepository->createQueryBuilder('event');
        $qb
            ->innerJoin(
                EventMember::class,
                'eventMemberOrganizer',
                Join::WITH,
                $qb->expr()->andX(
                    'eventMemberOrganizer.isOrganizer = :true',
                    'eventMemberOrganizer.event = event',
                ),
            )
            ->innerJoin('eventMemberOrganizer.user', 'organizerUser')
            ->leftJoin('event.avatar', 'eventAvatar')
            ->leftJoin('organizerUser.avatar', 'organizerAvatar')
            ->setParameter('true', true);

        if (null !== $user) {
            $qb
                ->leftJoin(
                    FavoriteEvent::class,
                    'favoriteEvent',
                    Join::WITH,
                    $qb->expr()->andX(
                        'favoriteEvent.event = event',
                        'favoriteEvent.user = :user',
                    ),
                )
                ->setParameter('user', $user);

            if (true === $filterModel->isFavoriteOnly()) {
                $qb->andWhere($qb->expr()->isNotNull('favoriteEvent.id'));
            }
        }

        if (null !== $filterModel->getOrganizerId()) {
            $qb
                ->andWhere('organizerUser.id = :organizerId')
                ->setParameter('organizerId', $filterModel->getOrganizerId());
        }

        return $qb->distinct();
    }

    public function getNewListDataListFilterModel($filterModel, ?User $user): array
    {
        $qb = $this->getQBListNew($filterModel, $user);
        $qb
            ->select(
                'NEW '.EventResponseModel::class.'(
                                (event.id),
                                event.title,
                                event.date,
                                event.timeZone,
                                event.type,
                                event.participationTerms,
                                event.details,
                                event.countMembersMax,
                                event.categories
                            ) AS eventModel',
            )
            ->addSelect(
                'NEW '.UserPublicModel::class.'(
                                (organizerUser.id),
                                organizerUser.name,
                                organizerUser.info,
                                organizerUser.createdAt,
                                organizerUser.birthDate,
                                organizerUser.gender
                            ) as organizerModel',
            )
            ->addSelect(
                'NEW '.FileDTO::class.'(
                                (eventAvatar.id),
                                eventAvatar.externalId,
                                eventAvatar.extension
                        ) AS eventAvatarDTO',
            )
            ->addSelect(
                'NEW '.FileDTO::class.'(
                                (organizerAvatar.id),
                                organizerAvatar.externalId,
                                organizerAvatar.extension
                        ) AS organizerAvatarDTO',
            )
            ->addSelect('event.date AS HIDDEN date')
            ->addSelect('event.createdAt AS HIDDEN createdAt');

        if (null !== $user) {
            $qb->addSelect('CASE WHEN favoriteEvent.id IS NOT NULL THEN TRUE ELSE FALSE END AS isFavorite');
        }

        $qb
            ->orderBy($filterModel->getOrderBy(), $filterModel->getOrderDirection())
            ->setFirstResult(($filterModel->getPage() - 1) * $filterModel->getItemsPerPage())
            ->setMaxResults($filterModel->getItemsPerPage());

        return $qb->getQuery()->getResult();
    }

    public function getEventsListCount(ListFilterModel $filterModel, ?User $user): int
    {
        $qb = $this->getQBEventsList($filterModel, $user);

        return $qb
            ->select('COUNT(DISTINCT(event.id))')
            ->setMaxResults(1)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function getEventsListData(ListFilterModel $filterModel, ?User $user): array
    {
        $qb = $this->getQBEventsList($filterModel, $user);
        $qb
            ->select(
                'NEW '.EventListItemMode::class.'(
                                (event.id),
                                event.title,
                                event.date,
                                event.timeZone,
                                event.type,
                                event.participationTerms,
                                event.details,
                                event.countMembersMax,
                                event.categories
                            ) AS eventModel',
            )
            ->addSelect(
                'NEW '.FileDTO::class.'(
                                (eventAvatar.id),
                                eventAvatar.externalId,
                                eventAvatar.extension
                        ) AS eventAvatarDTO',
            )
            ->addSelect('location.id AS locationId')
            ->addSelect('location.latitude AS locationLatitude')
            ->addSelect('location.longitude AS locationLongitude')
            ->addSelect('location.city AS locationCity')
            ->addSelect('location.street AS locationStreet')
            ->addSelect('location.streetNumber AS locationStreetNumber')
            ->addSelect('location.placeName AS locationPlaceName')
            ->addSelect('organizerUser.id AS organizerId')
            ->addSelect('COUNT(eventMember) AS countMembers')
            ->addSelect('event.date AS HIDDEN date')
            ->addSelect('event.createdAt AS HIDDEN createdAt')
            ->leftJoin('event.members', 'eventMember')
            ->groupBy(
                'event.id',
                'eventAvatar.id',
                'organizerId',
                'location.id',
            )
            ->orderBy($filterModel->getOrderBy(), $filterModel->getOrderDirection())
            ->setFirstResult(($filterModel->getPage() - 1) * $filterModel->getItemsPerPage())
            ->setMaxResults($filterModel->getItemsPerPage());

        if (null !== $user) {
            $qb
                ->addSelect('CASE WHEN favoriteEvent.id IS NOT NULL THEN TRUE ELSE FALSE END AS isFavorite')
                ->addGroupBy('favoriteEvent.id');
        }

        return $qb->getQuery()->getResult();
    }

    private function getQBEventsList(ListFilterModel $filterModel, ?User $user): QueryBuilder
    {
        $qb = $this->eventRepository->createQueryBuilder('event');
        $qb
            ->innerJoin(
                EventMember::class,
                'eventMemberOrganizer',
                Join::WITH,
                $qb->expr()->andX(
                    'eventMemberOrganizer.isOrganizer = :true',
                    'eventMemberOrganizer.event = event',
                ),
            )
            ->innerJoin('eventMemberOrganizer.user', 'organizerUser')
            ->leftJoin('event.avatar', 'eventAvatar')
            // ->leftJoin('organizerUser.avatar', 'organizerAvatar')
            ->leftJoin('event.location', 'location')
            ->setParameter('true', true);

        if (null !== $user) {
            $qb
                ->leftJoin(
                    FavoriteEvent::class,
                    'favoriteEvent',
                    Join::WITH,
                    $qb->expr()->andX(
                        'favoriteEvent.event = event',
                        'favoriteEvent.user = :user',
                    ),
                )
                ->setParameter('user', $user);

            if (true === $filterModel->isFavoriteOnly()) {
                $qb->andWhere($qb->expr()->isNotNull('favoriteEvent.id'));
            }
        }

        if (null !== $filterModel->getOrganizerId()) {
            $qb
                ->andWhere('organizerUser.id = :organizerId')
                ->setParameter('organizerId', $filterModel->getOrganizerId());
        }

        return $qb->distinct();
    }
}
