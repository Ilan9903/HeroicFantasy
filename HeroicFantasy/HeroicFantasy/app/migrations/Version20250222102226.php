<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250222102226 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hero DROP FOREIGN KEY FK_51CE6E86BDE6E4DE');
        $this->addSql('DROP INDEX IDX_51CE6E86BDE6E4DE ON hero');
        $this->addSql('ALTER TABLE hero DROP current_quest_id, CHANGE class class VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hero ADD current_quest_id INT DEFAULT NULL, CHANGE class class VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE hero ADD CONSTRAINT FK_51CE6E86BDE6E4DE FOREIGN KEY (current_quest_id) REFERENCES quest (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_51CE6E86BDE6E4DE ON hero (current_quest_id)');
    }
}
