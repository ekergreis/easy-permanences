<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201116185751 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE echange (id INT AUTO_INCREMENT NOT NULL, permanence_id INT NOT NULL, user_id INT NOT NULL, code_validate VARCHAR(255) NOT NULL, resolue TINYINT(1) DEFAULT \'0\' NOT NULL, created_at DATE NOT NULL, INDEX IDX_B577E3BFA9457964 (permanence_id), INDEX IDX_B577E3BFA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE echange_propos (id INT AUTO_INCREMENT NOT NULL, echange_id INT NOT NULL, user_id INT NOT NULL, code_validate VARCHAR(255) NOT NULL, created_at DATE NOT NULL, INDEX IDX_FBAFF4B713713818 (echange_id), INDEX IDX_FBAFF4B7A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `group` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE permanence (id INT AUTO_INCREMENT NOT NULL, group_id INT DEFAULT NULL, date DATE NOT NULL, INDEX IDX_DF30CBB6FE54D947 (group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE permanence_user (permanence_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_CCB60EA1A9457964 (permanence_id), INDEX IDX_CCB60EA1A76ED395 (user_id), PRIMARY KEY(permanence_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, group_id INT DEFAULT NULL, email VARCHAR(100) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, name VARCHAR(100) NOT NULL, anim_regulier TINYINT(1) DEFAULT \'0\' NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D649FE54D947 (group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE echange ADD CONSTRAINT FK_B577E3BFA9457964 FOREIGN KEY (permanence_id) REFERENCES permanence (id)');
        $this->addSql('ALTER TABLE echange ADD CONSTRAINT FK_B577E3BFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE echange_propos ADD CONSTRAINT FK_FBAFF4B713713818 FOREIGN KEY (echange_id) REFERENCES echange (id)');
        $this->addSql('ALTER TABLE echange_propos ADD CONSTRAINT FK_FBAFF4B7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE permanence ADD CONSTRAINT FK_DF30CBB6FE54D947 FOREIGN KEY (group_id) REFERENCES `group` (id)');
        $this->addSql('ALTER TABLE permanence_user ADD CONSTRAINT FK_CCB60EA1A9457964 FOREIGN KEY (permanence_id) REFERENCES permanence (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE permanence_user ADD CONSTRAINT FK_CCB60EA1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649FE54D947 FOREIGN KEY (group_id) REFERENCES `group` (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE echange_propos DROP FOREIGN KEY FK_FBAFF4B713713818');
        $this->addSql('ALTER TABLE permanence DROP FOREIGN KEY FK_DF30CBB6FE54D947');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649FE54D947');
        $this->addSql('ALTER TABLE echange DROP FOREIGN KEY FK_B577E3BFA9457964');
        $this->addSql('ALTER TABLE permanence_user DROP FOREIGN KEY FK_CCB60EA1A9457964');
        $this->addSql('ALTER TABLE echange DROP FOREIGN KEY FK_B577E3BFA76ED395');
        $this->addSql('ALTER TABLE echange_propos DROP FOREIGN KEY FK_FBAFF4B7A76ED395');
        $this->addSql('ALTER TABLE permanence_user DROP FOREIGN KEY FK_CCB60EA1A76ED395');
        $this->addSql('DROP TABLE echange');
        $this->addSql('DROP TABLE echange_propos');
        $this->addSql('DROP TABLE `group`');
        $this->addSql('DROP TABLE permanence');
        $this->addSql('DROP TABLE permanence_user');
        $this->addSql('DROP TABLE user');
    }
}
