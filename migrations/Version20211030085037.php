<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211030085037 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE centre ADD slug VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE client ADD slug VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE fournisseur ADD slug VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE stock ADD slug VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user ADD slug VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE centre DROP slug');
        $this->addSql('ALTER TABLE client DROP slug');
        $this->addSql('ALTER TABLE fournisseur DROP slug');
        $this->addSql('ALTER TABLE stock DROP slug');
        $this->addSql('ALTER TABLE user DROP slug');
    }
}
