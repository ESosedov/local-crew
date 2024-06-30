<?php

namespace App\Validator\EventCategory;

use App\Repository\CategoryRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class EventCategoryConstraintValidator extends ConstraintValidator
{
    public function __construct(private CategoryRepository $categoryRepository)
    {
    }

    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof EventCategoryConstraint) {
            throw new UnexpectedTypeException($constraint, EventCategoryConstraint::class);
        }

        if ([] === $value) {
            return;
        }

        $categoryIds = $this->categoryRepository->getAllIds();
        $invalidCategory = array_diff($value, $categoryIds);
        if ([] !== $invalidCategory) {
            $this->context
                ->buildViolation('Invalid event category.')
                ->setInvalidValue($invalidCategory)
                ->addViolation();
        }
    }
}
