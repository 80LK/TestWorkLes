<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211029102558 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE delivery (id SERIAL NOT NULL, provider_id INT NOT NULL, wood_species_id INT NOT NULL, volume DOUBLE PRECISION NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, note VARCHAR(1000) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3781EC10A53A8AA ON delivery (provider_id)');
        $this->addSql('CREATE INDEX IDX_3781EC10287D2C66 ON delivery (wood_species_id)');
        $this->addSql('ALTER TABLE delivery ADD CONSTRAINT FK_3781EC10A53A8AA FOREIGN KEY (provider_id) REFERENCES provider (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE delivery ADD CONSTRAINT FK_3781EC10287D2C66 FOREIGN KEY (wood_species_id) REFERENCES wood_species (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE delivery');
    }
}
