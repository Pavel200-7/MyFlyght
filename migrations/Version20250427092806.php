<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250427092806 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SEQUENCE seat_shablon_id_seq INCREMENT BY 1 MINVALUE 1 START 1
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE seat_shablon (id INT NOT NULL, compartment_number INT NOT NULL, compartment_type VARCHAR(255) NOT NULL, zone_number INT NOT NULL, sector_number INT NOT NULL, row INT NOT NULL, number_in_row INT NOT NULL, SeatsDiscriptionShablon_id INT DEFAULT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_13169C6BEF71F68A ON seat_shablon (SeatsDiscriptionShablon_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE seat_shablon ADD CONSTRAINT FK_13169C6BEF71F68A FOREIGN KEY (SeatsDiscriptionShablon_id) REFERENCES seats_discription_shablon (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            DROP SEQUENCE seat_shablon_id_seq CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE seat_shablon DROP CONSTRAINT FK_13169C6BEF71F68A
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE seat_shablon
        SQL);
    }
}
