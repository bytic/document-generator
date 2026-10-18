<?php

declare(strict_types=1);

use ByTIC\DocumentGenerator\Utility\DocumentGeneratorModels;
use ByTIC\DocumentGenerator\Utility\PackageConfig;
use Phinx\Migration\AbstractMigration;

final class LettersTable extends AbstractMigration
{
    public function change(): void
    {
        $tableName = PackageConfig::tableName(DocumentGeneratorModels::LETTERS);
        if ($tableName === null) {
            throw new RuntimeException('Missing config table mapping for "letters".');
        }
        if ($this->hasTable($tableName)) {
            return;
        }

        $this->table($tableName)
            ->addColumn('id_item', 'integer', ['signed' => false])
            ->addColumn('type', 'string', ['limit' => 64])
            // 'l' = landscape; 'p' = portrait
            ->addColumn('orientation', 'string', ['limit' => 1, 'default' => 'l'])
            ->addColumn('format', 'string', ['limit' => 8, 'default' => 'A4'])
            ->addColumn('options', 'text')
            ->addIndex(['id_item'])
            ->addIndex(['type'])
            ->create();
    }
}
