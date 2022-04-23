<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220423165736 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE expenditure (id INT AUTO_INCREMENT NOT NULL, travel_id INT NOT NULL, expenditure_type_id INT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATE NOT NULL, amount NUMERIC(10, 2) NOT NULL, INDEX IDX_8D4A5FEBECAB15B3 (travel_id), INDEX IDX_8D4A5FEB5D9690AE (expenditure_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE expenditure_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, color VARCHAR(10) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fuel (id INT AUTO_INCREMENT NOT NULL, logbook_id INT DEFAULT NULL, fuel_type_id INT NOT NULL, fuel_at DATE NOT NULL, quantity INT NOT NULL, amount NUMERIC(10, 2) NOT NULL, unit_price NUMERIC(6, 2) DEFAULT NULL, INDEX IDX_31BD6FE9FA6B07A0 (logbook_id), INDEX IDX_31BD6FE96A70FE35 (fuel_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fuel_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, color VARCHAR(10) DEFAULT NULL, code VARCHAR(10) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE logbook (id INT AUTO_INCREMENT NOT NULL, numberplate VARCHAR(10) NOT NULL, departure VARCHAR(50) NOT NULL, arrival VARCHAR(50) NOT NULL, travel_at DATE NOT NULL, distance INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE servicing (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, vehicle_id INT NOT NULL, supplier_id INT DEFAULT NULL, created_at DATE NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, amount NUMERIC(10, 2) NOT NULL, INDEX IDX_C3BF6513C54C8C93 (type_id), INDEX IDX_C3BF6513545317D1 (vehicle_id), INDEX IDX_C3BF65132ADD6D8C (supplier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE servicing_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(10) NOT NULL, color VARCHAR(10) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE supplier (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) DEFAULT NULL, city VARCHAR(100) NOT NULL, zipcode VARCHAR(10) NOT NULL, mail VARCHAR(100) DEFAULT NULL, phone VARCHAR(20) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicle (id INT AUTO_INCREMENT NOT NULL, numberplate VARCHAR(10) NOT NULL, brand VARCHAR(50) NOT NULL, model VARCHAR(50) NOT NULL, odometer INT NOT NULL, energy VARCHAR(15) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE expenditure ADD CONSTRAINT FK_8D4A5FEBECAB15B3 FOREIGN KEY (travel_id) REFERENCES logbook (id)');
        $this->addSql('ALTER TABLE expenditure ADD CONSTRAINT FK_8D4A5FEB5D9690AE FOREIGN KEY (expenditure_type_id) REFERENCES expenditure_type (id)');
        $this->addSql('ALTER TABLE fuel ADD CONSTRAINT FK_31BD6FE9FA6B07A0 FOREIGN KEY (logbook_id) REFERENCES logbook (id)');
        $this->addSql('ALTER TABLE fuel ADD CONSTRAINT FK_31BD6FE96A70FE35 FOREIGN KEY (fuel_type_id) REFERENCES fuel_type (id)');
        $this->addSql('ALTER TABLE servicing ADD CONSTRAINT FK_C3BF6513C54C8C93 FOREIGN KEY (type_id) REFERENCES servicing_type (id)');
        $this->addSql('ALTER TABLE servicing ADD CONSTRAINT FK_C3BF6513545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id)');
        $this->addSql('ALTER TABLE servicing ADD CONSTRAINT FK_C3BF65132ADD6D8C FOREIGN KEY (supplier_id) REFERENCES supplier (id)');
        $this->addSql('ALTER TABLE user ADD logbook_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649FA6B07A0 FOREIGN KEY (logbook_id) REFERENCES logbook (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649FA6B07A0 ON user (logbook_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE expenditure DROP FOREIGN KEY FK_8D4A5FEB5D9690AE');
        $this->addSql('ALTER TABLE fuel DROP FOREIGN KEY FK_31BD6FE96A70FE35');
        $this->addSql('ALTER TABLE expenditure DROP FOREIGN KEY FK_8D4A5FEBECAB15B3');
        $this->addSql('ALTER TABLE fuel DROP FOREIGN KEY FK_31BD6FE9FA6B07A0');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649FA6B07A0');
        $this->addSql('ALTER TABLE servicing DROP FOREIGN KEY FK_C3BF6513C54C8C93');
        $this->addSql('ALTER TABLE servicing DROP FOREIGN KEY FK_C3BF65132ADD6D8C');
        $this->addSql('ALTER TABLE servicing DROP FOREIGN KEY FK_C3BF6513545317D1');
        $this->addSql('DROP TABLE expenditure');
        $this->addSql('DROP TABLE expenditure_type');
        $this->addSql('DROP TABLE fuel');
        $this->addSql('DROP TABLE fuel_type');
        $this->addSql('DROP TABLE logbook');
        $this->addSql('DROP TABLE servicing');
        $this->addSql('DROP TABLE servicing_type');
        $this->addSql('DROP TABLE supplier');
        $this->addSql('DROP TABLE vehicle');
        $this->addSql('DROP INDEX IDX_8D93D649FA6B07A0 ON user');
        $this->addSql('ALTER TABLE user DROP logbook_id');
    }
}
