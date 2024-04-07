<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240407131911 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE event_requests (id UUID NOT NULL, event_id UUID DEFAULT NULL, created_by_id UUID DEFAULT NULL, updated_by_id UUID DEFAULT NULL, status VARCHAR(50) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3D693F8171F7E88B ON event_requests (event_id)');
        $this->addSql('CREATE INDEX IDX_3D693F81B03A8386 ON event_requests (created_by_id)');
        $this->addSql('CREATE INDEX IDX_3D693F81896DBBDE ON event_requests (updated_by_id)');
        $this->addSql('COMMENT ON COLUMN event_requests.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN event_requests.event_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN event_requests.created_by_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN event_requests.updated_by_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN event_requests.status IS \'Статус запроса\'');
        $this->addSql('CREATE TABLE push_tokens (id UUID NOT NULL, user_id UUID DEFAULT NULL, token VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_81E0C0AEA76ED395 ON push_tokens (user_id)');
        $this->addSql('COMMENT ON COLUMN push_tokens.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN push_tokens.user_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE event_requests ADD CONSTRAINT FK_3D693F8171F7E88B FOREIGN KEY (event_id) REFERENCES events (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event_requests ADD CONSTRAINT FK_3D693F81B03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event_requests ADD CONSTRAINT FK_3D693F81896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE push_tokens ADD CONSTRAINT FK_81E0C0AEA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE event_requests DROP CONSTRAINT FK_3D693F8171F7E88B');
        $this->addSql('ALTER TABLE event_requests DROP CONSTRAINT FK_3D693F81B03A8386');
        $this->addSql('ALTER TABLE event_requests DROP CONSTRAINT FK_3D693F81896DBBDE');
        $this->addSql('ALTER TABLE push_tokens DROP CONSTRAINT FK_81E0C0AEA76ED395');
        $this->addSql('DROP TABLE event_requests');
        $this->addSql('DROP TABLE push_tokens');
    }
}
