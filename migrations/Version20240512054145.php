<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240512054145 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA vote');
        $this->addSql('CREATE TABLE vote.vote (id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, session_id TEXT NOT NULL, client_id TEXT NOT NULL, song_id TEXT NOT NULL, vote_result VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_songId_voteResult ON vote.vote (song_id, vote_result)');
        $this->addSql('COMMENT ON COLUMN vote.vote.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN vote.vote.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FBC9FEDCA0BDB2F3 ON lyrics.lyrics (song_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE vote.vote');
        $this->addSql('DROP INDEX UNIQ_FBC9FEDCA0BDB2F3');
    }
}
