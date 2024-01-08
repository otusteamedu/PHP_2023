<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240107113203 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE expense_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE income_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE expense (id INT NOT NULL, date DATE NOT NULL, amount VARCHAR(255) NOT NULL, currency VARCHAR(5) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE income (id INT NOT NULL, date DATE NOT NULL, amount VARCHAR(255) NOT NULL, currency VARCHAR(5) NOT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE expense_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE income_id_seq CASCADE');
        $this->addSql('DROP TABLE expense');
        $this->addSql('DROP TABLE income');
    }
}
