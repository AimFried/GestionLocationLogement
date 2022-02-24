<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220119163354 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE locataire (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, telephone VARCHAR(14) NOT NULL, adresse VARCHAR(255) NOT NULL, code_postal DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE logement (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, code_postal DOUBLE PRECISION NOT NULL, pers_max DOUBLE PRECISION NOT NULL, description VARCHAR(255) NOT NULL, etat TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, locataires_id INT NOT NULL, logements_id INT NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, prix_nuit DOUBLE PRECISION NOT NULL, prix_total DOUBLE PRECISION NOT NULL, nbr_adulte DOUBLE PRECISION NOT NULL, nbr_enfant DOUBLE PRECISION NOT NULL, etat_contrat TINYINT(1) NOT NULL, INDEX IDX_42C849556E7A3544 (locataires_id), INDEX IDX_42C84955FC28B3A7 (logements_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE calendar (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(100) NOT NULL, start DATETIME NOT NULL, end DATETIME NOT NULL, description LONGTEXT NOT NULL, all_day TINYINT(1) NOT NULL, background_color VARCHAR(7) NOT NULL, border_color VARCHAR(7) NOT NULL, text_color VARCHAR(7) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849556E7A3544 FOREIGN KEY (locataires_id) REFERENCES locataire (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955FC28B3A7 FOREIGN KEY (logements_id) REFERENCES logement (id)');
        $this->addSql('ALTER TABLE reservation ADD calendrier_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955FF52FC51 FOREIGN KEY (calendrier_id) REFERENCES calendar (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_42C84955FF52FC51 ON reservation (calendrier_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849556E7A3544');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955FC28B3A7');
        $this->addSql('DROP TABLE locataire');
        $this->addSql('DROP TABLE logement');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
