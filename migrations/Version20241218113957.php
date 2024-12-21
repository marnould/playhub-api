<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241218113957 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Token entity creation';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE token (id UUID NOT NULL, access_token TEXT NOT NULL, refresh_token TEXT NOT NULL, source VARCHAR(255) NOT NULL, expire_date TIMESTAMP(6) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN token.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN token.expire_date IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE token');
    }
}
