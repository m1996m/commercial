<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211120090220 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE type_produit ADD centre_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE type_produit ADD CONSTRAINT FK_18483D2463CD7C3 FOREIGN KEY (centre_id) REFERENCES centre (id)');
        $this->addSql('CREATE INDEX IDX_18483D2463CD7C3 ON type_produit (centre_id)');
        $this->addSql('ALTER TABLE type_rayon ADD centre_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE type_rayon ADD CONSTRAINT FK_DBE93BCB463CD7C3 FOREIGN KEY (centre_id) REFERENCES centre (id)');
        $this->addSql('CREATE INDEX IDX_DBE93BCB463CD7C3 ON type_rayon (centre_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE type_produit DROP FOREIGN KEY FK_18483D2463CD7C3');
        $this->addSql('DROP INDEX IDX_18483D2463CD7C3 ON type_produit');
        $this->addSql('ALTER TABLE type_produit DROP centre_id');
        $this->addSql('ALTER TABLE type_rayon DROP FOREIGN KEY FK_DBE93BCB463CD7C3');
        $this->addSql('DROP INDEX IDX_DBE93BCB463CD7C3 ON type_rayon');
        $this->addSql('ALTER TABLE type_rayon DROP centre_id');
    }
}
