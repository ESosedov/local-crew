<?php

namespace App\Model\Event;

use App\Entity\Event;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

class ListFilterModel
{
    public const SORTING_OPTIONS = [
        'date',
        'createdAt',
    ];

    public function __construct(
        private bool $isFavoriteOnly = false,
        #[Assert\Choice([Event::TYPE_LOCAL, Event::TYPE_ONLINE])]
        private string|null $type = null,
        private string|null $organizerId = null,
        #[Assert\Choice(self::SORTING_OPTIONS)]
        private string $orderBy = 'createdAt',
        #[Assert\Choice([Criteria::ASC, Criteria::DESC])]
        private string $orderDirection = Criteria::DESC,
        #[Assert\GreaterThanOrEqual(1)]
        private int $itemsPerPage = 20,
        #[Assert\GreaterThanOrEqual(1)]
        private int $page = 1,
    ) {
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    #[SerializedName('isFavoriteOnly')]
    public function isFavoriteOnly(): bool
    {
        return $this->isFavoriteOnly;
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
