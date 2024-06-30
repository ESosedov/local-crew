<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240519143245 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE event_members ADD CONSTRAINT event_member_user UNIQUE (event_id, user_id)');
        $this->addSql('ALTER TABLE event_requests ADD CONSTRAINT event_request_user UNIQUE (event_id, created_by_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE event_members DROP CONSTRAINT event_member_user');
        $this->addSql('ALTER TABLE event_members DROP CONSTRAINT event_request_user');
    }
}
