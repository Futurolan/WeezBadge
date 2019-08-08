<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190808140507 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, name VARCHAR(180) NOT NULL, given_name VARCHAR(180) DEFAULT NULL, family_name VARCHAR(180) DEFAULT NULL, picture_url VARCHAR(999) DEFAULT NULL, locale VARCHAR(5) DEFAULT NULL, roles JSON NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parameter (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(180) NOT NULL, value JSON NOT NULL, UNIQUE INDEX UNIQ_2A9791105E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE log (id INT AUTO_INCREMENT NOT NULL, created_id INT NOT NULL, created_email VARCHAR(180) NOT NULL, created_name VARCHAR(180) DEFAULT NULL, created_date DATETIME NOT NULL, deleted_id INT DEFAULT NULL, deleted_email VARCHAR(180) DEFAULT NULL, deleted_name VARCHAR(180) DEFAULT NULL, deleted_date DATETIME DEFAULT NULL, event_id INT NOT NULL, ticket_id INT NOT NULL, participantid INT NOT NULL, hash VARCHAR(64) DEFAULT NULL, UNIQUE INDEX UNIQ_8F3F68C536802B0F (participantid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE parameter');
        $this->addSql('DROP TABLE log');
    }
}
