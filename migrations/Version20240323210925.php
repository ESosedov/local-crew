<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240323210925 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('DROP INDEX uniq_c0f77b50a76ed395');
        $this->addSql('DROP INDEX uniq_c0f77b5071f7e88b');
        $this->addSql('CREATE INDEX IDX_C0F77B5071F7E88B ON event_members (event_id)');
        $this->addSql('CREATE INDEX IDX_C0F77B50A76ED395 ON event_members (user_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP INDEX IDX_C0F77B5071F7E88B');
        $this->addSql('DROP INDEX IDX_C0F77B50A76ED395');
        $this->addSql('CREATE UNIQUE INDEX uniq_c0f77b50a76ed395 ON event_members (user_id)');
        $this->addSql('CREATE UNIQUE INDEX uniq_c0f77b5071f7e88b ON event_members (event_id)');
    }
}
