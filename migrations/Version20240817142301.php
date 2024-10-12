<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240817142301 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE favorite_events (id UUID NOT NULL, event_id UUID NOT NULL, user_id UUID NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6F323BB071F7E88B ON favorite_events (event_id)');
        $this->addSql('CREATE INDEX IDX_6F323BB0A76ED395 ON favorite_events (user_id)');
        $this->addSql('COMMENT ON COLUMN favorite_events.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN favorite_events.event_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN favorite_events.user_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE favorite_events ADD CONSTRAINT FK_6F323BB071F7E88B FOREIGN KEY (event_id) REFERENCES events (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE favorite_events ADD CONSTRAINT FK_6F323BB0A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE favorite_events DROP CONSTRAINT FK_6F323BB071F7E88B');
        $this->addSql('ALTER TABLE favorite_events DROP CONSTRAINT FK_6F323BB0A76ED395');
        $this->addSql('DROP TABLE favorite_events');
    }
}
