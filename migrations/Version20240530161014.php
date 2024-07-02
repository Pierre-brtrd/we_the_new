<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240530161014 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product_association (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, associated_product_id INT NOT NULL, INDEX IDX_51AABFD34584665A (product_id), INDEX IDX_51AABFD3AE33471B (associated_product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product_association ADD CONSTRAINT FK_51AABFD34584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product_association ADD CONSTRAINT FK_51AABFD3AE33471B FOREIGN KEY (associated_product_id) REFERENCES product (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_association DROP FOREIGN KEY FK_51AABFD34584665A');
        $this->addSql('ALTER TABLE product_association DROP FOREIGN KEY FK_51AABFD3AE33471B');
        $this->addSql('DROP TABLE product_association');
    }
}
