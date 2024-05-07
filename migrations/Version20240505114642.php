<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240505114642 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create session table.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA app');
        $this->addSql('CREATE TABLE app.session (id UUID NOT NULL, created_at DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN app.session.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN app.session.created_at IS \'(DC2Type:date_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE app.session');
    }
}
