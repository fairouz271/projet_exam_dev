<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250731151341 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_center (user_id INT NOT NULL, center_id INT NOT NULL, INDEX IDX_25A2F019A76ED395 (user_id), INDEX IDX_25A2F0195932F377 (center_id), PRIMARY KEY(user_id, center_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_center ADD CONSTRAINT FK_25A2F019A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_center ADD CONSTRAINT FK_25A2F0195932F377 FOREIGN KEY (center_id) REFERENCES center (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_center DROP FOREIGN KEY FK_25A2F019A76ED395');
        $this->addSql('ALTER TABLE user_center DROP FOREIGN KEY FK_25A2F0195932F377');
        $this->addSql('DROP TABLE user_center');
    }
}
