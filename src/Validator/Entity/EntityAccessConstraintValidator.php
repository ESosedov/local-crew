<?php

namespace App\Validator\Entity;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class EntityAccessConstraintValidator extends ConstraintValidator
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private AuthorizationCheckerInterface $authorizationChecker,
    ) {
    }

    /**
     * @param string|int|null $value
     * @param EntityAccessConstraint $constraint
     */
    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof EntityAccessConstraint) {
            throw new UnexpectedTypeException($constraint, EntityAccessConstraint::class);
        }

        if (null === $value) {
            return;
        }

        if (false === is_string($value)) {
            throw new UnexpectedTypeException($value, 'string');
        }

        $repository = $this->entityManager->getRepository($constraint->dataClass);
        try {
            $entity = $repository->{$constraint->repositoryMethod}($value);
        } catch (\BadMethodCallException) {
            throw new ConstraintDefinitionException('Wrong repository method');
        }
        if (null === $entity) {
            $this->context
                ->buildViolation($constraint->message)
                ->setInvalidValue($value)
                ->addViolation();

            return;
        }

        $allowAccess = $this->authorizationChecker->isGranted($constraint->permission, $entity);
        if (false === $allowAccess) {
            $this->context
                ->buildViolation($constraint->accessErrorMessage)
                ->setInvalidValue($value)
                ->atPath($this->context->getPropertyName() ?? '')
                ->addViolation();

            return;
        }
    }
}
