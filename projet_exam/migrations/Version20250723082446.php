<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250723082446 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE center_activity (center_id INT NOT NULL, activity_id INT NOT NULL, INDEX IDX_E83596175932F377 (center_id), INDEX IDX_E835961781C06096 (activity_id), PRIMARY KEY(center_id, activity_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE center_activity ADD CONSTRAINT FK_E83596175932F377 FOREIGN KEY (center_id) REFERENCES center (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE center_activity ADD CONSTRAINT FK_E835961781C06096 FOREIGN KEY (activity_id) REFERENCES activity (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE center_activity DROP FOREIGN KEY FK_E83596175932F377');
        $this->addSql('ALTER TABLE center_activity DROP FOREIGN KEY FK_E835961781C06096');
        $this->addSql('DROP TABLE center_activity');
    }
}
