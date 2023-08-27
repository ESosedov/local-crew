<?php

namespace App\Service\User;

use App\Entity\User;
use App\Exception\User\UserAlreadyExistsException;
use App\Model\User\IdResponse;
use App\Model\User\SignUpModel;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Authentication\AuthenticationSuccessHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SignUpService
{
    public function __construct(
        private UserRepository $userRepository,
        private UserPasswordHasherInterface $userPasswordHasher,
        private EntityManagerInterface $entityManager,
        private AuthenticationSuccessHandler $successHandler,
    ) {
    }

    public function signUp(SignUpModel $signUpModel): Response
    {
        if (null !== $this->userRepository->getByEmail($signUpModel->getEmail())) {
            throw new UserAlreadyExistsException();
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

        return $this->successHandler->handleAuthenticationSuccess($user);
    }
}
