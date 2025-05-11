<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250511081105 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE airports ALTER longtitude TYPE NUMERIC(10, 6)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE airports ALTER latitude TYPE NUMERIC(10, 6)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE airports ALTER longtitude TYPE NUMERIC(10, 0)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE airports ALTER latitude TYPE NUMERIC(10, 0)
        SQL);
    }
}
