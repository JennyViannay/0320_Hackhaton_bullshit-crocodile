<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200625105124 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE excuse ADD author_id INT DEFAULT NULL, ADD created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE excuse ADD CONSTRAINT FK_623AD9F0F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_623AD9F0F675F31B ON excuse (author_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE excuse DROP FOREIGN KEY FK_623AD9F0F675F31B');
        $this->addSql('DROP INDEX IDX_623AD9F0F675F31B ON excuse');
        $this->addSql('ALTER TABLE excuse DROP author_id, DROP created_at');
    }
}
