<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200626081711 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bet (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, excuse_id INT NOT NULL, created_at DATETIME NOT NULL, finish_at DATETIME NOT NULL, is_archived TINYINT(1) NOT NULL, INDEX IDX_FBF0EC9BA76ED395 (user_id), INDEX IDX_FBF0EC9B45731166 (excuse_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE excuse (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, text LONGTEXT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_623AD9F0F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE excuse_like (id INT AUTO_INCREMENT NOT NULL, excuse_id INT DEFAULT NULL, user_id INT DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_9C19FF8545731166 (excuse_id), INDEX IDX_9C19FF85A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE excuse_of_the_day (id INT AUTO_INCREMENT NOT NULL, excuse_id INT DEFAULT NULL, created_at DATETIME NOT NULL, is_active TINYINT(1) NOT NULL, finish_at DATETIME NOT NULL, INDEX IDX_24999E9645731166 (excuse_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE excuse_of_the_day_bet (excuse_of_the_day_id INT NOT NULL, bet_id INT NOT NULL, INDEX IDX_45BD0B61F9CE8D22 (excuse_of_the_day_id), INDEX IDX_45BD0B61D871DC26 (bet_id), PRIMARY KEY(excuse_of_the_day_id, bet_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, last_bet_id INT DEFAULT NULL, username VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, avatar VARCHAR(255) DEFAULT NULL, comment LONGTEXT DEFAULT NULL, birth_date DATE DEFAULT NULL, is_verified TINYINT(1) NOT NULL, can_bet TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D64952765EFC (last_bet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bet ADD CONSTRAINT FK_FBF0EC9BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE bet ADD CONSTRAINT FK_FBF0EC9B45731166 FOREIGN KEY (excuse_id) REFERENCES excuse (id)');
        $this->addSql('ALTER TABLE excuse ADD CONSTRAINT FK_623AD9F0F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE excuse_like ADD CONSTRAINT FK_9C19FF8545731166 FOREIGN KEY (excuse_id) REFERENCES excuse (id)');
        $this->addSql('ALTER TABLE excuse_like ADD CONSTRAINT FK_9C19FF85A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE excuse_of_the_day ADD CONSTRAINT FK_24999E9645731166 FOREIGN KEY (excuse_id) REFERENCES excuse (id)');
        $this->addSql('ALTER TABLE excuse_of_the_day_bet ADD CONSTRAINT FK_45BD0B61F9CE8D22 FOREIGN KEY (excuse_of_the_day_id) REFERENCES excuse_of_the_day (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE excuse_of_the_day_bet ADD CONSTRAINT FK_45BD0B61D871DC26 FOREIGN KEY (bet_id) REFERENCES bet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64952765EFC FOREIGN KEY (last_bet_id) REFERENCES bet (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE excuse_of_the_day_bet DROP FOREIGN KEY FK_45BD0B61D871DC26');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64952765EFC');
        $this->addSql('ALTER TABLE bet DROP FOREIGN KEY FK_FBF0EC9B45731166');
        $this->addSql('ALTER TABLE excuse_like DROP FOREIGN KEY FK_9C19FF8545731166');
        $this->addSql('ALTER TABLE excuse_of_the_day DROP FOREIGN KEY FK_24999E9645731166');
        $this->addSql('ALTER TABLE excuse_of_the_day_bet DROP FOREIGN KEY FK_45BD0B61F9CE8D22');
        $this->addSql('ALTER TABLE bet DROP FOREIGN KEY FK_FBF0EC9BA76ED395');
        $this->addSql('ALTER TABLE excuse DROP FOREIGN KEY FK_623AD9F0F675F31B');
        $this->addSql('ALTER TABLE excuse_like DROP FOREIGN KEY FK_9C19FF85A76ED395');
        $this->addSql('DROP TABLE bet');
        $this->addSql('DROP TABLE excuse');
        $this->addSql('DROP TABLE excuse_like');
        $this->addSql('DROP TABLE excuse_of_the_day');
        $this->addSql('DROP TABLE excuse_of_the_day_bet');
        $this->addSql('DROP TABLE user');
    }
}
