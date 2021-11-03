<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211101055614 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE type_rayon (id INT AUTO_INCREMENT NOT NULL, designation VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rayon ADD type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rayon ADD CONSTRAINT FK_D5E5BC3CC54C8C93 FOREIGN KEY (type_id) REFERENCES type_rayon (id)');
        $this->addSql('CREATE INDEX IDX_D5E5BC3CC54C8C93 ON rayon (type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rayon DROP FOREIGN KEY FK_D5E5BC3CC54C8C93');
        $this->addSql('DROP TABLE type_rayon');
        $this->addSql('DROP INDEX IDX_D5E5BC3CC54C8C93 ON rayon');
        $this->addSql('ALTER TABLE rayon DROP type_id');
    }
}
