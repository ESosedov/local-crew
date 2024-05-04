<?php

namespace App\Validator\Entity;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class EntityConstraintValidator extends ConstraintValidator
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * @param string|int|null $value
     * @param EntityConstraint|Constraint $constraint
     */
    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof EntityConstraint) {
            throw new UnexpectedTypeException($constraint, EntityConstraint::class);
        }

        if (null === $value) {
            return;
        }

        $entity = $this->entityManager->find($constraint->dataClass, $value);
        if (null === $entity) {
            $this->context
                ->buildViolation($constraint->message)
                ->setInvalidValue($value)
                ->addViolation();

            return;
        }
    }
}
