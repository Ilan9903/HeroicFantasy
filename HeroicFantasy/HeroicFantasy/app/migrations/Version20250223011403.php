<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250223011403 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quest DROP FOREIGN KEY FK_4317F8179E4C72FE');
        $this->addSql('DROP INDEX UNIQ_4317F8179E4C72FE ON quest');
        $this->addSql('ALTER TABLE quest ADD reward_id INT NOT NULL, DROP reward_entity_id, DROP reward');
        $this->addSql('ALTER TABLE quest ADD CONSTRAINT FK_4317F817E466ACA1 FOREIGN KEY (reward_id) REFERENCES reward (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4317F817E466ACA1 ON quest (reward_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quest DROP FOREIGN KEY FK_4317F817E466ACA1');
        $this->addSql('DROP INDEX UNIQ_4317F817E466ACA1 ON quest');
        $this->addSql('ALTER TABLE quest ADD reward INT NOT NULL, CHANGE reward_id reward_entity_id INT NOT NULL');
        $this->addSql('ALTER TABLE quest ADD CONSTRAINT FK_4317F8179E4C72FE FOREIGN KEY (reward_entity_id) REFERENCES reward (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4317F8179E4C72FE ON quest (reward_entity_id)');
    }
}
