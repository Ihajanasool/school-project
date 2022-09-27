<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220808174626 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE class_subject ADD CONSTRAINT FK_3EBB5986BDDFA3C9 FOREIGN KEY (profs_id) REFERENCES scolarite (id)');
        $this->addSql('ALTER TABLE class_subject ADD CONSTRAINT FK_3EBB598623EDC87 FOREIGN KEY (subject_id) REFERENCES subject (id)');
        $this->addSql('ALTER TABLE ecolage ADD CONSTRAINT FK_FE61A04FCB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE emploi_du_temps ADD CONSTRAINT FK_F86B32C18F5EA509 FOREIGN KEY (classe_id) REFERENCES class_room (id)');
        $this->addSql('ALTER TABLE emploi_du_temps ADD CONSTRAINT FK_F86B32C1F46CD258 FOREIGN KEY (matiere_id) REFERENCES subject (id)');
        $this->addSql('ALTER TABLE history ADD CONSTRAINT FK_27BA704BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE history ADD CONSTRAINT FK_27BA704BB4F74015 FOREIGN KEY (user_act_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495554177093 FOREIGN KEY (room_id) REFERENCES room (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955D2EECC3F FOREIGN KEY (school_year_id) REFERENCES school_year (id)');
        $this->addSql('ALTER TABLE reservation_user ADD CONSTRAINT FK_9BAA1B21B83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation_user ADD CONSTRAINT FK_9BAA1B21A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE scolarite ADD school_year_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', ADD deletedAt DATETIME DEFAULT NULL, ADD diplome VARCHAR(100) DEFAULT NULL, ADD cin VARCHAR(50) DEFAULT NULL, ADD date_cin DATETIME DEFAULT NULL, ADD lieu_cin VARCHAR(50) DEFAULT NULL, ADD num_ae VARCHAR(150) DEFAULT NULL, ADD note_libre VARCHAR(255) DEFAULT NULL, ADD ets_name VARCHAR(255) DEFAULT NULL, ADD ets_logo VARCHAR(255) DEFAULT NULL, ADD ets_hash_name VARCHAR(255) DEFAULT NULL, CHANGE id id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', CHANGE type_id type_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', CHANGE user_id user_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', CHANGE salaires salary VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE scolarite ADD CONSTRAINT FK_276250ABC54C8C93 FOREIGN KEY (type_id) REFERENCES scolarite_type (id)');
        $this->addSql('ALTER TABLE scolarite ADD CONSTRAINT FK_276250ABA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE scolarite ADD CONSTRAINT FK_276250ABD2EECC3F FOREIGN KEY (school_year_id) REFERENCES school_year (id)');
        $this->addSql('CREATE INDEX IDX_276250ABD2EECC3F ON scolarite (school_year_id)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D4D2EECC3F FOREIGN KEY (school_year_id) REFERENCES school_year (id)');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF33A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF338F5EA509 FOREIGN KEY (classe_id) REFERENCES class_room (id)');
        $this->addSql('ALTER TABLE student_note ADD CONSTRAINT FK_F09E81CCF46CD258 FOREIGN KEY (matiere_id) REFERENCES class_subject (id)');
        $this->addSql('ALTER TABLE student_note ADD CONSTRAINT FK_F09E81CCCB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE student_note ADD CONSTRAINT FK_F09E81CC613FECDF FOREIGN KEY (session_id) REFERENCES session (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D2EECC3F FOREIGN KEY (school_year_id) REFERENCES school_year (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE class_subject DROP FOREIGN KEY FK_3EBB5986BDDFA3C9');
        $this->addSql('ALTER TABLE class_subject DROP FOREIGN KEY FK_3EBB598623EDC87');
        $this->addSql('ALTER TABLE ecolage DROP FOREIGN KEY FK_FE61A04FCB944F1A');
        $this->addSql('ALTER TABLE emploi_du_temps DROP FOREIGN KEY FK_F86B32C18F5EA509');
        $this->addSql('ALTER TABLE emploi_du_temps DROP FOREIGN KEY FK_F86B32C1F46CD258');
        $this->addSql('ALTER TABLE history DROP FOREIGN KEY FK_27BA704BA76ED395');
        $this->addSql('ALTER TABLE history DROP FOREIGN KEY FK_27BA704BB4F74015');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840DA76ED395');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495554177093');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955D2EECC3F');
        $this->addSql('ALTER TABLE reservation_user DROP FOREIGN KEY FK_9BAA1B21B83297E7');
        $this->addSql('ALTER TABLE reservation_user DROP FOREIGN KEY FK_9BAA1B21A76ED395');
        $this->addSql('ALTER TABLE scolarite DROP FOREIGN KEY FK_276250ABC54C8C93');
        $this->addSql('ALTER TABLE scolarite DROP FOREIGN KEY FK_276250ABA76ED395');
        $this->addSql('ALTER TABLE scolarite DROP FOREIGN KEY FK_276250ABD2EECC3F');
        $this->addSql('DROP INDEX IDX_276250ABD2EECC3F ON scolarite');
        $this->addSql('ALTER TABLE scolarite ADD salaires VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, DROP school_year_id, DROP salary, DROP deletedAt, DROP diplome, DROP cin, DROP date_cin, DROP lieu_cin, DROP num_ae, DROP note_libre, DROP ets_name, DROP ets_logo, DROP ets_hash_name, CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE type_id type_id INT DEFAULT NULL, CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D4D2EECC3F');
        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF33A76ED395');
        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF338F5EA509');
        $this->addSql('ALTER TABLE student_note DROP FOREIGN KEY FK_F09E81CCF46CD258');
        $this->addSql('ALTER TABLE student_note DROP FOREIGN KEY FK_F09E81CCCB944F1A');
        $this->addSql('ALTER TABLE student_note DROP FOREIGN KEY FK_F09E81CC613FECDF');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D2EECC3F');
    }
}
