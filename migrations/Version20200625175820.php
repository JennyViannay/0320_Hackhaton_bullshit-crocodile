<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200625175820 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE excuse_like (id INT AUTO_INCREMENT NOT NULL, excuse_id INT DEFAULT NULL, user_id INT DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_9C19FF8545731166 (excuse_id), INDEX IDX_9C19FF85A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE excuse_like ADD CONSTRAINT FK_9C19FF8545731166 FOREIGN KEY (excuse_id) REFERENCES excuse (id)');
        $this->addSql('ALTER TABLE excuse_like ADD CONSTRAINT FK_9C19FF85A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE excuse_like');
    }
}
