<?php

namespace App\Command;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class AddCategoryCommand extends Command
{
    protected static $defaultName = 'once:add-event-category';
    protected static $defaultDescription = 'Add category';
    public function __construct(private EntityManagerInterface $entityManager)
    {
        parent::__construct();
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $categoriesTitle = ['Отдых без Данила'];
        $io = new SymfonyStyle($input, $output);

        foreach ($categoriesTitle as $title) {
            $category = new Category();
            $category->setTitle($title);

            $this->entityManager->persist($category);
        }

        $this->entityManager->flush();

        $io->success('Finished');

        return Command::SUCCESS;
    }
}