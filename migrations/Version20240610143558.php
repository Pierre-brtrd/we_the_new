<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240610143558 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE address_address (address_source INT NOT NULL, address_target INT NOT NULL, INDEX IDX_56AB981964D3FACC (address_source), INDEX IDX_56AB98197D36AA43 (address_target), PRIMARY KEY(address_source, address_target)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE address_address ADD CONSTRAINT FK_56AB981964D3FACC FOREIGN KEY (address_source) REFERENCES address (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE address_address ADD CONSTRAINT FK_56AB98197D36AA43 FOREIGN KEY (address_target) REFERENCES address (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE address_address DROP FOREIGN KEY FK_56AB981964D3FACC');
        $this->addSql('ALTER TABLE address_address DROP FOREIGN KEY FK_56AB98197D36AA43');
        $this->addSql('DROP TABLE address_address');
    }
}
