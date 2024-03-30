<?php

namespace App\Model\Event;

use Doctrine\Common\Collections\Criteria;
use Symfony\Component\Validator\Constraints as Assert;

class ListFilterModel
{
    public const SORTING_OPTIONS = [
        'date',
    ];

    public function __construct(
        private string|null $organizerId = null,
        #[Assert\Choice(self::SORTING_OPTIONS)]
        private string $orderBy = 'date',
        #[Assert\Choice([Criteria::ASC, Criteria::DESC])]
        private string $orderDirection = Criteria::ASC,
        #[Assert\GreaterThanOrEqual(1)]
        private int $itemsPerPage = 20,
        #[Assert\GreaterThanOrEqual(1)]
        private int $page = 1,
    ) {
    }

    public function getOrganizerId(): ?string
    {
        return $this->organizerId;
    }

    public function getOrderBy(): string
    {
        return $this->orderBy;
    }

    public function getOrderDirection(): string
    {
        return $this->orderDirection;
    }

    public function getItemsPerPage(): int
    {
        return $this->itemsPerPage;
    }

    public function getPage(): int
    {
        return $this->page;
    }
}
