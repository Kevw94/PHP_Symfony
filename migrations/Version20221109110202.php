<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221109110202 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE candidacy DROP FOREIGN KEY FK_D930569D31D987B');
        $this->addSql('DROP INDEX IDX_D930569D31D987B ON candidacy');
        $this->addSql('ALTER TABLE candidacy CHANGE id_offer_id offer_id INT NOT NULL');
        $this->addSql('ALTER TABLE candidacy ADD CONSTRAINT FK_D930569D53C674EE FOREIGN KEY (offer_id) REFERENCES offer (id)');
        $this->addSql('CREATE INDEX IDX_D930569D53C674EE ON candidacy (offer_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE candidacy DROP FOREIGN KEY FK_D930569D53C674EE');
        $this->addSql('DROP INDEX IDX_D930569D53C674EE ON candidacy');
        $this->addSql('ALTER TABLE candidacy CHANGE offer_id id_offer_id INT NOT NULL');
        $this->addSql('ALTER TABLE candidacy ADD CONSTRAINT FK_D930569D31D987B FOREIGN KEY (id_offer_id) REFERENCES offer (id)');
        $this->addSql('CREATE INDEX IDX_D930569D31D987B ON candidacy (id_offer_id)');
    }
}
