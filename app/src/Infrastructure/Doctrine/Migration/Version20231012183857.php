<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231012183857 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE bank_statements_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE bank_statements (id BIGINT NOT NULL, user_id BIGINT DEFAULT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2B0806E5A76ED395 ON bank_statements (user_id)');
        $this->addSql('COMMENT ON COLUMN bank_statements.id IS \'(DC2Type:id)\'');
        $this->addSql('COMMENT ON COLUMN bank_statements.user_id IS \'(DC2Type:id)\'');

        $this->addSql('CREATE SEQUENCE users_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE users (id BIGINT NOT NULL, email VARCHAR(180) NOT NULL, password_hash VARCHAR NOT NULL, roles JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9E7927C74 ON users (email)');
        $this->addSql('COMMENT ON COLUMN users.id IS \'(DC2Type:id)\'');
        $this->addSql('COMMENT ON COLUMN users.email IS \'(DC2Type:email)\'');
        $this->addSql('COMMENT ON COLUMN users.password_hash IS \'(DC2Type:not_empty_string)\'');
        $this->addSql('ALTER TABLE bank_statements ADD CONSTRAINT FK_2B0806E5A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE bank_statements_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE users_id_seq CASCADE');
        $this->addSql('ALTER TABLE bank_statements DROP CONSTRAINT FK_2B0806E5A76ED395');
        $this->addSql('DROP TABLE bank_statements');
        $this->addSql('DROP TABLE users');
    }
}
