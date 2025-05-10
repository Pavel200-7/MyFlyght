<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250510195604 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SEQUENCE baggage_politicy_rate_id_seq INCREMENT BY 1 MINVALUE 1 START 1
        SQL);
        $this->addSql(<<<'SQL'
            CREATE SEQUENCE plane_class_rate_id_seq INCREMENT BY 1 MINVALUE 1 START 1
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE baggage_politicy_rate (id INT NOT NULL, cost_per_km DOUBLE PRECISION NOT NULL, Airline_id INT DEFAULT NULL, BaggagePoliticy_id INT DEFAULT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_BC7DE6C45C500FC6 ON baggage_politicy_rate (Airline_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_BC7DE6C4A8FDC153 ON baggage_politicy_rate (BaggagePoliticy_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE plane_class_rate (id INT NOT NULL, class_type VARCHAR(255) NOT NULL, cost_per_km DOUBLE PRECISION NOT NULL, Airline_id INT DEFAULT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_27DFE005C500FC6 ON plane_class_rate (Airline_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE baggage_politicy_rate ADD CONSTRAINT FK_BC7DE6C45C500FC6 FOREIGN KEY (Airline_id) REFERENCES airline (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE baggage_politicy_rate ADD CONSTRAINT FK_BC7DE6C4A8FDC153 FOREIGN KEY (BaggagePoliticy_id) REFERENCES baggage_politicy (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE plane_class_rate ADD CONSTRAINT FK_27DFE005C500FC6 FOREIGN KEY (Airline_id) REFERENCES airline (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            DROP SEQUENCE baggage_politicy_rate_id_seq CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            DROP SEQUENCE plane_class_rate_id_seq CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE baggage_politicy_rate DROP CONSTRAINT FK_BC7DE6C45C500FC6
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE baggage_politicy_rate DROP CONSTRAINT FK_BC7DE6C4A8FDC153
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE plane_class_rate DROP CONSTRAINT FK_27DFE005C500FC6
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE baggage_politicy_rate
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE plane_class_rate
        SQL);
    }
}
