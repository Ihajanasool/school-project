<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220808175016 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE administration_type (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', libelle VARCHAR(100) NOT NULL, ets_name VARCHAR(255) DEFAULT NULL, ets_logo VARCHAR(255) DEFAULT NULL, ets_hash_name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE administrator (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', type_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', user_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', school_year_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', salary VARCHAR(50) DEFAULT NULL, date_create DATETIME DEFAULT NULL, deletedAt DATETIME DEFAULT NULL, adresse VARCHAR(50) DEFAULT NULL, contact VARCHAR(50) DEFAULT NULL, diplome VARCHAR(100) DEFAULT NULL, cin VARCHAR(50) DEFAULT NULL, date_cin DATETIME DEFAULT NULL, lieu_cin VARCHAR(50) DEFAULT NULL, num_ae VARCHAR(150) DEFAULT NULL, note_libre VARCHAR(255) DEFAULT NULL, ets_name VARCHAR(255) DEFAULT NULL, ets_logo VARCHAR(255) DEFAULT NULL, ets_hash_name VARCHAR(255) DEFAULT NULL, INDEX IDX_58DF0651C54C8C93 (type_id), UNIQUE INDEX UNIQ_58DF0651A76ED395 (user_id), INDEX IDX_58DF0651D2EECC3F (school_year_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE class_room (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', section_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', created_by_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', deleted_at DATETIME DEFAULT NULL, created_at DATETIME DEFAULT NULL, name VARCHAR(255) NOT NULL, ecolage VARCHAR(100) DEFAULT NULL, ets_name VARCHAR(255) DEFAULT NULL, ets_logo VARCHAR(255) DEFAULT NULL, ets_hash_name VARCHAR(255) DEFAULT NULL, INDEX IDX_C6E266D4D823E37A (section_id), INDEX IDX_C6E266D4B03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE class_subject (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', class_room_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', school_year_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', profs_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', subject_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', coefficient VARCHAR(10) DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, ets_name VARCHAR(255) DEFAULT NULL, ets_logo VARCHAR(255) DEFAULT NULL, ets_hash_name VARCHAR(255) DEFAULT NULL, INDEX IDX_3EBB59869162176F (class_room_id), INDEX IDX_3EBB5986D2EECC3F (school_year_id), INDEX IDX_3EBB5986BDDFA3C9 (profs_id), INDEX IDX_3EBB598623EDC87 (subject_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE docs (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ecolage (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', student_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', month VARCHAR(100) NOT NULL, is_paid TINYINT(1) NOT NULL, price VARCHAR(100) DEFAULT NULL, INDEX IDX_FE61A04FCB944F1A (student_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE emploi_du_temps (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', classe_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', matiere_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', heure VARCHAR(100) DEFAULT NULL, remarque LONGTEXT DEFAULT NULL, jour VARCHAR(100) DEFAULT NULL, ets_name VARCHAR(255) DEFAULT NULL, ets_logo VARCHAR(255) DEFAULT NULL, ets_hash_name VARCHAR(255) DEFAULT NULL, INDEX IDX_F86B32C18F5EA509 (classe_id), INDEX IDX_F86B32C1F46CD258 (matiere_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE history (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', user_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', user_act_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', action LONGTEXT DEFAULT NULL, date_created DATETIME DEFAULT NULL, ets_name VARCHAR(255) DEFAULT NULL, ets_logo VARCHAR(255) DEFAULT NULL, ets_hash_name VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_27BA704BA76ED395 (user_id), INDEX IDX_27BA704BB4F74015 (user_act_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment (id INT AUTO_INCREMENT NOT NULL, user_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', type VARCHAR(50) NOT NULL, motif VARCHAR(100) NOT NULL, montant INT NOT NULL, date_payment DATE NOT NULL, date_enregistrement DATE NOT NULL, INDEX IDX_6D28840DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', room_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', school_year_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', start DATETIME DEFAULT NULL, end DATETIME DEFAULT NULL, description VARCHAR(150) DEFAULT NULL, is_valid TINYINT(1) DEFAULT NULL, is_fin TINYINT(1) DEFAULT NULL, ets_name VARCHAR(255) DEFAULT NULL, ets_logo VARCHAR(255) DEFAULT NULL, ets_hash_name VARCHAR(255) DEFAULT NULL, INDEX IDX_42C8495554177093 (room_id), INDEX IDX_42C84955D2EECC3F (school_year_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation_user (reservation_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', user_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', INDEX IDX_9BAA1B21B83297E7 (reservation_id), INDEX IDX_9BAA1B21A76ED395 (user_id), PRIMARY KEY(reservation_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE room (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', name VARCHAR(100) NOT NULL, places VARCHAR(10) NOT NULL, is_reserved TINYINT(1) DEFAULT NULL, deletedAt DATETIME DEFAULT NULL, ets_name VARCHAR(255) DEFAULT NULL, ets_logo VARCHAR(255) DEFAULT NULL, ets_hash_name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE school_year (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', name VARCHAR(255) NOT NULL, start_date DATETIME DEFAULT NULL, end_date DATETIME DEFAULT NULL, deletedAt DATETIME DEFAULT NULL, ets_name VARCHAR(255) DEFAULT NULL, ets_logo VARCHAR(255) DEFAULT NULL, ets_hash_name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE scolarite (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', type_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', user_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', school_year_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', date_create DATETIME DEFAULT NULL, adresse VARCHAR(50) NOT NULL, contact VARCHAR(50) DEFAULT NULL, salary VARCHAR(100) DEFAULT NULL, deletedAt DATETIME DEFAULT NULL, diplome VARCHAR(100) DEFAULT NULL, cin VARCHAR(50) DEFAULT NULL, date_cin DATETIME DEFAULT NULL, lieu_cin VARCHAR(50) DEFAULT NULL, num_ae VARCHAR(150) DEFAULT NULL, note_libre VARCHAR(255) DEFAULT NULL, ets_name VARCHAR(255) DEFAULT NULL, ets_logo VARCHAR(255) DEFAULT NULL, ets_hash_name VARCHAR(255) DEFAULT NULL, INDEX IDX_276250ABC54C8C93 (type_id), UNIQUE INDEX UNIQ_276250ABA76ED395 (user_id), INDEX IDX_276250ABD2EECC3F (school_year_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE scolarite_type (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', libelle VARCHAR(100) NOT NULL, deletedAt DATETIME DEFAULT NULL, ets_name VARCHAR(255) DEFAULT NULL, ets_logo VARCHAR(255) DEFAULT NULL, ets_hash_name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE section (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', name VARCHAR(255) NOT NULL, deleted_at DATETIME DEFAULT NULL, ets_name VARCHAR(255) DEFAULT NULL, ets_logo VARCHAR(255) DEFAULT NULL, ets_hash_name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', school_year_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', name VARCHAR(100) NOT NULL, deleted_at DATETIME DEFAULT NULL, ets_name VARCHAR(255) DEFAULT NULL, ets_logo VARCHAR(255) DEFAULT NULL, ets_hash_name VARCHAR(255) DEFAULT NULL, INDEX IDX_D044D5D4D2EECC3F (school_year_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', user_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', classe_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', is_renvoie TINYINT(1) DEFAULT \'0\' NOT NULL, deleted_at DATETIME DEFAULT NULL, status VARCHAR(30) DEFAULT NULL, contact VARCHAR(80) DEFAULT NULL, adresse VARCHAR(50) DEFAULT NULL, contact_parent VARCHAR(50) DEFAULT NULL, adresse_parent VARCHAR(50) DEFAULT NULL, note_libre LONGTEXT DEFAULT NULL, ets_name VARCHAR(255) DEFAULT NULL, ets_logo VARCHAR(255) DEFAULT NULL, ets_hash_name VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_B723AF33A76ED395 (user_id), INDEX IDX_B723AF338F5EA509 (classe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student_note (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', matiere_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', student_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', session_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', note VARCHAR(10) NOT NULL, observation LONGTEXT DEFAULT NULL, INDEX IDX_F09E81CCF46CD258 (matiere_id), INDEX IDX_F09E81CCCB944F1A (student_id), INDEX IDX_F09E81CC613FECDF (session_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subject (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', name VARCHAR(255) NOT NULL, deletedAt DATETIME DEFAULT NULL, ets_name VARCHAR(255) DEFAULT NULL, ets_logo VARCHAR(255) DEFAULT NULL, ets_hash_name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', school_year_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', username VARCHAR(180) NOT NULL, nom VARCHAR(255) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, date_create DATETIME DEFAULT NULL, date_update DATETIME DEFAULT NULL, deletedAt DATETIME DEFAULT NULL, imatriculation VARCHAR(255) DEFAULT NULL, photo VARCHAR(255) DEFAULT NULL, prenom VARCHAR(50) DEFAULT NULL, birth_date DATETIME DEFAULT NULL, sexe VARCHAR(10) DEFAULT NULL, birth_locale VARCHAR(100) DEFAULT NULL, is_enabled TINYINT(1) DEFAULT NULL, ets_name VARCHAR(255) DEFAULT NULL, ets_logo VARCHAR(255) DEFAULT NULL, ets_hash_name VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), INDEX IDX_8D93D649D2EECC3F (school_year_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE administrator ADD CONSTRAINT FK_58DF0651C54C8C93 FOREIGN KEY (type_id) REFERENCES administration_type (id)');
        $this->addSql('ALTER TABLE administrator ADD CONSTRAINT FK_58DF0651A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE administrator ADD CONSTRAINT FK_58DF0651D2EECC3F FOREIGN KEY (school_year_id) REFERENCES school_year (id)');
        $this->addSql('ALTER TABLE class_room ADD CONSTRAINT FK_C6E266D4D823E37A FOREIGN KEY (section_id) REFERENCES section (id)');
        $this->addSql('ALTER TABLE class_room ADD CONSTRAINT FK_C6E266D4B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE class_subject ADD CONSTRAINT FK_3EBB59869162176F FOREIGN KEY (class_room_id) REFERENCES class_room (id)');
        $this->addSql('ALTER TABLE class_subject ADD CONSTRAINT FK_3EBB5986D2EECC3F FOREIGN KEY (school_year_id) REFERENCES school_year (id)');
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
        $this->addSql('ALTER TABLE scolarite ADD CONSTRAINT FK_276250ABC54C8C93 FOREIGN KEY (type_id) REFERENCES scolarite_type (id)');
        $this->addSql('ALTER TABLE scolarite ADD CONSTRAINT FK_276250ABA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE scolarite ADD CONSTRAINT FK_276250ABD2EECC3F FOREIGN KEY (school_year_id) REFERENCES school_year (id)');
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

        $this->addSql('ALTER TABLE administrator DROP FOREIGN KEY FK_58DF0651C54C8C93');
        $this->addSql('ALTER TABLE class_subject DROP FOREIGN KEY FK_3EBB59869162176F');
        $this->addSql('ALTER TABLE emploi_du_temps DROP FOREIGN KEY FK_F86B32C18F5EA509');
        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF338F5EA509');
        $this->addSql('ALTER TABLE student_note DROP FOREIGN KEY FK_F09E81CCF46CD258');
        $this->addSql('ALTER TABLE reservation_user DROP FOREIGN KEY FK_9BAA1B21B83297E7');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495554177093');
        $this->addSql('ALTER TABLE administrator DROP FOREIGN KEY FK_58DF0651D2EECC3F');
        $this->addSql('ALTER TABLE class_subject DROP FOREIGN KEY FK_3EBB5986D2EECC3F');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955D2EECC3F');
        $this->addSql('ALTER TABLE scolarite DROP FOREIGN KEY FK_276250ABD2EECC3F');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D4D2EECC3F');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D2EECC3F');
        $this->addSql('ALTER TABLE class_subject DROP FOREIGN KEY FK_3EBB5986BDDFA3C9');
        $this->addSql('ALTER TABLE scolarite DROP FOREIGN KEY FK_276250ABC54C8C93');
        $this->addSql('ALTER TABLE class_room DROP FOREIGN KEY FK_C6E266D4D823E37A');
        $this->addSql('ALTER TABLE student_note DROP FOREIGN KEY FK_F09E81CC613FECDF');
        $this->addSql('ALTER TABLE ecolage DROP FOREIGN KEY FK_FE61A04FCB944F1A');
        $this->addSql('ALTER TABLE student_note DROP FOREIGN KEY FK_F09E81CCCB944F1A');
        $this->addSql('ALTER TABLE class_subject DROP FOREIGN KEY FK_3EBB598623EDC87');
        $this->addSql('ALTER TABLE emploi_du_temps DROP FOREIGN KEY FK_F86B32C1F46CD258');
        $this->addSql('ALTER TABLE administrator DROP FOREIGN KEY FK_58DF0651A76ED395');
        $this->addSql('ALTER TABLE class_room DROP FOREIGN KEY FK_C6E266D4B03A8386');
        $this->addSql('ALTER TABLE history DROP FOREIGN KEY FK_27BA704BA76ED395');
        $this->addSql('ALTER TABLE history DROP FOREIGN KEY FK_27BA704BB4F74015');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840DA76ED395');
        $this->addSql('ALTER TABLE reservation_user DROP FOREIGN KEY FK_9BAA1B21A76ED395');
        $this->addSql('ALTER TABLE scolarite DROP FOREIGN KEY FK_276250ABA76ED395');
        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF33A76ED395');
        $this->addSql('DROP TABLE administration_type');
        $this->addSql('DROP TABLE administrator');
        $this->addSql('DROP TABLE class_room');
        $this->addSql('DROP TABLE class_subject');
        $this->addSql('DROP TABLE docs');
        $this->addSql('DROP TABLE ecolage');
        $this->addSql('DROP TABLE emploi_du_temps');
        $this->addSql('DROP TABLE history');
        $this->addSql('DROP TABLE payment');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE reservation_user');
        $this->addSql('DROP TABLE room');
        $this->addSql('DROP TABLE school_year');
        $this->addSql('DROP TABLE scolarite');
        $this->addSql('DROP TABLE scolarite_type');
        $this->addSql('DROP TABLE section');
        $this->addSql('DROP TABLE session');
        $this->addSql('DROP TABLE student');
        $this->addSql('DROP TABLE student_note');
        $this->addSql('DROP TABLE subject');
        $this->addSql('DROP TABLE user');
    }
}
