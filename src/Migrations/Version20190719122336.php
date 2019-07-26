<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190719122336 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user CHANGE given_name given_name VARCHAR(180) DEFAULT NULL, CHANGE family_name family_name VARCHAR(180) DEFAULT NULL, CHANGE picture_url picture_url VARCHAR(999) DEFAULT NULL, CHANGE locale locale VARCHAR(5) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user CHANGE given_name given_name VARCHAR(180) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE family_name family_name VARCHAR(180) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE picture_url picture_url VARCHAR(999) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE locale locale VARCHAR(5) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
