<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250428142911 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE tickets DROP CONSTRAINT fk_54469df4e45c45c2
        SQL);
        $this->addSql(<<<'SQL'
            DROP SEQUENCE clients_id_seq CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            DROP SEQUENCE working_accounts_id_seq CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE working_accounts DROP CONSTRAINT fk_bccaaf9e5c500fc6
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE clients
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE working_accounts
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX idx_54469df4e45c45c2
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE tickets RENAME COLUMN clients_id TO User_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE tickets ADD CONSTRAINT FK_54469DF468D3EA09 FOREIGN KEY (User_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_54469DF468D3EA09 ON tickets (User_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            CREATE SEQUENCE clients_id_seq INCREMENT BY 1 MINVALUE 1 START 1
        SQL);
        $this->addSql(<<<'SQL'
            CREATE SEQUENCE working_accounts_id_seq INCREMENT BY 1 MINVALUE 1 START 1
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE clients (id INT NOT NULL, login VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, full_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone_number VARCHAR(19) NOT NULL, blocked BOOLEAN NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE working_accounts (id INT NOT NULL, airline_id INT DEFAULT NULL, spe_account_type VARCHAR(255) NOT NULL, login VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, blocked BOOLEAN NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX idx_bccaaf9e5c500fc6 ON working_accounts (airline_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE working_accounts ADD CONSTRAINT fk_bccaaf9e5c500fc6 FOREIGN KEY (airline_id) REFERENCES airline (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE tickets DROP CONSTRAINT FK_54469DF468D3EA09
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_54469DF468D3EA09
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE tickets RENAME COLUMN User_id TO clients_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE tickets ADD CONSTRAINT fk_54469df4e45c45c2 FOREIGN KEY (clients_id) REFERENCES clients (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX idx_54469df4e45c45c2 ON tickets (clients_id)
        SQL);
    }
}
