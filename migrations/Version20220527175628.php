<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220527175628 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE song_has_artist_and_type (id INT AUTO_INCREMENT NOT NULL, song_id INT NOT NULL, artist_id INT NOT NULL, artist_type_id INT NOT NULL, INDEX IDX_553B71BDA0BDB2F3 (song_id), INDEX IDX_553B71BDB7970CF8 (artist_id), INDEX IDX_553B71BD7203D2A4 (artist_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE song_has_artist_and_type ADD CONSTRAINT FK_553B71BDA0BDB2F3 FOREIGN KEY (song_id) REFERENCES song (id)');
        $this->addSql('ALTER TABLE song_has_artist_and_type ADD CONSTRAINT FK_553B71BDB7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id)');
        $this->addSql('ALTER TABLE song_has_artist_and_type ADD CONSTRAINT FK_553B71BD7203D2A4 FOREIGN KEY (artist_type_id) REFERENCES artist_type (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE song_has_artist_and_type');
    }
}
