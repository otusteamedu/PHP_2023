<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230903130428 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE music_genre_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE music_playlist_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE music_track_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE music_genre (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE music_playlist (id INT NOT NULL, user_id VARCHAR(26) DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_10914D0BA76ED395 ON music_playlist (user_id)');
        $this->addSql('CREATE TABLE music_track (id INT NOT NULL, genre_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, author VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B16A836E4296D31F ON music_track (genre_id)');
        $this->addSql('ALTER TABLE music_playlist ADD CONSTRAINT FK_10914D0BA76ED395 FOREIGN KEY (user_id) REFERENCES music_user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE music_track ADD CONSTRAINT FK_B16A836E4296D31F FOREIGN KEY (genre_id) REFERENCES music_genre (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE music_genre_seq CASCADE');
        $this->addSql('DROP SEQUENCE music_playlist_seq CASCADE');
        $this->addSql('DROP SEQUENCE music_track_seq CASCADE');
        $this->addSql('ALTER TABLE music_playlist DROP CONSTRAINT FK_10914D0BA76ED395');
        $this->addSql('ALTER TABLE music_track DROP CONSTRAINT FK_B16A836E4296D31F');
        $this->addSql('DROP TABLE music_genre');
        $this->addSql('DROP TABLE music_playlist');
        $this->addSql('DROP TABLE music_track');
    }
}
