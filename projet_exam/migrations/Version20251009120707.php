<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251009120707 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, center_id INT DEFAULT NULL, imege_id INT NOT NULL, path VARCHAR(255) NOT NULL, INDEX IDX_C53D045F5932F377 (center_id), INDEX IDX_C53D045FA634677B (imege_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F5932F377 FOREIGN KEY (center_id) REFERENCES center (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FA634677B FOREIGN KEY (imege_id) REFERENCES center (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F5932F377');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FA634677B');
        $this->addSql('DROP TABLE image');
    }
}
