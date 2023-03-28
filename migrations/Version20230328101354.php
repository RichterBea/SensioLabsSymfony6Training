<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230328101354 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Alter BookGenre Entity';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE book_genre ADD COLUMN poster VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE book_genre');
        $this->addSql('CREATE TABLE book_genre (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO book_genre (id, name) SELECT id, name FROM __temp__book_genre');
        $this->addSql('DROP TABLE __temp__book_genre');
    }
}
