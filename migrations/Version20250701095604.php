<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250701095604 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fleets (user_id VARCHAR(255) NOT NULL, PRIMARY KEY(user_id))');
        $this->addSql('CREATE TABLE fleet_vehicles (fleet_id VARCHAR(255) NOT NULL, vehicle_id VARCHAR(255) NOT NULL, PRIMARY KEY(fleet_id, vehicle_id), CONSTRAINT FK_883AE2494B061DF9 FOREIGN KEY (fleet_id) REFERENCES fleets (user_id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_883AE249545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicles (plate_number) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_883AE2494B061DF9 ON fleet_vehicles (fleet_id)');
        $this->addSql('CREATE INDEX IDX_883AE249545317D1 ON fleet_vehicles (vehicle_id)');
        $this->addSql('CREATE TABLE vehicles (plate_number VARCHAR(255) NOT NULL, location_latitude DOUBLE PRECISION DEFAULT NULL, location_longitude DOUBLE PRECISION DEFAULT NULL, location_altitude DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(plate_number))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE fleets');
        $this->addSql('DROP TABLE fleet_vehicles');
        $this->addSql('DROP TABLE vehicles');
    }
}
