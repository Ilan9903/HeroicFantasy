<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250214232748 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reward (id INT AUTO_INCREMENT NOT NULL, amount INT NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE hero ADD current_quest_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE hero ADD CONSTRAINT FK_51CE6E86BDE6E4DE FOREIGN KEY (current_quest_id) REFERENCES quest (id)');
        $this->addSql('CREATE INDEX IDX_51CE6E86BDE6E4DE ON hero (current_quest_id)');
        $this->addSql('ALTER TABLE quest ADD reward_entity_id INT NOT NULL');
        $this->addSql('ALTER TABLE quest ADD CONSTRAINT FK_4317F8179E4C72FE FOREIGN KEY (reward_entity_id) REFERENCES reward (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4317F8179E4C72FE ON quest (reward_entity_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quest DROP FOREIGN KEY FK_4317F8179E4C72FE');
        $this->addSql('DROP TABLE reward');
        $this->addSql('DROP INDEX UNIQ_4317F8179E4C72FE ON quest');
        $this->addSql('ALTER TABLE quest DROP reward_entity_id');
        $this->addSql('ALTER TABLE hero DROP FOREIGN KEY FK_51CE6E86BDE6E4DE');
        $this->addSql('DROP INDEX IDX_51CE6E86BDE6E4DE ON hero');
        $this->addSql('ALTER TABLE hero DROP current_quest_id');
    }
}
