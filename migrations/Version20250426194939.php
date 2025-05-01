<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250426194939 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SEQUENCE aircraft_id_seq INCREMENT BY 1 MINVALUE 1 START 1
        SQL);
        $this->addSql(<<<'SQL'
            CREATE SEQUENCE aircraft_model_id_seq INCREMENT BY 1 MINVALUE 1 START 1
        SQL);
        $this->addSql(<<<'SQL'
            CREATE SEQUENCE clients_id_seq INCREMENT BY 1 MINVALUE 1 START 1
        SQL);
        $this->addSql(<<<'SQL'
            CREATE SEQUENCE flights_seats_id_seq INCREMENT BY 1 MINVALUE 1 START 1
        SQL);
        $this->addSql(<<<'SQL'
            CREATE SEQUENCE manufacturers_id_seq INCREMENT BY 1 MINVALUE 1 START 1
        SQL);
        $this->addSql(<<<'SQL'
            CREATE SEQUENCE seats_discription_shablon_id_seq INCREMENT BY 1 MINVALUE 1 START 1
        SQL);
        $this->addSql(<<<'SQL'
            CREATE SEQUENCE tickets_id_seq INCREMENT BY 1 MINVALUE 1 START 1
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE aircraft (id INT NOT NULL, manufacture_date DATE NOT NULL, registration_number VARCHAR(255) NOT NULL, Airline_id INT DEFAULT NULL, AircraftModel_id INT DEFAULT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_13D967295C500FC6 ON aircraft (Airline_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_13D967292D65056F ON aircraft (AircraftModel_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE aircraft_model (id INT NOT NULL, model VARCHAR(255) NOT NULL, max_sits INT NOT NULL, max_weight INT NOT NULL, SeatsDiscriptionShablon_id INT DEFAULT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_13208ADCEF71F68A ON aircraft_model (SeatsDiscriptionShablon_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE clients (id INT NOT NULL, login VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, full_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone_number VARCHAR(19) NOT NULL, blocked BOOLEAN NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE flights_seats (id INT NOT NULL, compartment_number INT NOT NULL, compartment_type VARCHAR(255) NOT NULL, zone_number INT NOT NULL, sector_number INT NOT NULL, row INT NOT NULL, number_in_row INT NOT NULL, avalible BOOLEAN NOT NULL, Flights_id INT DEFAULT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_2A1B93343B37CB2 ON flights_seats (Flights_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE manufacturers (id INT NOT NULL, manufacturer_name VARCHAR(255) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE seats_discription_shablon (id INT NOT NULL, seats_discription_shablon_name VARCHAR(255) NOT NULL, SeatsShablon_id INT DEFAULT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D3FEF40C40FDB1FB ON seats_discription_shablon (SeatsShablon_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE tickets (id INT NOT NULL, finished BOOLEAN NOT NULL, timestamp TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, Flights_id INT DEFAULT NULL, FlightsSeats_id INT DEFAULT NULL, Clients_id INT DEFAULT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_54469DF443B37CB2 ON tickets (Flights_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_54469DF4BD9A5415 ON tickets (FlightsSeats_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_54469DF4E45C45C2 ON tickets (Clients_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE aircraft ADD CONSTRAINT FK_13D967295C500FC6 FOREIGN KEY (Airline_id) REFERENCES airline (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE aircraft ADD CONSTRAINT FK_13D967292D65056F FOREIGN KEY (AircraftModel_id) REFERENCES aircraft_model (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE aircraft_model ADD CONSTRAINT FK_13208ADCEF71F68A FOREIGN KEY (SeatsDiscriptionShablon_id) REFERENCES seats_discription_shablon (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE flights_seats ADD CONSTRAINT FK_2A1B93343B37CB2 FOREIGN KEY (Flights_id) REFERENCES flights (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE seats_discription_shablon ADD CONSTRAINT FK_D3FEF40C40FDB1FB FOREIGN KEY (SeatsShablon_id) REFERENCES seats_discription_shablon (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE tickets ADD CONSTRAINT FK_54469DF443B37CB2 FOREIGN KEY (Flights_id) REFERENCES flights (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE tickets ADD CONSTRAINT FK_54469DF4BD9A5415 FOREIGN KEY (FlightsSeats_id) REFERENCES flights_seats (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE tickets ADD CONSTRAINT FK_54469DF4E45C45C2 FOREIGN KEY (Clients_id) REFERENCES clients (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE flights ADD Airports_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE flights DROP departure_airport
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE flights DROP arrival_airport
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE flights ALTER aircraft_id DROP NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE flights ADD CONSTRAINT FK_FC74B5EAF47AE723 FOREIGN KEY (Airports_id) REFERENCES airports (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE flights ADD CONSTRAINT FK_FC74B5EA2F2A08B FOREIGN KEY (Aircraft_id) REFERENCES aircraft (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_FC74B5EAF47AE723 ON flights (Airports_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_FC74B5EA2F2A08B ON flights (Aircraft_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE flights DROP CONSTRAINT FK_FC74B5EA2F2A08B
        SQL);
        $this->addSql(<<<'SQL'
            DROP SEQUENCE aircraft_id_seq CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            DROP SEQUENCE aircraft_model_id_seq CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            DROP SEQUENCE clients_id_seq CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            DROP SEQUENCE flights_seats_id_seq CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            DROP SEQUENCE manufacturers_id_seq CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            DROP SEQUENCE seats_discription_shablon_id_seq CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            DROP SEQUENCE tickets_id_seq CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE aircraft DROP CONSTRAINT FK_13D967295C500FC6
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE aircraft DROP CONSTRAINT FK_13D967292D65056F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE aircraft_model DROP CONSTRAINT FK_13208ADCEF71F68A
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE flights_seats DROP CONSTRAINT FK_2A1B93343B37CB2
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE seats_discription_shablon DROP CONSTRAINT FK_D3FEF40C40FDB1FB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE tickets DROP CONSTRAINT FK_54469DF443B37CB2
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE tickets DROP CONSTRAINT FK_54469DF4BD9A5415
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE tickets DROP CONSTRAINT FK_54469DF4E45C45C2
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE aircraft
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE aircraft_model
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE clients
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE flights_seats
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE manufacturers
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE seats_discription_shablon
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE tickets
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE flights DROP CONSTRAINT FK_FC74B5EAF47AE723
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_FC74B5EAF47AE723
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_FC74B5EA2F2A08B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE flights ADD departure_airport INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE flights ADD arrival_airport TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE flights DROP Airports_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE flights ALTER Aircraft_id SET NOT NULL
        SQL);
    }
}
