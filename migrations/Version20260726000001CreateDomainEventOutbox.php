<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Creates the domain_event_outbox table per ADR-SA-013 §5.4.
 *
 * Outbox pattern guarantees atomicity: the Aggregate write and the Outbox write
 * share the same PostgreSQL transaction. The Worker publishes asynchronously after COMMIT.
 *
 * Index strategy (ADR-SA-013 R-035 / ADR-SA-011):
 *   - idx_outbox_status_occurred_at: primary processing index for the Worker
 *     (pending rows ordered by time — Keyset pagination ready).
 *   - event_id is UNIQUE: idempotent UPSERT guard (R-032).
 *
 * Supersedes the Outbox schema placeholder in ADR-SA-010 §4.
 */
final class Version20260726000001CreateDomainEventOutbox extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create domain_event_outbox table (ADR-SA-013 §5.4)';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            CREATE TABLE domain_event_outbox (
                event_id        UUID        NOT NULL,
                aggregate_id    UUID        NOT NULL,
                aggregate_type  VARCHAR(100) NOT NULL,
                aggregate_version INTEGER   NULL,
                event_type      VARCHAR(150) NOT NULL,
                event_version   VARCHAR(20)  NOT NULL,
                platform_id     VARCHAR(50)  NOT NULL,
                occurred_at     TIMESTAMPTZ NOT NULL,
                correlation_id  UUID        NOT NULL,
                causation_id    UUID        NOT NULL,
                metadata        JSONB       NOT NULL DEFAULT '{}',
                payload         JSONB       NOT NULL,
                status          VARCHAR(20) NOT NULL DEFAULT 'pending',
                published_at    TIMESTAMPTZ NULL,
                created_at      TIMESTAMPTZ NOT NULL DEFAULT NOW(),

                CONSTRAINT pk_domain_event_outbox PRIMARY KEY (event_id),
                CONSTRAINT chk_outbox_status CHECK (status IN ('pending', 'published', 'failed'))
            )
        SQL);

        $this->addSql(<<<'SQL'
            CREATE INDEX idx_outbox_status_occurred_at
                ON domain_event_outbox (status, occurred_at)
                WHERE status = 'pending'
        SQL);

        $this->addSql(<<<'SQL'
            CREATE INDEX idx_outbox_aggregate
                ON domain_event_outbox (aggregate_type, aggregate_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS domain_event_outbox');
    }
}
