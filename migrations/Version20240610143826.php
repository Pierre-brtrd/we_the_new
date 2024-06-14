<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240610143826 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adress (id INT AUTO_INCREMENT NOT NULL, address VARCHAR(255) NOT NULL, zip_code VARCHAR(5) NOT NULL, city VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE adress_user (adress_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_222DFD048486F9AC (adress_id), INDEX IDX_222DFD04A76ED395 (user_id), PRIMARY KEY(adress_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE adress_user ADD CONSTRAINT FK_222DFD048486F9AC FOREIGN KEY (adress_id) REFERENCES adress (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE adress_user ADD CONSTRAINT FK_222DFD04A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD defaultaddressid_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D5639FEF FOREIGN KEY (defaultaddressid_id) REFERENCES adress (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649D5639FEF ON user (defaultaddressid_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D5639FEF');
        $this->addSql('ALTER TABLE adress_user DROP FOREIGN KEY FK_222DFD048486F9AC');
        $this->addSql('ALTER TABLE adress_user DROP FOREIGN KEY FK_222DFD04A76ED395');
        $this->addSql('DROP TABLE adress');
        $this->addSql('DROP TABLE adress_user');
        $this->addSql('DROP INDEX IDX_8D93D649D5639FEF ON user');
        $this->addSql('ALTER TABLE user DROP defaultaddressid_id');
    }
}
