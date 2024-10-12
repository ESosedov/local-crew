<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241012123830 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE category_evens DROP CONSTRAINT fk_4df9d04d12469de2');
        $this->addSql('ALTER TABLE category_evens DROP CONSTRAINT fk_4df9d04d71f7e88b');
        $this->addSql('DROP TABLE category_evens');
        $this->addSql('ALTER TABLE events ADD categories JSONB DEFAULT \'{}\' NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE TABLE category_evens (category_id UUID NOT NULL, event_id UUID NOT NULL, PRIMARY KEY(category_id, event_id))');
        $this->addSql('CREATE INDEX idx_4df9d04d71f7e88b ON category_evens (event_id)');
        $this->addSql('CREATE INDEX idx_4df9d04d12469de2 ON category_evens (category_id)');
        $this->addSql('COMMENT ON COLUMN category_evens.category_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN category_evens.event_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE category_evens ADD CONSTRAINT fk_4df9d04d12469de2 FOREIGN KEY (category_id) REFERENCES events (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE category_evens ADD CONSTRAINT fk_4df9d04d71f7e88b FOREIGN KEY (event_id) REFERENCES categories (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE events DROP categories');
    }
}
