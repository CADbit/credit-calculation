<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241202091051 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE loan (hid VARCHAR(36) NOT NULL, installments INTEGER NOT NULL, amount INTEGER NOT NULL, rrso NUMERIC(15, 2) NOT NULL, create_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , exclude BOOLEAN DEFAULT NULL, PRIMARY KEY(hid))');
        $this->addSql('CREATE TABLE loan_schedules (hid VARCHAR(36) NOT NULL, loan_hid VARCHAR(36) NOT NULL, installment_number INTEGER NOT NULL, installment_amount NUMERIC(15, 2) NOT NULL, interest_amount NUMERIC(15, 2) NOT NULL, principal_amount NUMERIC(15, 2) NOT NULL, PRIMARY KEY(hid), CONSTRAINT FK_7068E0145178B381 FOREIGN KEY (loan_hid) REFERENCES loan (hid) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_7068E0145178B381 ON loan_schedules (loan_hid)');
        $this->addSql('CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , available_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , delivered_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE loan');
        $this->addSql('DROP TABLE loan_schedules');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
