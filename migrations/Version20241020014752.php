<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241020014752 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE album (id UUID NOT NULL, title VARCHAR(255) NOT NULL, created_at TIMESTAMP(6) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN album.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN album.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE albums_artists (album_id UUID NOT NULL, artist_id UUID NOT NULL, PRIMARY KEY(album_id, artist_id))');
        $this->addSql('CREATE INDEX IDX_8BB2B6C11137ABCF ON albums_artists (album_id)');
        $this->addSql('CREATE INDEX IDX_8BB2B6C1B7970CF8 ON albums_artists (artist_id)');
        $this->addSql('COMMENT ON COLUMN albums_artists.album_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN albums_artists.artist_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE artist (id UUID NOT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP(6) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN artist.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN artist.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE track (id UUID NOT NULL, album_id UUID DEFAULT NULL, title VARCHAR(255) NOT NULL, created_at TIMESTAMP(6) WITHOUT TIME ZONE NOT NULL, source_platform VARCHAR(255) NOT NULL, source_track_id VARCHAR(255) NOT NULL, stream_url VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D6E3F8A61137ABCF ON track (album_id)');
        $this->addSql('COMMENT ON COLUMN track.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN track.album_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN track.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE tracks_artists (track_id UUID NOT NULL, artist_id UUID NOT NULL, PRIMARY KEY(track_id, artist_id))');
        $this->addSql('CREATE INDEX IDX_1B81E2955ED23C43 ON tracks_artists (track_id)');
        $this->addSql('CREATE INDEX IDX_1B81E295B7970CF8 ON tracks_artists (artist_id)');
        $this->addSql('COMMENT ON COLUMN tracks_artists.track_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN tracks_artists.artist_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE albums_artists ADD CONSTRAINT FK_8BB2B6C11137ABCF FOREIGN KEY (album_id) REFERENCES album (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE albums_artists ADD CONSTRAINT FK_8BB2B6C1B7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE track ADD CONSTRAINT FK_D6E3F8A61137ABCF FOREIGN KEY (album_id) REFERENCES album (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tracks_artists ADD CONSTRAINT FK_1B81E2955ED23C43 FOREIGN KEY (track_id) REFERENCES track (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tracks_artists ADD CONSTRAINT FK_1B81E295B7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE albums_artists DROP CONSTRAINT FK_8BB2B6C11137ABCF');
        $this->addSql('ALTER TABLE albums_artists DROP CONSTRAINT FK_8BB2B6C1B7970CF8');
        $this->addSql('ALTER TABLE track DROP CONSTRAINT FK_D6E3F8A61137ABCF');
        $this->addSql('ALTER TABLE tracks_artists DROP CONSTRAINT FK_1B81E2955ED23C43');
        $this->addSql('ALTER TABLE tracks_artists DROP CONSTRAINT FK_1B81E295B7970CF8');
        $this->addSql('DROP TABLE album');
        $this->addSql('DROP TABLE albums_artists');
        $this->addSql('DROP TABLE artist');
        $this->addSql('DROP TABLE track');
        $this->addSql('DROP TABLE tracks_artists');
    }
}
