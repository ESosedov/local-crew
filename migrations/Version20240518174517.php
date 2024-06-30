<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240518174517 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE event_members ALTER event_id SET NOT NULL');
        $this->addSql('ALTER TABLE event_requests ALTER event_id SET NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE event_requests ALTER event_id DROP NOT NULL');
        $this->addSql('ALTER TABLE event_members ALTER event_id DROP NOT NULL');
    }
}
