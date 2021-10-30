<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211029212331 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE produit_stock ADD stock_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE produit_stock ADD CONSTRAINT FK_7BAA31F4DCD6110 FOREIGN KEY (stock_id) REFERENCES stock (id)');
        $this->addSql('CREATE INDEX IDX_7BAA31F4DCD6110 ON produit_stock (stock_id)');
        $this->addSql('ALTER TABLE stock ADD centre_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE stock ADD CONSTRAINT FK_4B365660463CD7C3 FOREIGN KEY (centre_id) REFERENCES centre (id)');
        $this->addSql('CREATE INDEX IDX_4B365660463CD7C3 ON stock (centre_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('ALTER TABLE produit_stock DROP FOREIGN KEY FK_7BAA31F4DCD6110');
        $this->addSql('DROP INDEX IDX_7BAA31F4DCD6110 ON produit_stock');
        $this->addSql('ALTER TABLE produit_stock DROP stock_id');
        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY FK_4B365660463CD7C3');
        $this->addSql('DROP INDEX IDX_4B365660463CD7C3 ON stock');
        $this->addSql('ALTER TABLE stock DROP centre_id');
    }
}
