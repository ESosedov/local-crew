<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240414025552 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sent_messages (id UUID NOT NULL, user_id UUID DEFAULT NULL, event_id UUID DEFAULT NULL, created_by_id UUID DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, type VARCHAR(50) NOT NULL, source VARCHAR(255) DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, message TEXT DEFAULT NULL, identifier VARCHAR(255) DEFAULT NULL, noticed_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_56709A54A76ED395 ON sent_messages (user_id)');
        $this->addSql('CREATE INDEX IDX_56709A5471F7E88B ON sent_messages (event_id)');
        $this->addSql('CREATE INDEX IDX_56709A54B03A8386 ON sent_messages (created_by_id)');
        $this->addSql('COMMENT ON COLUMN sent_messages.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN sent_messages.user_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN sent_messages.event_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN sent_messages.created_by_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE sent_messages ADD CONSTRAINT FK_56709A54A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sent_messages ADD CONSTRAINT FK_56709A5471F7E88B FOREIGN KEY (event_id) REFERENCES events (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sent_messages ADD CONSTRAINT FK_56709A54B03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE sent_messages DROP CONSTRAINT FK_56709A54A76ED395');
        $this->addSql('ALTER TABLE sent_messages DROP CONSTRAINT FK_56709A5471F7E88B');
        $this->addSql('ALTER TABLE sent_messages DROP CONSTRAINT FK_56709A54B03A8386');
        $this->addSql('DROP TABLE sent_messages');
    }
}
