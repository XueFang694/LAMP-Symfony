<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200309225255 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE category_entity (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_entity (id INT AUTO_INCREMENT NOT NULL, category_entity_id INT NOT NULL, label VARCHAR(255) NOT NULL, network_dependencies LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', documentation LONGTEXT NOT NULL, inputs LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', INDEX IDX_198CAF224645AF6D (category_entity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE project_entity ADD CONSTRAINT FK_198CAF224645AF6D FOREIGN KEY (category_entity_id) REFERENCES category_entity (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE project_entity DROP FOREIGN KEY FK_198CAF224645AF6D');
        $this->addSql('DROP TABLE category_entity');
        $this->addSql('DROP TABLE project_entity');
    }
}
