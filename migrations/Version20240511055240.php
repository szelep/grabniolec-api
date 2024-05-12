<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240511055240 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create session table.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA session');
        $this->addSql('CREATE TABLE session.session (id UUID NOT NULL, created_at DATE NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN session.session.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN session.session.created_at IS \'(DC2Type:date_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE session.session');
    }
}
