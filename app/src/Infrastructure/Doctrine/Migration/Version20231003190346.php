<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231003190346 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE categories_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE categories (id BIGINT NOT NULL, name VARCHAR NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN categories.id IS \'(DC2Type:id)\'');
        $this->addSql('COMMENT ON COLUMN categories.name IS \'(DC2Type:not_empty_string)\'');

        $this->addSql('CREATE SEQUENCE news_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE news (id BIGINT NOT NULL, author_id BIGINT DEFAULT NULL, category_id BIGINT DEFAULT NULL, title VARCHAR NOT NULL, content VARCHAR(4000) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1DD39950F675F31B ON news (author_id)');
        $this->addSql('CREATE INDEX IDX_1DD3995012469DE2 ON news (category_id)');
        $this->addSql('COMMENT ON COLUMN news.id IS \'(DC2Type:id)\'');
        $this->addSql('COMMENT ON COLUMN news.author_id IS \'(DC2Type:id)\'');
        $this->addSql('COMMENT ON COLUMN news.category_id IS \'(DC2Type:id)\'');
        $this->addSql('COMMENT ON COLUMN news.title IS \'(DC2Type:not_empty_string)\'');
        $this->addSql('COMMENT ON COLUMN news.content IS \'(DC2Type:html_content)\'');

        $this->addSql('CREATE SEQUENCE users_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE users (id BIGINT NOT NULL, email VARCHAR(180) NOT NULL, password_hash VARCHAR NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN users.id IS \'(DC2Type:id)\'');
        $this->addSql('COMMENT ON COLUMN users.email IS \'(DC2Type:email)\'');
        $this->addSql('COMMENT ON COLUMN users.password_hash IS \'(DC2Type:not_empty_string)\'');
        $this->addSql('ALTER TABLE news ADD CONSTRAINT FK_1DD39950F675F31B FOREIGN KEY (author_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE news ADD CONSTRAINT FK_1DD3995012469DE2 FOREIGN KEY (category_id) REFERENCES categories (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE categories_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE news_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE users_id_seq CASCADE');
        $this->addSql('ALTER TABLE news DROP CONSTRAINT FK_1DD39950F675F31B');
        $this->addSql('ALTER TABLE news DROP CONSTRAINT FK_1DD3995012469DE2');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE news');
        $this->addSql('DROP TABLE users');
    }
}
