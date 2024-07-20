<?php

namespace App\Model\Event;

use App\Model\Location\CoordinateModel;
use Symfony\Component\Validator\Constraints as Assert;

class LocalListFilterModel
{
    public function __construct(
        #[Assert\Count(exactly: 4)]
        #[Assert\NotBlank()]
        /** @var array<CoordinateModel> $points */
        private array $points = [],
    ) {
    }

    public function getPoints(): array
    {
        return $this->points;
    }
}
