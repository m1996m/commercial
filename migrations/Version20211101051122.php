<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211101051122 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rayon ADD produit_stock_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rayon ADD CONSTRAINT FK_D5E5BC3C24D25303 FOREIGN KEY (produit_stock_id) REFERENCES produit_stock (id)');
        $this->addSql('CREATE INDEX IDX_D5E5BC3C24D25303 ON rayon (produit_stock_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rayon DROP FOREIGN KEY FK_D5E5BC3C24D25303');
        $this->addSql('DROP INDEX IDX_D5E5BC3C24D25303 ON rayon');
        $this->addSql('ALTER TABLE rayon DROP produit_stock_id');
    }
}
