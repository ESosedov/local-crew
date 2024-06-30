<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240518184018 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE INDEX date_idx ON events (date)');
        $this->addSql('CREATE INDEX created_at_idx ON events (created_at)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP INDEX date_idx');
        $this->addSql('DROP INDEX created_at_idx');
    }
}
