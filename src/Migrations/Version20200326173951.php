<?php

declare(strict_types=1);

/*
 * This file is part of the Rim Edu application.
 *
 * By Bechir Ba and contributors
 */

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200326173951 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('sqlite' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_169E6FB923EDC87');
        $this->addSql('CREATE TEMPORARY TABLE __temp__course AS SELECT id, subject_id, title, video_url FROM course');
        $this->addSql('DROP TABLE course');
        $this->addSql('CREATE TABLE course (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, subject_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, video_url VARCHAR(255) DEFAULT NULL COLLATE BINARY, added_at DATETIME NOT NULL, CONSTRAINT FK_169E6FB923EDC87 FOREIGN KEY (subject_id) REFERENCES subject (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO course (id, subject_id, title, video_url) SELECT id, subject_id, title, video_url FROM __temp__course');
        $this->addSql('DROP TABLE __temp__course');
        $this->addSql('CREATE INDEX IDX_169E6FB923EDC87 ON course (subject_id)');
        $this->addSql('DROP INDEX IDX_8F87BF965FB14BA7');
        $this->addSql('CREATE TEMPORARY TABLE __temp__classe AS SELECT id, level_id, name FROM classe');
        $this->addSql('DROP TABLE classe');
        $this->addSql('CREATE TABLE classe (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, level_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_8F87BF965FB14BA7 FOREIGN KEY (level_id) REFERENCES class_level (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO classe (id, level_id, name) SELECT id, level_id, name FROM __temp__classe');
        $this->addSql('DROP TABLE __temp__classe');
        $this->addSql('CREATE INDEX IDX_8F87BF965FB14BA7 ON classe (level_id)');
        $this->addSql('DROP INDEX IDX_FBCE3E7A43B46646');
        $this->addSql('CREATE TEMPORARY TABLE __temp__subject AS SELECT id, course_class_id, name, coef FROM subject');
        $this->addSql('DROP TABLE subject');
        $this->addSql('CREATE TABLE subject (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, class_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, coef INTEGER NOT NULL, CONSTRAINT FK_FBCE3E7AEA000B10 FOREIGN KEY (class_id) REFERENCES classe (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO subject (id, class_id, name, coef) SELECT id, course_class_id, name, coef FROM __temp__subject');
        $this->addSql('DROP TABLE __temp__subject');
        $this->addSql('CREATE INDEX IDX_FBCE3E7AEA000B10 ON subject (class_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('sqlite' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_8F87BF965FB14BA7');
        $this->addSql('CREATE TEMPORARY TABLE __temp__classe AS SELECT id, level_id, name FROM classe');
        $this->addSql('DROP TABLE classe');
        $this->addSql('CREATE TABLE classe (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, level_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO classe (id, level_id, name) SELECT id, level_id, name FROM __temp__classe');
        $this->addSql('DROP TABLE __temp__classe');
        $this->addSql('CREATE INDEX IDX_8F87BF965FB14BA7 ON classe (level_id)');
        $this->addSql('DROP INDEX IDX_169E6FB923EDC87');
        $this->addSql('CREATE TEMPORARY TABLE __temp__course AS SELECT id, subject_id, title, video_url FROM course');
        $this->addSql('DROP TABLE course');
        $this->addSql('CREATE TABLE course (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, subject_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, video_url VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO course (id, subject_id, title, video_url) SELECT id, subject_id, title, video_url FROM __temp__course');
        $this->addSql('DROP TABLE __temp__course');
        $this->addSql('CREATE INDEX IDX_169E6FB923EDC87 ON course (subject_id)');
        $this->addSql('DROP INDEX IDX_FBCE3E7AEA000B10');
        $this->addSql('CREATE TEMPORARY TABLE __temp__subject AS SELECT id, class_id, name, coef FROM subject');
        $this->addSql('DROP TABLE subject');
        $this->addSql('CREATE TABLE subject (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, coef INTEGER NOT NULL, course_class_id INTEGER NOT NULL)');
        $this->addSql('INSERT INTO subject (id, course_class_id, name, coef) SELECT id, class_id, name, coef FROM __temp__subject');
        $this->addSql('DROP TABLE __temp__subject');
        $this->addSql('CREATE INDEX IDX_FBCE3E7A43B46646 ON subject (course_class_id)');
    }
}