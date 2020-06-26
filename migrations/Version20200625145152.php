<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200625145152 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE excuse_of_the_day (id INT AUTO_INCREMENT NOT NULL, excuse_id INT DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_24999E9645731166 (excuse_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE excuse_of_the_day ADD CONSTRAINT FK_24999E9645731166 FOREIGN KEY (excuse_id) REFERENCES excuse (id)');
        $this->addSql('ALTER TABLE user ADD excuse_of_the_day_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649F9CE8D22 FOREIGN KEY (excuse_of_the_day_id) REFERENCES excuse_of_the_day (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649F9CE8D22 ON user (excuse_of_the_day_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649F9CE8D22');
        $this->addSql('DROP TABLE excuse_of_the_day');
        $this->addSql('DROP INDEX IDX_8D93D649F9CE8D22 ON user');
        $this->addSql('ALTER TABLE user DROP excuse_of_the_day_id');
    }
}
