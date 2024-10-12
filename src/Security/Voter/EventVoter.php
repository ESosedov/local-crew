<?php

namespace App\Security\Voter;

use App\Entity\Event;
use App\Entity\User;
use App\Repository\EventMemberRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class EventVoter extends Voter
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private EventMemberRepository $eventMemberRepository,
    ) {
    }

    public const PERMISSION_ORGANIZER = 'organizer';

    protected function supports(string $attribute, $subject): bool
    {
        if (!$subject instanceof Event) {
            return false;
        }

        if (!in_array($attribute, [self::PERMISSION_ORGANIZER], true)) {
            return false;
        }

        return true;
    }

    /**
     * @throws NonUniqueResultException
     */
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        if (!$token->getUser()) {
            return false;
        }

        $user = $token->getUser();
        if (!$user instanceof User) {
            return false;
        }
        if (!$subject instanceof Event) {
            $subject = $this->entityManager->find(Event::class, $subject);
        }

        if (self::PERMISSION_ORGANIZER === $attribute) {
            $organizer = $this->eventMemberRepository->getOrganizer($subject);
            if ($user === $organizer->getUser()) {
                return true;
            }
        }

        return false;
    }
}
