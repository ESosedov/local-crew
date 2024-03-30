<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240325210855 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE categories (id UUID NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN categories.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN categories.title IS \'Category`s title\'');
        $this->addSql('CREATE TABLE category_evens (category_id UUID NOT NULL, event_id UUID NOT NULL, PRIMARY KEY(category_id, event_id))');
        $this->addSql('CREATE INDEX IDX_4DF9D04D12469DE2 ON category_evens (category_id)');
        $this->addSql('CREATE INDEX IDX_4DF9D04D71F7E88B ON category_evens (event_id)');
        $this->addSql('COMMENT ON COLUMN category_evens.category_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN category_evens.event_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE category_evens ADD CONSTRAINT FK_4DF9D04D12469DE2 FOREIGN KEY (category_id) REFERENCES events (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE category_evens ADD CONSTRAINT FK_4DF9D04D71F7E88B FOREIGN KEY (event_id) REFERENCES categories (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE ext_translations');
        $this->addSql('ALTER TABLE event_members ADD is_member BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE event_members ADD is_favorite BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE events ADD count_members_max INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE category_evens DROP CONSTRAINT FK_4DF9D04D12469DE2');
        $this->addSql('ALTER TABLE category_evens DROP CONSTRAINT FK_4DF9D04D71F7E88B');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE category_evens');
        $this->addSql('ALTER TABLE event_members DROP is_member');
        $this->addSql('ALTER TABLE event_members DROP is_favorite');
        $this->addSql('ALTER TABLE events DROP count_members_max');
    }
}
