<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230806165307 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE event_members (id UUID NOT NULL, event_id UUID DEFAULT NULL, user_id UUID DEFAULT NULL, is_author BOOLEAN NOT NULL, is_approved BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C0F77B5071F7E88B ON event_members (event_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C0F77B50A76ED395 ON event_members (user_id)');
        $this->addSql('COMMENT ON COLUMN event_members.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN event_members.event_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN event_members.user_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE events (id UUID NOT NULL, title VARCHAR(255) NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, participation_terms VARCHAR(1024) DEFAULT NULL, meeting_status VARCHAR(255) DEFAULT NULL, details VARCHAR(1024) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, street VARCHAR(255) DEFAULT NULL, street_number INT DEFAULT NULL, place_title VARCHAR(255) DEFAULT NULL, latitude DOUBLE PRECISION DEFAULT NULL, longitude DOUBLE PRECISION DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN events.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN events.title IS \'Event`s title\'');
        $this->addSql('COMMENT ON COLUMN events.date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN events.participation_terms IS \'Условия участия\'');
        $this->addSql('COMMENT ON COLUMN events.meeting_status IS \'Статус\'');
        $this->addSql('COMMENT ON COLUMN events.details IS \'Детали\'');
        $this->addSql('CREATE TABLE ext_translations (id SERIAL NOT NULL, locale VARCHAR(8) NOT NULL, object_class VARCHAR(191) NOT NULL, field VARCHAR(32) NOT NULL, foreign_key VARCHAR(64) NOT NULL, content TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX translations_lookup_idx ON ext_translations (locale, object_class, foreign_key)');
        $this->addSql('CREATE INDEX general_translations_lookup_idx ON ext_translations (object_class, foreign_key)');
        $this->addSql('CREATE UNIQUE INDEX lookup_unique_idx ON ext_translations (locale, object_class, field, foreign_key)');
        $this->addSql('CREATE TABLE users (id UUID NOT NULL, login VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, city VARCHAR(255) DEFAULT NULL, age INT DEFAULT NULL, gender VARCHAR(255) DEFAULT NULL, info VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN users.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN users.login IS \'User`s login\'');
        $this->addSql('COMMENT ON COLUMN users.password IS \'User`s password\'');
        $this->addSql('COMMENT ON COLUMN users.name IS \'User`s name\'');
        $this->addSql('COMMENT ON COLUMN users.city IS \'User`s city\'');
        $this->addSql('COMMENT ON COLUMN users.age IS \'User`s age\'');
        $this->addSql('COMMENT ON COLUMN users.gender IS \'User`s gender\'');
        $this->addSql('COMMENT ON COLUMN users.info IS \'User`s info\'');
        $this->addSql('ALTER TABLE event_members ADD CONSTRAINT FK_C0F77B5071F7E88B FOREIGN KEY (event_id) REFERENCES events (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event_members ADD CONSTRAINT FK_C0F77B50A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE event_members DROP CONSTRAINT FK_C0F77B5071F7E88B');
        $this->addSql('ALTER TABLE event_members DROP CONSTRAINT FK_C0F77B50A76ED395');
        $this->addSql('DROP TABLE event_members');
        $this->addSql('DROP TABLE events');
        $this->addSql('DROP TABLE ext_translations');
        $this->addSql('DROP TABLE users');
    }
}
