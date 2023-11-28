<?php

namespace App\Service\User;

use App\Entity\User;
use App\Exception\User\UserAlreadyExistsException;
use App\Model\User\IdResponse;
use App\Model\User\SignUpModel;
use App\Repository\UserRepository;
use App\Service\City\CityService;
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
        private CityService $cityService,
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
            ->setAge($signUpModel->getAge())
            ->setGender($signUpModel->getGender())
            ->setInfo($signUpModel->getAbout());

        $user->setPassword($this->userPasswordHasher->hashPassword($user, $signUpModel->getPassword()));
        $city = $this->cityService->getCity($signUpModel->getCity());
        $user->setCity($city);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $this->successHandler->handleAuthenticationSuccess($user);
    }
}
