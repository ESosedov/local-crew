<?php

namespace App\Model\Event\Factory;

use App\Entity\User;
use App\Model\Event\EventListItemMode;
use App\Model\File\Factory\FileModelFactory;
use App\Model\Location\LocationModel;

class EventListItemModelFactory
{
    public function __construct(
        private FileModelFactory $fileModelFactory,
    ) {
    }

    /**
     * @return array<EventListItemMode>
     */
    public function fromEventListData(array $data, ?User $currentUser): array
    {
        $result = [];
        foreach ($data as $row) {
            /** @var EventListItemMode $eventModel */
            $eventModel = $row['eventModel'];

            $isFavorite = false;
            if (true === array_key_exists('isFavorite', $row)) {
                $isFavorite = $row['isFavorite'];
            }
            $eventModel->setIsFavorite($isFavorite);

            $eventAvatar = null;
            if (array_key_exists('eventAvatarDTO', $row)) {
                $eventAvatar = $this->fileModelFactory->fromFileDTO($row['eventAvatarDTO']);
            }

            $locationModel = null;
            if (true === array_key_exists('locationId', $row) && null !== $row['locationId']) {
                $locationModel = new LocationModel(
                    $row['locationLatitude'],
                    $row['locationLongitude'],
                    $row['locationCity'],
                    $row['locationStreet'],
                    $row['locationStreetNumber'],
                    $row['locationPlaceName'],
                );
            }

            $countMembers = null;
            if (true === array_key_exists('countMembers', $row)) {
                $countMembers = $row['countMembers'];
            }

            $organizerId = null;
            if (array_key_exists('organizerId', $row)) {
                $organizerId = $row['organizerId'];
            }

            // frontend options
            $frontendOptions = [
                'isEventReadyToStart' => $countMembers === $eventModel->getCountMembersMax(),
                'isActiveUserEvent' => $organizerId === $currentUser?->getId(),
            ];

            $eventModel
                ->setAvatar($eventAvatar)
                ->setLocation($locationModel)
                ->setCountMembers($countMembers)
                ->setCategory([])
                ->setFrontendOptions($frontendOptions);

            $result[] = $eventModel;
        }

        return $result;
    }
}
