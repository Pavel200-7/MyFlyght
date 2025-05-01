<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250426180728 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SEQUENCE airline_id_seq INCREMENT BY 1 MINVALUE 1 START 1
        SQL);
        $this->addSql(<<<'SQL'
            CREATE SEQUENCE baggage_politicy_id_seq INCREMENT BY 1 MINVALUE 1 START 1
        SQL);
        $this->addSql(<<<'SQL'
            CREATE SEQUENCE flights_id_seq INCREMENT BY 1 MINVALUE 1 START 1
        SQL);
        $this->addSql(<<<'SQL'
            CREATE SEQUENCE hund_luggage_politicy_id_seq INCREMENT BY 1 MINVALUE 1 START 1
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE airline (id INT NOT NULL, airline_name VARCHAR(255) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE baggage_politicy (id INT NOT NULL, items_count INT NOT NULL, weight_per_item INT NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE flights (id INT NOT NULL, sheduled_departure TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, sheduled_arrival TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, departure_airport INT NOT NULL, arrival_airport TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, finished BOOLEAN NOT NULL, aircraft_id INT NOT NULL, actual_departure TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, actual_arrival TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, flight_number VARCHAR(10) NOT NULL, Airline_id INT DEFAULT NULL, HundLuggagePoliticy_id INT DEFAULT NULL, BaggagePoliticy_id INT DEFAULT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_FC74B5EA5C500FC6 ON flights (Airline_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_FC74B5EA7840C746 ON flights (HundLuggagePoliticy_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_FC74B5EAA8FDC153 ON flights (BaggagePoliticy_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE hund_luggage_politicy (id INT NOT NULL, items_count INT NOT NULL, weight_per_item INT NOT NULL, width_x INT NOT NULL, length_y INT NOT NULL, height_z INT NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE flights ADD CONSTRAINT FK_FC74B5EA5C500FC6 FOREIGN KEY (Airline_id) REFERENCES airline (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE flights ADD CONSTRAINT FK_FC74B5EA7840C746 FOREIGN KEY (HundLuggagePoliticy_id) REFERENCES hund_luggage_politicy (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE flights ADD CONSTRAINT FK_FC74B5EAA8FDC153 FOREIGN KEY (BaggagePoliticy_id) REFERENCES baggage_politicy (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            DROP SEQUENCE airline_id_seq CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            DROP SEQUENCE baggage_politicy_id_seq CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            DROP SEQUENCE flights_id_seq CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            DROP SEQUENCE hund_luggage_politicy_id_seq CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE flights DROP CONSTRAINT FK_FC74B5EA5C500FC6
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE flights DROP CONSTRAINT FK_FC74B5EA7840C746
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE flights DROP CONSTRAINT FK_FC74B5EAA8FDC153
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE airline
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE baggage_politicy
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE flights
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE hund_luggage_politicy
        SQL);
    }
}
