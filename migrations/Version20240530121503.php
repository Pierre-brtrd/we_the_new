<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240530121503 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE taxe (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, rate DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product_variant ADD taxe_id INT NOT NULL');
        $this->addSql('ALTER TABLE product_variant ADD CONSTRAINT FK_209AA41D1AB947A4 FOREIGN KEY (taxe_id) REFERENCES taxe (id)');
        $this->addSql('CREATE INDEX IDX_209AA41D1AB947A4 ON product_variant (taxe_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_variant DROP FOREIGN KEY FK_209AA41D1AB947A4');
        $this->addSql('DROP TABLE taxe');
        $this->addSql('DROP INDEX IDX_209AA41D1AB947A4 ON product_variant');
        $this->addSql('ALTER TABLE product_variant DROP taxe_id');
    }
}
