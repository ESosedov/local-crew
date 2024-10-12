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
        return $this->categoryRepository->getAllTitlesById();
    }
}
