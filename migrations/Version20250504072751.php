<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250504072751 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP SEQUENCE test2_id_seq CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE test2
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE aircraft ALTER registration_number TYPE VARCHAR(7)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE aircraft_model ADD average_speed INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE aircraft_model ADD range INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE aircraft_model ADD Manufacturers_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE aircraft_model ADD CONSTRAINT FK_13208ADCB59BB999 FOREIGN KEY (Manufacturers_id) REFERENCES manufacturers (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_13208ADCB59BB999 ON aircraft_model (Manufacturers_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE seat_shablon ALTER compartment_type SET NOT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            CREATE SEQUENCE test2_id_seq INCREMENT BY 1 MINVALUE 1 START 1
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE test2 (id INT NOT NULL, text VARCHAR(255) DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE aircraft ALTER registration_number TYPE VARCHAR(255)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE seat_shablon ALTER compartment_type DROP NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE aircraft_model DROP CONSTRAINT FK_13208ADCB59BB999
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_13208ADCB59BB999
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE aircraft_model DROP average_speed
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE aircraft_model DROP range
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE aircraft_model DROP Manufacturers_id
        SQL);
    }
}
