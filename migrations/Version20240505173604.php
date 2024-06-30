<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240505173604 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event_members ALTER is_approved DROP NOT NULL');
        $this->addSql('ALTER TABLE event_members ALTER is_member DROP NOT NULL');
        $this->addSql('ALTER TABLE event_members ALTER is_favorite DROP NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE event_members ALTER is_approved SET NOT NULL');
        $this->addSql('ALTER TABLE event_members ALTER is_member SET NOT NULL');
        $this->addSql('ALTER TABLE event_members ALTER is_favorite SET NOT NULL');
    }
}
