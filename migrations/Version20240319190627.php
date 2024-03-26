<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240319190627 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE car_report (id SERIAL NOT NULL, vin VARCHAR(17) NOT NULL, data VARCHAR(1000) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE operation (id SERIAL NOT NULL, car_report_id INT DEFAULT NULL, status SMALLINT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1981A66D4C3056EC ON operation (car_report_id)');
        $this->addSql('ALTER TABLE operation ADD CONSTRAINT car_report_id__car_report__fk FOREIGN KEY (car_report_id) REFERENCES car_report (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE operation DROP CONSTRAINT car_report_id__car_report__fk');
        $this->addSql('DROP TABLE car_report');
        $this->addSql('DROP TABLE operation');
    }
}
