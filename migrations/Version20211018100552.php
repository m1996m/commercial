<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211018100552 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE centre (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, tel VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, pays VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, tel VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client_centre (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, centre_id INT DEFAULT NULL, INDEX IDX_9306A1C619EB6921 (client_id), INDEX IDX_9306A1C6463CD7C3 (centre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fournisseur (id INT AUTO_INCREMENT NOT NULL, centre_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, tel VARCHAR(255) NOT NULL, INDEX IDX_369ECA32463CD7C3 (centre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fournisseur_centre (id INT AUTO_INCREMENT NOT NULL, fournisseur_id INT DEFAULT NULL, centre_id INT DEFAULT NULL, INDEX IDX_B6ABA53670C757F (fournisseur_id), INDEX IDX_B6ABA53463CD7C3 (centre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, type_id INT DEFAULT NULL, designation VARCHAR(255) NOT NULL, pua DOUBLE PRECISION NOT NULL, puv DOUBLE PRECISION NOT NULL, INDEX IDX_29A5EC27C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit_stock (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, produit_id INT DEFAULT NULL, fournisseur_id INT DEFAULT NULL, pua DOUBLE PRECISION NOT NULL, puv DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', quantite INT NOT NULL, INDEX IDX_7BAA31F4A76ED395 (user_id), INDEX IDX_7BAA31F4F347EFB (produit_id), INDEX IDX_7BAA31F4670C757F (fournisseur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produitvendu (id INT AUTO_INCREMENT NOT NULL, vente_id INT DEFAULT NULL, rayon_id INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_AB42258D7DC7170A (vente_id), INDEX IDX_AB42258DD3202E52 (rayon_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rayon (id INT AUTO_INCREMENT NOT NULL, quantite INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stock (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_produit (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, centre_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, nom VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, tel VARCHAR(255) DEFAULT NULL, fonction VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D649463CD7C3 (centre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vente (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', quantite INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE client_centre ADD CONSTRAINT FK_9306A1C619EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE client_centre ADD CONSTRAINT FK_9306A1C6463CD7C3 FOREIGN KEY (centre_id) REFERENCES centre (id)');
        $this->addSql('ALTER TABLE fournisseur ADD CONSTRAINT FK_369ECA32463CD7C3 FOREIGN KEY (centre_id) REFERENCES centre (id)');
        $this->addSql('ALTER TABLE fournisseur_centre ADD CONSTRAINT FK_B6ABA53670C757F FOREIGN KEY (fournisseur_id) REFERENCES fournisseur (id)');
        $this->addSql('ALTER TABLE fournisseur_centre ADD CONSTRAINT FK_B6ABA53463CD7C3 FOREIGN KEY (centre_id) REFERENCES centre (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27C54C8C93 FOREIGN KEY (type_id) REFERENCES type_produit (id)');
        $this->addSql('ALTER TABLE produit_stock ADD CONSTRAINT FK_7BAA31F4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE produit_stock ADD CONSTRAINT FK_7BAA31F4F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE produit_stock ADD CONSTRAINT FK_7BAA31F4670C757F FOREIGN KEY (fournisseur_id) REFERENCES fournisseur (id)');
        $this->addSql('ALTER TABLE produitvendu ADD CONSTRAINT FK_AB42258D7DC7170A FOREIGN KEY (vente_id) REFERENCES vente (id)');
        $this->addSql('ALTER TABLE produitvendu ADD CONSTRAINT FK_AB42258DD3202E52 FOREIGN KEY (rayon_id) REFERENCES rayon (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649463CD7C3 FOREIGN KEY (centre_id) REFERENCES centre (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client_centre DROP FOREIGN KEY FK_9306A1C6463CD7C3');
        $this->addSql('ALTER TABLE fournisseur DROP FOREIGN KEY FK_369ECA32463CD7C3');
        $this->addSql('ALTER TABLE fournisseur_centre DROP FOREIGN KEY FK_B6ABA53463CD7C3');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649463CD7C3');
        $this->addSql('ALTER TABLE client_centre DROP FOREIGN KEY FK_9306A1C619EB6921');
        $this->addSql('ALTER TABLE fournisseur_centre DROP FOREIGN KEY FK_B6ABA53670C757F');
        $this->addSql('ALTER TABLE produit_stock DROP FOREIGN KEY FK_7BAA31F4670C757F');
        $this->addSql('ALTER TABLE produit_stock DROP FOREIGN KEY FK_7BAA31F4F347EFB');
        $this->addSql('ALTER TABLE produitvendu DROP FOREIGN KEY FK_AB42258DD3202E52');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27C54C8C93');
        $this->addSql('ALTER TABLE produit_stock DROP FOREIGN KEY FK_7BAA31F4A76ED395');
        $this->addSql('ALTER TABLE produitvendu DROP FOREIGN KEY FK_AB42258D7DC7170A');
        $this->addSql('DROP TABLE centre');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE client_centre');
        $this->addSql('DROP TABLE fournisseur');
        $this->addSql('DROP TABLE fournisseur_centre');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE produit_stock');
        $this->addSql('DROP TABLE produitvendu');
        $this->addSql('DROP TABLE rayon');
        $this->addSql('DROP TABLE stock');
        $this->addSql('DROP TABLE type_produit');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE vente');
    }
}
