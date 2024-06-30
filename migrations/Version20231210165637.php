<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231210165637 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE files (id UUID NOT NULL, external_id VARCHAR(255) NOT NULL, url VARCHAR(512) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN files.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN files.external_id IS \'Cloud id\'');
        $this->addSql('COMMENT ON COLUMN files.url IS \'url\'');
        $this->addSql('DROP INDEX uniq_1483a5e98bac62af');
        $this->addSql('ALTER TABLE users ADD avatar_id UUID DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN users.avatar_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E986383B10 FOREIGN KEY (avatar_id) REFERENCES files (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_1483A5E98BAC62AF ON users (city_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E986383B10 ON users (avatar_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE users DROP CONSTRAINT FK_1483A5E986383B10');
        $this->addSql('DROP TABLE files');
        $this->addSql('DROP INDEX IDX_1483A5E98BAC62AF');
        $this->addSql('DROP INDEX UNIQ_1483A5E986383B10');
        $this->addSql('ALTER TABLE users DROP avatar_id');
        $this->addSql('CREATE UNIQUE INDEX uniq_1483a5e98bac62af ON users (city_id)');
    }
}
