<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240610143815 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, address VARCHAR(255) NOT NULL, zip_code VARCHAR(5) NOT NULL, city VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE address_user (address_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_F0DF06A2F5B7AF75 (address_id), INDEX IDX_F0DF06A2A76ED395 (user_id), PRIMARY KEY(address_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE address_user ADD CONSTRAINT FK_F0DF06A2F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE address_user ADD CONSTRAINT FK_F0DF06A2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD default_address_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649BD94FB16 FOREIGN KEY (default_address_id) REFERENCES address (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649BD94FB16 ON user (default_address_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649BD94FB16');
        $this->addSql('ALTER TABLE address_user DROP FOREIGN KEY FK_F0DF06A2F5B7AF75');
        $this->addSql('ALTER TABLE address_user DROP FOREIGN KEY FK_F0DF06A2A76ED395');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE address_user');
        $this->addSql('DROP INDEX IDX_8D93D649BD94FB16 ON user');
        $this->addSql('ALTER TABLE user DROP default_address_id');
    }
}
