<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240504212002 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE events ADD created_by_id UUID DEFAULT NULL');
        $this->addSql('ALTER TABLE events ADD updated_by_id UUID DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN events.created_by_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN events.updated_by_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE events ADD CONSTRAINT FK_5387574AB03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE events ADD CONSTRAINT FK_5387574A896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_5387574AB03A8386 ON events (created_by_id)');
        $this->addSql('CREATE INDEX IDX_5387574A896DBBDE ON events (updated_by_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE events DROP CONSTRAINT FK_5387574AB03A8386');
        $this->addSql('ALTER TABLE events DROP CONSTRAINT FK_5387574A896DBBDE');
        $this->addSql('DROP INDEX IDX_5387574AB03A8386');
        $this->addSql('DROP INDEX IDX_5387574A896DBBDE');
        $this->addSql('ALTER TABLE events DROP created_by_id');
        $this->addSql('ALTER TABLE events DROP updated_by_id');
    }
}
