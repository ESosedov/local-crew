<?php

namespace App\Service\User;

use App\Entity\User;
use App\Model\User\SignUpModel;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SignUpService
{
    public function __construct(
        private UserRepository $userRepository,
        private UserPasswordHasherInterface $userPasswordHasher,
        private EntityManagerInterface $entityManager,
    )
    {
    }

    public function signUp(SignUpModel $signUpModel)
    {
        if (null !== $this->userRepository->getByEmail($signUpModel->getEmail())) {
            throw new \Exception('User with this Email already exists.');
        }

        $user = new User();
        $user
            ->setEmail($signUpModel->getEmail())
            ->setName($signUpModel->getName())
            ->setCity($signUpModel->getCity())
            ->setAge($signUpModel->getAge())
            ->setGender($signUpModel->getGender())
            ->setInfo($signUpModel->getInfo());

        $user->setPassword($this->userPasswordHasher->hashPassword($user, $signUpModel->getPassword()));

        $this->entityManager->persist($user);
        $this->entityManager->flush();


        ;

    }

}