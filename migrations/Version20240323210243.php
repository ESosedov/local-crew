<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240323210243 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE event_members RENAME COLUMN is_author TO is_organizer');
        $this->addSql('ALTER TABLE events ADD city_id UUID DEFAULT NULL');
        $this->addSql('ALTER TABLE events ADD avatar_id UUID DEFAULT NULL');
        $this->addSql('ALTER TABLE events ADD type VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE events DROP meeting_status');
        $this->addSql('ALTER TABLE events DROP city');
        $this->addSql('COMMENT ON COLUMN events.city_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN events.avatar_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN events.type IS \'type of event\'');
        $this->addSql('ALTER TABLE events ADD CONSTRAINT FK_5387574A8BAC62AF FOREIGN KEY (city_id) REFERENCES cities (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE events ADD CONSTRAINT FK_5387574A86383B10 FOREIGN KEY (avatar_id) REFERENCES files (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_5387574A8BAC62AF ON events (city_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5387574A86383B10 ON events (avatar_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE events DROP CONSTRAINT FK_5387574A8BAC62AF');
        $this->addSql('ALTER TABLE events DROP CONSTRAINT FK_5387574A86383B10');
        $this->addSql('DROP INDEX IDX_5387574A8BAC62AF');
        $this->addSql('DROP INDEX UNIQ_5387574A86383B10');
        $this->addSql('ALTER TABLE events ADD meeting_status VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE events ADD city VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE events DROP city_id');
        $this->addSql('ALTER TABLE events DROP avatar_id');
        $this->addSql('ALTER TABLE events DROP type');
        $this->addSql('COMMENT ON COLUMN events.meeting_status IS \'Статус\'');
        $this->addSql('ALTER TABLE event_members RENAME COLUMN is_organizer TO is_author');
    }
}
