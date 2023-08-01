<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230801162259 extends AbstractMigration
{
    private const DESCRIPTION = 'Add metrics and logs tables';

    public function getDescription(): string
    {
        return self::DESCRIPTION;
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE log_entries (id UUID NOT NULL, log_id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, source VARCHAR(255) NOT NULL, context JSONB DEFAULT \'{}\' NOT NULL, attributes JSONB DEFAULT \'{}\' NOT NULL, tags JSONB DEFAULT \'[]\' NOT NULL, occurred_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_15358B52EA675D86 ON log_entries (log_id)');
        $this->addSql('COMMENT ON COLUMN log_entries.id IS \'(DC2Type:ulid)\'');
        $this->addSql('COMMENT ON COLUMN log_entries.log_id IS \'(DC2Type:ulid)\'');
        $this->addSql('COMMENT ON COLUMN log_entries.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN log_entries.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN log_entries.occurred_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE logs (id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, namespace VARCHAR(255) NOT NULL, level INT NOT NULL, template TEXT NOT NULL, first_entry_occurred_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, last_entry_occurred_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX message_namespace_level_template_unique ON logs (namespace, level, template)');
        $this->addSql('COMMENT ON COLUMN logs.id IS \'(DC2Type:ulid)\'');
        $this->addSql('COMMENT ON COLUMN logs.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN logs.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN logs.first_entry_occurred_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN logs.last_entry_occurred_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE metric_data_points (id UUID NOT NULL, metric_id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, source VARCHAR(255) NOT NULL, start_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, attributes JSONB DEFAULT \'{}\' NOT NULL, discriminator VARCHAR(255) NOT NULL, value DOUBLE PRECISION DEFAULT NULL, lower_bound DOUBLE PRECISION DEFAULT NULL, upper_bound DOUBLE PRECISION DEFAULT NULL, count INT DEFAULT NULL, summation DOUBLE PRECISION DEFAULT NULL, minimum DOUBLE PRECISION DEFAULT NULL, maximum DOUBLE PRECISION DEFAULT NULL, bucket_counts JSONB DEFAULT \'{}\', bucket_boundaries JSONB DEFAULT \'{}\', PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_A223EA8FA952D583 ON metric_data_points (metric_id)');
        $this->addSql('COMMENT ON COLUMN metric_data_points.id IS \'(DC2Type:ulid)\'');
        $this->addSql('COMMENT ON COLUMN metric_data_points.metric_id IS \'(DC2Type:ulid)\'');
        $this->addSql('COMMENT ON COLUMN metric_data_points.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN metric_data_points.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN metric_data_points.start_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN metric_data_points.end_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE metrics (id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, namespace VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, unit VARCHAR(255) DEFAULT NULL, discriminator VARCHAR(255) NOT NULL, temporality VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX metric_namespace_name_discriminator_unique ON metrics (namespace, name, discriminator)');
        $this->addSql('COMMENT ON COLUMN metrics.id IS \'(DC2Type:ulid)\'');
        $this->addSql('COMMENT ON COLUMN metrics.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN metrics.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE log_entries ADD CONSTRAINT FK_15358B52EA675D86 FOREIGN KEY (log_id) REFERENCES logs (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE metric_data_points ADD CONSTRAINT FK_A223EA8FA952D583 FOREIGN KEY (metric_id) REFERENCES metrics (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE log_entries DROP CONSTRAINT FK_15358B52EA675D86');
        $this->addSql('ALTER TABLE metric_data_points DROP CONSTRAINT FK_A223EA8FA952D583');
        $this->addSql('DROP TABLE log_entries');
        $this->addSql('DROP TABLE logs');
        $this->addSql('DROP TABLE metric_data_points');
        $this->addSql('DROP TABLE metrics');
    }
}
