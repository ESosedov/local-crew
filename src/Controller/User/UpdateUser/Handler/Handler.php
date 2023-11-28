<?php

namespace App\Controller\User\UpdateUser\Handler;

use App\Entity\User;
use App\Model\Factory\User\DetailModelFactory;
use App\Model\User\DetailModel;
use App\Model\User\UpdateModel;
use App\Repository\CityRepository;
use App\Service\City\CityService;
use Doctrine\ORM\EntityManagerInterface;

class Handler
{
    public function __construct(
        private DetailModelFactory $factory,
        private EntityManagerInterface $entityManager,
        private CityService $cityService,
    ) {
    }

    public function handle(User $user, UpdateModel $updateModel): DetailModel
    {
        $user
            ->setName($updateModel->getName())
            ->setInfo($updateModel->getAbout())
            ->setAge($updateModel->getAge())
            ->setGender($updateModel->getGender());

        $city = $this->cityService->getCity($updateModel->getCity());
        $user->setCity($city);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $this->factory->fromUser($user);
    }

}
