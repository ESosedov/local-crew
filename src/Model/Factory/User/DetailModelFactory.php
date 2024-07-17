<?php

namespace App\Model\Factory\User;

use App\Entity\User;
use App\Model\City\CityModel;
use App\Model\File\Factory\FileModelFactory;
use App\Model\User\DetailModel;
use App\Repository\CityRepository;

class DetailModelFactory
{
    public function __construct(
        private CityRepository $cityRepository,
        private FileModelFactory $fileModelFactory,
    ) {
    }

    public function fromUser(User $user): DetailModel
    {
        // TODO:: make query
        $city = $this->cityRepository->findOneBy(['id' => $user->getCity()]);
        $cityModel = new CityModel(
            $city->getName(),
            $city->getLongitude(),
            $city->getLatitude(),
        );
        $avatar = $this->fileModelFactory->fromFile($user->getAvatar());

        return new DetailModel(
            $user->getId(),
            $user->getName(),
            $avatar,
            $user->getInfo(),
            $user->getCreatedAt(),
            $user->getEmail(),
            $user->getBirthDate(),
            $user->getGender(),
            $cityModel,
            [],
        );
    }
}
