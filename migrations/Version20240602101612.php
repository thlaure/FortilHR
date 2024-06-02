<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240602101612 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE document_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE event_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE human_resources_form_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE notification_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE document (id INT NOT NULL, title VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE event (id INT NOT NULL, name VARCHAR(255) NOT NULL, start_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, image_name VARCHAR(255) DEFAULT NULL, program TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE human_resources_form (id INT NOT NULL, title VARCHAR(255) NOT NULL, link VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE notification (id INT NOT NULL, title VARCHAR(255) NOT NULL, message TEXT NOT NULL, send_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, is_read BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE notification_document (notification_id INT NOT NULL, document_id INT NOT NULL, PRIMARY KEY(notification_id, document_id))');
        $this->addSql('CREATE INDEX IDX_8D79B2D3EF1A9D84 ON notification_document (notification_id)');
        $this->addSql('CREATE INDEX IDX_8D79B2D3C33F7837 ON notification_document (document_id)');
        $this->addSql('CREATE TABLE notification_human_resources_form (notification_id INT NOT NULL, human_resources_form_id INT NOT NULL, PRIMARY KEY(notification_id, human_resources_form_id))');
        $this->addSql('CREATE INDEX IDX_30EBF1B7EF1A9D84 ON notification_human_resources_form (notification_id)');
        $this->addSql('CREATE INDEX IDX_30EBF1B7E1BA6773 ON notification_human_resources_form (human_resources_form_id)');
        $this->addSql('ALTER TABLE notification_document ADD CONSTRAINT FK_8D79B2D3EF1A9D84 FOREIGN KEY (notification_id) REFERENCES notification (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE notification_document ADD CONSTRAINT FK_8D79B2D3C33F7837 FOREIGN KEY (document_id) REFERENCES document (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE notification_human_resources_form ADD CONSTRAINT FK_30EBF1B7EF1A9D84 FOREIGN KEY (notification_id) REFERENCES notification (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE notification_human_resources_form ADD CONSTRAINT FK_30EBF1B7E1BA6773 FOREIGN KEY (human_resources_form_id) REFERENCES human_resources_form (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE document_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE event_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE human_resources_form_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE notification_id_seq CASCADE');
        $this->addSql('ALTER TABLE notification_document DROP CONSTRAINT FK_8D79B2D3EF1A9D84');
        $this->addSql('ALTER TABLE notification_document DROP CONSTRAINT FK_8D79B2D3C33F7837');
        $this->addSql('ALTER TABLE notification_human_resources_form DROP CONSTRAINT FK_30EBF1B7EF1A9D84');
        $this->addSql('ALTER TABLE notification_human_resources_form DROP CONSTRAINT FK_30EBF1B7E1BA6773');
        $this->addSql('DROP TABLE document');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE human_resources_form');
        $this->addSql('DROP TABLE notification');
        $this->addSql('DROP TABLE notification_document');
        $this->addSql('DROP TABLE notification_human_resources_form');
    }
}
