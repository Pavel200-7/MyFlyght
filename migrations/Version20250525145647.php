<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250525145647 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE aircraft DROP CONSTRAINT FK_13D967295C500FC6
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE aircraft ADD CONSTRAINT FK_13D967295C500FC6 FOREIGN KEY (Airline_id) REFERENCES airline (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE baggage_politicy_rate DROP CONSTRAINT FK_BC7DE6C45C500FC6
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE baggage_politicy_rate ADD CONSTRAINT FK_BC7DE6C45C500FC6 FOREIGN KEY (Airline_id) REFERENCES airline (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE plane_class_rate DROP CONSTRAINT FK_27DFE005C500FC6
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE plane_class_rate ADD CONSTRAINT FK_27DFE005C500FC6 FOREIGN KEY (Airline_id) REFERENCES airline (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE baggage_politicy_rate DROP CONSTRAINT fk_bc7de6c45c500fc6
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE baggage_politicy_rate ADD CONSTRAINT fk_bc7de6c45c500fc6 FOREIGN KEY (airline_id) REFERENCES airline (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE aircraft DROP CONSTRAINT fk_13d967295c500fc6
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE aircraft ADD CONSTRAINT fk_13d967295c500fc6 FOREIGN KEY (airline_id) REFERENCES airline (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE plane_class_rate DROP CONSTRAINT fk_27dfe005c500fc6
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE plane_class_rate ADD CONSTRAINT fk_27dfe005c500fc6 FOREIGN KEY (airline_id) REFERENCES airline (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }
}
