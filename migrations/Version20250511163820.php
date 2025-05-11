<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250511163820 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE flights DROP CONSTRAINT fk_fc74b5eaf47ae723
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX idx_fc74b5eaf47ae723
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE flights ADD arrival_airports_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE flights RENAME COLUMN airports_id TO departure_airports_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE flights ADD CONSTRAINT FK_FC74B5EA855A9151 FOREIGN KEY (departure_airports_id) REFERENCES airports (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE flights ADD CONSTRAINT FK_FC74B5EA8DBEEEC FOREIGN KEY (arrival_airports_id) REFERENCES airports (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_FC74B5EA855A9151 ON flights (departure_airports_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_FC74B5EA8DBEEEC ON flights (arrival_airports_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE flights DROP CONSTRAINT FK_FC74B5EA855A9151
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE flights DROP CONSTRAINT FK_FC74B5EA8DBEEEC
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_FC74B5EA855A9151
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_FC74B5EA8DBEEEC
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE flights ADD airports_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE flights DROP departure_airports_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE flights DROP arrival_airports_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE flights ADD CONSTRAINT fk_fc74b5eaf47ae723 FOREIGN KEY (airports_id) REFERENCES airports (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX idx_fc74b5eaf47ae723 ON flights (airports_id)
        SQL);
    }
}
