<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191127104349 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE boss (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, health INT NOT NULL, armour INT NOT NULL, resist_fire INT NOT NULL, resist_ice INT NOT NULL, power INT NOT NULL, power_ice INT NOT NULL, power_fire INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fight (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, boss_id INT DEFAULT NULL, result SMALLINT NOT NULL, turns INT DEFAULT NULL, INDEX IDX_21AA4456A76ED395 (user_id), INDEX IDX_21AA4456261FB672 (boss_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fight_stuff (fight_id INT NOT NULL, stuff_id INT NOT NULL, INDEX IDX_BF84D477AC6657E4 (fight_id), INDEX IDX_BF84D477950A1740 (stuff_id), PRIMARY KEY(fight_id, stuff_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE slot (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stuff (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, m_health INT NOT NULL, m_armour INT NOT NULL, m_resist_fire INT NOT NULL, m_resist_ice INT NOT NULL, m_power INT NOT NULL, m_power_ice INT NOT NULL, m_power_fire INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, armour INT NOT NULL, health INT NOT NULL, resist_fire INT NOT NULL, resist_ice INT NOT NULL, power INT NOT NULL, power_ice INT NOT NULL, power_fire INT NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fight ADD CONSTRAINT FK_21AA4456A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE fight ADD CONSTRAINT FK_21AA4456261FB672 FOREIGN KEY (boss_id) REFERENCES boss (id)');
        $this->addSql('ALTER TABLE fight_stuff ADD CONSTRAINT FK_BF84D477AC6657E4 FOREIGN KEY (fight_id) REFERENCES fight (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fight_stuff ADD CONSTRAINT FK_BF84D477950A1740 FOREIGN KEY (stuff_id) REFERENCES stuff (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE fight DROP FOREIGN KEY FK_21AA4456261FB672');
        $this->addSql('ALTER TABLE fight_stuff DROP FOREIGN KEY FK_BF84D477AC6657E4');
        $this->addSql('ALTER TABLE fight_stuff DROP FOREIGN KEY FK_BF84D477950A1740');
        $this->addSql('ALTER TABLE fight DROP FOREIGN KEY FK_21AA4456A76ED395');
        $this->addSql('DROP TABLE boss');
        $this->addSql('DROP TABLE fight');
        $this->addSql('DROP TABLE fight_stuff');
        $this->addSql('DROP TABLE slot');
        $this->addSql('DROP TABLE stuff');
        $this->addSql('DROP TABLE user');
    }
}
