<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210621083750 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE songs_collab_artists (song_id INT NOT NULL, artist_id INT NOT NULL, INDEX IDX_5D23A8DCA0BDB2F3 (song_id), INDEX IDX_5D23A8DCB7970CF8 (artist_id), PRIMARY KEY(song_id, artist_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE songs_collab_artists ADD CONSTRAINT FK_5D23A8DCA0BDB2F3 FOREIGN KEY (song_id) REFERENCES song (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE songs_collab_artists ADD CONSTRAINT FK_5D23A8DCB7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE songs_collab_artists');
    }
}
