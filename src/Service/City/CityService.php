<?php

namespace App\Service\City;

use App\Entity\City;
use App\Model\City\CityModel;
use App\Repository\CityRepository;
use Doctrine\ORM\EntityManagerInterface;

class CityService
{
    public function __construct(
        private CityRepository $cityRepository,
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function getCity(
        CityModel $cityModel
    ): City {
        $city = $this->cityRepository->findOneByNameCoordinates(
            $cityModel->getName(),
            $cityModel->getLongitude(),
            $cityModel->getLatitude(),
        );

        if (null === $city) {
            $city = new City();
            $city
                ->setName($cityModel->getName())
                ->setLatitude($cityModel->getLatitude())
                ->setLongitude($cityModel->getLongitude());

            $this->entityManager->persist($city);
            $this->entityManager->flush();
        }

        return $city;
    }
}
