<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211207091334 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produitvendu ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE produitvendu ADD CONSTRAINT FK_AB42258DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_AB42258DA76ED395 ON produitvendu (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produitvendu DROP FOREIGN KEY FK_AB42258DA76ED395');
        $this->addSql('DROP INDEX IDX_AB42258DA76ED395 ON produitvendu');
        $this->addSql('ALTER TABLE produitvendu DROP user_id');
    }
}
