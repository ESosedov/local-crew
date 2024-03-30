<?php

namespace App\Service\Dictionaries;

use App\Repository\CategoryRepository;

class DictionariesService
{
    public function __construct(
        private CategoryRepository $categoryRepository,
    ) {
    }

    public function getList(): array
    {
        return [
        'eventCategories' => $this->getEventCategories(),
        ];
    }

    private function getEventCategories(): array
    {
        $qb = $this->categoryRepository->createQueryBuilder('eventCategory');
        $qb
            ->select('CAST(eventCategory.id AS string) AS id')
            ->addSelect('eventCategory.title AS title');

        $result = $qb->getQuery()->getArrayResult();

        return array_column($result, 'title', 'id');
    }
}
