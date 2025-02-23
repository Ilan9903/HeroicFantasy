<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250223004137 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hero DROP INDEX IDX_51CE6E86BDE6E4DE, ADD UNIQUE INDEX UNIQ_51CE6E86BDE6E4DE (current_quest_id)');
        $this->addSql('ALTER TABLE hero CHANGE class class VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE quest ADD hero_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE quest ADD CONSTRAINT FK_4317F81745B0BCD FOREIGN KEY (hero_id) REFERENCES hero (id)');
        $this->addSql('CREATE INDEX IDX_4317F81745B0BCD ON quest (hero_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hero DROP INDEX UNIQ_51CE6E86BDE6E4DE, ADD INDEX IDX_51CE6E86BDE6E4DE (current_quest_id)');
        $this->addSql('ALTER TABLE hero CHANGE class class VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE quest DROP FOREIGN KEY FK_4317F81745B0BCD');
        $this->addSql('DROP INDEX IDX_4317F81745B0BCD ON quest');
        $this->addSql('ALTER TABLE quest DROP hero_id');
    }
}
