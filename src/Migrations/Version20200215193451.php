<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200215193451 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE usuario (id INT AUTO_INCREMENT NOT NULL, user VARCHAR(255) NOT NULL, pass VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, rol VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE taller (id INT AUTO_INCREMENT NOT NULL, categoriataller_id INT NOT NULL, titulota VARCHAR(255) NOT NULL, liketa INT NOT NULL, INDEX IDX_139F4584726FE79A (categoriataller_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categoriaponencia (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categoriataller (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ponencia (id INT AUTO_INCREMENT NOT NULL, categoriaponencia_id INT NOT NULL, titulopo VARCHAR(255) NOT NULL, likepo INT NOT NULL, INDEX IDX_C842908B9C369A94 (categoriaponencia_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE taller ADD CONSTRAINT FK_139F4584726FE79A FOREIGN KEY (categoriataller_id) REFERENCES categoriataller (id)');
        $this->addSql('ALTER TABLE ponencia ADD CONSTRAINT FK_C842908B9C369A94 FOREIGN KEY (categoriaponencia_id) REFERENCES categoriaponencia (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ponencia DROP FOREIGN KEY FK_C842908B9C369A94');
        $this->addSql('ALTER TABLE taller DROP FOREIGN KEY FK_139F4584726FE79A');
        $this->addSql('DROP TABLE usuario');
        $this->addSql('DROP TABLE taller');
        $this->addSql('DROP TABLE categoriaponencia');
        $this->addSql('DROP TABLE categoriataller');
        $this->addSql('DROP TABLE ponencia');
    }
}
