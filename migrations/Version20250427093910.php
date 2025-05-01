<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250427093910 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SEQUENCE working_accounts_id_seq INCREMENT BY 1 MINVALUE 1 START 1
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE working_accounts (id INT NOT NULL, spe_account_type VARCHAR(255) NOT NULL, login VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, blocked BOOLEAN NOT NULL, Airline_id INT DEFAULT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_BCCAAF9E5C500FC6 ON working_accounts (Airline_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE working_accounts ADD CONSTRAINT FK_BCCAAF9E5C500FC6 FOREIGN KEY (Airline_id) REFERENCES airline (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            DROP SEQUENCE working_accounts_id_seq CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE working_accounts DROP CONSTRAINT FK_BCCAAF9E5C500FC6
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE working_accounts
        SQL);
    }
}
