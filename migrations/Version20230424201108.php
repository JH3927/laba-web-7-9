<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230424201108 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comments RENAME INDEX idx_5f9e962abd06b3b3 TO IDX_5F9E962A458B4EB8');
        $this->addSql('ALTER TABLE news DROP FOREIGN KEY news_ibfk_1');
        $this->addSql('ALTER TABLE news ADD CONSTRAINT FK_1DD39950A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE news RENAME INDEX user_id TO IDX_1DD39950A76ED395');
        $this->addSql('ALTER TABLE user ADD api_token VARCHAR(510) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comments RENAME INDEX idx_5f9e962a458b4eb8 TO IDX_5F9E962ABD06B3B3');
        $this->addSql('ALTER TABLE news DROP FOREIGN KEY FK_1DD39950A76ED395');
        $this->addSql('ALTER TABLE news ADD CONSTRAINT news_ibfk_1 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE news RENAME INDEX idx_1dd39950a76ed395 TO user_id');
        $this->addSql('ALTER TABLE user DROP api_token');
    }
}
