<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250223095940 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD selected_hero_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649EC1F7553 FOREIGN KEY (selected_hero_id) REFERENCES hero (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649EC1F7553 ON user (selected_hero_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649EC1F7553');
        $this->addSql('DROP INDEX IDX_8D93D649EC1F7553 ON `user`');
        $this->addSql('ALTER TABLE `user` DROP selected_hero_id');
    }
}
