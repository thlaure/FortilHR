<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240513122836 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE form_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE human_resources_form_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE human_resources_form (id INT NOT NULL, title VARCHAR(255) NOT NULL, link VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE notification_human_resources_form (notification_id INT NOT NULL, human_resources_form_id INT NOT NULL, PRIMARY KEY(notification_id, human_resources_form_id))');
        $this->addSql('CREATE INDEX IDX_30EBF1B7EF1A9D84 ON notification_human_resources_form (notification_id)');
        $this->addSql('CREATE INDEX IDX_30EBF1B7E1BA6773 ON notification_human_resources_form (human_resources_form_id)');
        $this->addSql('ALTER TABLE notification_human_resources_form ADD CONSTRAINT FK_30EBF1B7EF1A9D84 FOREIGN KEY (notification_id) REFERENCES notification (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE notification_human_resources_form ADD CONSTRAINT FK_30EBF1B7E1BA6773 FOREIGN KEY (human_resources_form_id) REFERENCES human_resources_form (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE notification_form DROP CONSTRAINT fk_eab4b675ef1a9d84');
        $this->addSql('ALTER TABLE notification_form DROP CONSTRAINT fk_eab4b6755ff69b7d');
        $this->addSql('DROP TABLE form');
        $this->addSql('DROP TABLE notification_form');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE human_resources_form_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE form_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE form (id INT NOT NULL, title VARCHAR(255) NOT NULL, link VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE notification_form (notification_id INT NOT NULL, form_id INT NOT NULL, PRIMARY KEY(notification_id, form_id))');
        $this->addSql('CREATE INDEX idx_eab4b6755ff69b7d ON notification_form (form_id)');
        $this->addSql('CREATE INDEX idx_eab4b675ef1a9d84 ON notification_form (notification_id)');
        $this->addSql('ALTER TABLE notification_form ADD CONSTRAINT fk_eab4b675ef1a9d84 FOREIGN KEY (notification_id) REFERENCES notification (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE notification_form ADD CONSTRAINT fk_eab4b6755ff69b7d FOREIGN KEY (form_id) REFERENCES form (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE notification_human_resources_form DROP CONSTRAINT FK_30EBF1B7EF1A9D84');
        $this->addSql('ALTER TABLE notification_human_resources_form DROP CONSTRAINT FK_30EBF1B7E1BA6773');
        $this->addSql('DROP TABLE human_resources_form');
        $this->addSql('DROP TABLE notification_human_resources_form');
    }
}
