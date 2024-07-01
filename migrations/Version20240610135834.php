<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240610135834 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD default_adress_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6495550F8FB FOREIGN KEY (default_adress_id_id) REFERENCES address (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6495550F8FB ON user (default_adress_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6495550F8FB');
        $this->addSql('DROP INDEX IDX_8D93D6495550F8FB ON user');
        $this->addSql('ALTER TABLE user DROP default_adress_id_id');
    }
}
