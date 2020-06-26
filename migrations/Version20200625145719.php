<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200625145719 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bet ADD excuse_of_the_day_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bet ADD CONSTRAINT FK_FBF0EC9BF9CE8D22 FOREIGN KEY (excuse_of_the_day_id) REFERENCES excuse_of_the_day (id)');
        $this->addSql('CREATE INDEX IDX_FBF0EC9BF9CE8D22 ON bet (excuse_of_the_day_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bet DROP FOREIGN KEY FK_FBF0EC9BF9CE8D22');
        $this->addSql('DROP INDEX IDX_FBF0EC9BF9CE8D22 ON bet');
        $this->addSql('ALTER TABLE bet DROP excuse_of_the_day_id');
    }
}
