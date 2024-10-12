<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240716195420 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE refresh_tokens_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE categories (id UUID NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN categories.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN categories.title IS \'Category`s title\'');
        $this->addSql('CREATE TABLE cities (id UUID NOT NULL, name VARCHAR(255) NOT NULL, longitude DOUBLE PRECISION DEFAULT NULL, latitude DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN cities.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN cities.name IS \'City name\'');
        $this->addSql('COMMENT ON COLUMN cities.longitude IS \'City longitude\'');
        $this->addSql('COMMENT ON COLUMN cities.latitude IS \'City latitude\'');
        $this->addSql('CREATE TABLE event_members (id UUID NOT NULL, event_id UUID NOT NULL, user_id UUID DEFAULT NULL, is_organizer BOOLEAN NOT NULL, is_approved BOOLEAN DEFAULT NULL, is_member BOOLEAN DEFAULT NULL, is_favorite BOOLEAN DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C0F77B5071F7E88B ON event_members (event_id)');
        $this->addSql('CREATE INDEX IDX_C0F77B50A76ED395 ON event_members (user_id)');
        $this->addSql('COMMENT ON COLUMN event_members.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN event_members.event_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN event_members.user_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE event_requests (id UUID NOT NULL, event_id UUID NOT NULL, created_by_id UUID DEFAULT NULL, updated_by_id UUID DEFAULT NULL, status VARCHAR(50) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3D693F8171F7E88B ON event_requests (event_id)');
        $this->addSql('CREATE INDEX IDX_3D693F81B03A8386 ON event_requests (created_by_id)');
        $this->addSql('CREATE INDEX IDX_3D693F81896DBBDE ON event_requests (updated_by_id)');
        $this->addSql('COMMENT ON COLUMN event_requests.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN event_requests.event_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN event_requests.created_by_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN event_requests.updated_by_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN event_requests.status IS \'Статус запроса\'');
        $this->addSql('CREATE TABLE events (id UUID NOT NULL, location_id UUID DEFAULT NULL, avatar_id UUID DEFAULT NULL, created_by_id UUID DEFAULT NULL, updated_by_id UUID DEFAULT NULL, title VARCHAR(255) NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, participation_terms VARCHAR(1024) DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, details VARCHAR(1024) DEFAULT NULL, count_members_max INT DEFAULT NULL, time_zone VARCHAR(55) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5387574A64D218E ON events (location_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5387574A86383B10 ON events (avatar_id)');
        $this->addSql('CREATE INDEX IDX_5387574AB03A8386 ON events (created_by_id)');
        $this->addSql('CREATE INDEX IDX_5387574A896DBBDE ON events (updated_by_id)');
        $this->addSql('CREATE INDEX date_idx ON events (date)');
        $this->addSql('CREATE INDEX created_at_idx ON events (created_at)');
        $this->addSql('COMMENT ON COLUMN events.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN events.location_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN events.avatar_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN events.created_by_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN events.updated_by_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN events.title IS \'Event`s title\'');
        $this->addSql('COMMENT ON COLUMN events.date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN events.participation_terms IS \'Условия участия\'');
        $this->addSql('COMMENT ON COLUMN events.type IS \'type of event\'');
        $this->addSql('COMMENT ON COLUMN events.details IS \'Детали\'');
        $this->addSql('CREATE TABLE category_evens (category_id UUID NOT NULL, event_id UUID NOT NULL, PRIMARY KEY(category_id, event_id))');
        $this->addSql('CREATE INDEX IDX_4DF9D04D12469DE2 ON category_evens (category_id)');
        $this->addSql('CREATE INDEX IDX_4DF9D04D71F7E88B ON category_evens (event_id)');
        $this->addSql('COMMENT ON COLUMN category_evens.category_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN category_evens.event_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE files (id UUID NOT NULL, external_id VARCHAR(255) NOT NULL, url VARCHAR(512) NOT NULL, extension VARCHAR(50) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN files.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN files.external_id IS \'Cloud id\'');
        $this->addSql('COMMENT ON COLUMN files.url IS \'url\'');
        $this->addSql('CREATE TABLE locations (id UUID NOT NULL, longitude DOUBLE PRECISION NOT NULL, latitude DOUBLE PRECISION NOT NULL, city VARCHAR(100) NOT NULL, street VARCHAR(100) NOT NULL, street_number VARCHAR(50) NOT NULL, place_name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN locations.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE push_tokens (id UUID NOT NULL, user_id UUID DEFAULT NULL, token VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_81E0C0AEA76ED395 ON push_tokens (user_id)');
        $this->addSql('COMMENT ON COLUMN push_tokens.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN push_tokens.user_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE refresh_tokens (id INT NOT NULL, refresh_token VARCHAR(128) NOT NULL, username VARCHAR(255) NOT NULL, valid TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9BACE7E1C74F2195 ON refresh_tokens (refresh_token)');
        $this->addSql('CREATE TABLE sent_messages (id UUID NOT NULL, user_id UUID DEFAULT NULL, event_id UUID DEFAULT NULL, created_by_id UUID DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, type VARCHAR(50) NOT NULL, source VARCHAR(255) DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, message TEXT DEFAULT NULL, identifier VARCHAR(255) DEFAULT NULL, noticed_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, body_text TEXT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_56709A54A76ED395 ON sent_messages (user_id)');
        $this->addSql('CREATE INDEX IDX_56709A5471F7E88B ON sent_messages (event_id)');
        $this->addSql('CREATE INDEX IDX_56709A54B03A8386 ON sent_messages (created_by_id)');
        $this->addSql('COMMENT ON COLUMN sent_messages.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN sent_messages.user_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN sent_messages.event_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN sent_messages.created_by_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE users (id UUID NOT NULL, city_id UUID DEFAULT NULL, avatar_id UUID DEFAULT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(255) DEFAULT NULL, birth_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, gender VARCHAR(255) DEFAULT NULL, info VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9E7927C74 ON users (email)');
        $this->addSql('CREATE INDEX IDX_1483A5E98BAC62AF ON users (city_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E986383B10 ON users (avatar_id)');
        $this->addSql('COMMENT ON COLUMN users.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN users.city_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN users.avatar_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN users.email IS \'User`s login\'');
        $this->addSql('COMMENT ON COLUMN users.password IS \'User`s password\'');
        $this->addSql('COMMENT ON COLUMN users.name IS \'User`s name\'');
        $this->addSql('COMMENT ON COLUMN users.birth_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN users.gender IS \'User`s gender\'');
        $this->addSql('COMMENT ON COLUMN users.info IS \'User`s info\'');
        $this->addSql('ALTER TABLE event_members ADD CONSTRAINT FK_C0F77B5071F7E88B FOREIGN KEY (event_id) REFERENCES events (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event_members ADD CONSTRAINT FK_C0F77B50A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event_requests ADD CONSTRAINT FK_3D693F8171F7E88B FOREIGN KEY (event_id) REFERENCES events (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event_requests ADD CONSTRAINT FK_3D693F81B03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event_requests ADD CONSTRAINT FK_3D693F81896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE events ADD CONSTRAINT FK_5387574A64D218E FOREIGN KEY (location_id) REFERENCES locations (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE events ADD CONSTRAINT FK_5387574A86383B10 FOREIGN KEY (avatar_id) REFERENCES files (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE events ADD CONSTRAINT FK_5387574AB03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE events ADD CONSTRAINT FK_5387574A896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE category_evens ADD CONSTRAINT FK_4DF9D04D12469DE2 FOREIGN KEY (category_id) REFERENCES events (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE category_evens ADD CONSTRAINT FK_4DF9D04D71F7E88B FOREIGN KEY (event_id) REFERENCES categories (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE push_tokens ADD CONSTRAINT FK_81E0C0AEA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sent_messages ADD CONSTRAINT FK_56709A54A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sent_messages ADD CONSTRAINT FK_56709A5471F7E88B FOREIGN KEY (event_id) REFERENCES events (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sent_messages ADD CONSTRAINT FK_56709A54B03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E98BAC62AF FOREIGN KEY (city_id) REFERENCES cities (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E986383B10 FOREIGN KEY (avatar_id) REFERENCES files (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA xata');
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE refresh_tokens_id_seq CASCADE');
        $this->addSql('ALTER TABLE event_members DROP CONSTRAINT FK_C0F77B5071F7E88B');
        $this->addSql('ALTER TABLE event_members DROP CONSTRAINT FK_C0F77B50A76ED395');
        $this->addSql('ALTER TABLE event_requests DROP CONSTRAINT FK_3D693F8171F7E88B');
        $this->addSql('ALTER TABLE event_requests DROP CONSTRAINT FK_3D693F81B03A8386');
        $this->addSql('ALTER TABLE event_requests DROP CONSTRAINT FK_3D693F81896DBBDE');
        $this->addSql('ALTER TABLE events DROP CONSTRAINT FK_5387574A64D218E');
        $this->addSql('ALTER TABLE events DROP CONSTRAINT FK_5387574A86383B10');
        $this->addSql('ALTER TABLE events DROP CONSTRAINT FK_5387574AB03A8386');
        $this->addSql('ALTER TABLE events DROP CONSTRAINT FK_5387574A896DBBDE');
        $this->addSql('ALTER TABLE category_evens DROP CONSTRAINT FK_4DF9D04D12469DE2');
        $this->addSql('ALTER TABLE category_evens DROP CONSTRAINT FK_4DF9D04D71F7E88B');
        $this->addSql('ALTER TABLE push_tokens DROP CONSTRAINT FK_81E0C0AEA76ED395');
        $this->addSql('ALTER TABLE sent_messages DROP CONSTRAINT FK_56709A54A76ED395');
        $this->addSql('ALTER TABLE sent_messages DROP CONSTRAINT FK_56709A5471F7E88B');
        $this->addSql('ALTER TABLE sent_messages DROP CONSTRAINT FK_56709A54B03A8386');
        $this->addSql('ALTER TABLE users DROP CONSTRAINT FK_1483A5E98BAC62AF');
        $this->addSql('ALTER TABLE users DROP CONSTRAINT FK_1483A5E986383B10');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE cities');
        $this->addSql('DROP TABLE event_members');
        $this->addSql('DROP TABLE event_requests');
        $this->addSql('DROP TABLE events');
        $this->addSql('DROP TABLE category_evens');
        $this->addSql('DROP TABLE files');
        $this->addSql('DROP TABLE locations');
        $this->addSql('DROP TABLE push_tokens');
        $this->addSql('DROP TABLE refresh_tokens');
        $this->addSql('DROP TABLE sent_messages');
        $this->addSql('DROP TABLE users');
    }
}
