<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260725000001CreateClinicalContributions extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create clinical_contributions table — Aggregate persistence store for ClinicalContribution';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            CREATE TABLE clinical_contributions (
                id                           UUID         NOT NULL,
                care_record_id               UUID         NOT NULL,
                status                       VARCHAR(30)  NOT NULL,
                clinical_text                TEXT         NOT NULL,
                recorded_at                  TIMESTAMPTZ  NOT NULL,
                contributing_practitioner_id UUID         NOT NULL,
                contributor_role             VARCHAR(50)  NOT NULL,
                approving_practitioner_id    UUID         DEFAULT NULL,
                approved_at                  TIMESTAMPTZ  DEFAULT NULL,
                created_at                   TIMESTAMPTZ  NOT NULL DEFAULT NOW(),
                updated_at                   TIMESTAMPTZ  NOT NULL DEFAULT NOW(),
                PRIMARY KEY (id)
            )
        SQL);

        $this->addSql(<<<'SQL'
            CREATE INDEX idx_clinical_contributions_care_record
                ON clinical_contributions (care_record_id)
        SQL);

        $this->addSql(<<<'SQL'
            CREATE INDEX idx_clinical_contributions_status
                ON clinical_contributions (status)
        SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE clinical_contributions');
    }
}
