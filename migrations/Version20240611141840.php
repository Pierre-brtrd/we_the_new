<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240611141840 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE shipping (id INT AUTO_INCREMENT NOT NULL, order_ref_id INT NOT NULL, delivery_id INT NOT NULL, status VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_2D1C1724E238517C (order_ref_id), INDEX IDX_2D1C172412136921 (delivery_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE shipping ADD CONSTRAINT FK_2D1C1724E238517C FOREIGN KEY (order_ref_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE shipping ADD CONSTRAINT FK_2D1C172412136921 FOREIGN KEY (delivery_id) REFERENCES delivery (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE shipping DROP FOREIGN KEY FK_2D1C1724E238517C');
        $this->addSql('ALTER TABLE shipping DROP FOREIGN KEY FK_2D1C172412136921');
        $this->addSql('DROP TABLE shipping');
    }
}
