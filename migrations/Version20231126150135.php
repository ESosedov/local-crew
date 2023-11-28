<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231126150135 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE cities (id UUID NOT NULL, name VARCHAR(255) NOT NULL, longitude DOUBLE PRECISION DEFAULT NULL, latitude DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN cities.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN cities.name IS \'City name\'');
        $this->addSql('COMMENT ON COLUMN cities.longitude IS \'City longitude\'');
        $this->addSql('COMMENT ON COLUMN cities.latitude IS \'City latitude\'');
        $this->addSql('ALTER TABLE users ADD city_id UUID DEFAULT NULL');
        $this->addSql('ALTER TABLE users DROP city');
        $this->addSql('COMMENT ON COLUMN users.city_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E98BAC62AF FOREIGN KEY (city_id) REFERENCES cities (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E98BAC62AF ON users (city_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE users DROP CONSTRAINT FK_1483A5E98BAC62AF');
        $this->addSql('DROP TABLE cities');
        $this->addSql('DROP INDEX UNIQ_1483A5E98BAC62AF');
        $this->addSql('ALTER TABLE users ADD city VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE users DROP city_id');
        $this->addSql('COMMENT ON COLUMN users.city IS \'User`s city\'');
    }
}
