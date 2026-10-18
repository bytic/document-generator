<?php

declare(strict_types=1);

use ByTIC\DocumentGenerator\Utility\DocumentGeneratorModels;
use ByTIC\DocumentGenerator\Utility\PackageConfig;
use Phinx\Migration\AbstractMigration;

final class LetterDownloadsTable extends AbstractMigration
{
    public function change(): void
    {
        $tableName = PackageConfig::tableName(DocumentGeneratorModels::LETTER_DOWNLOADS);
        if ($tableName === null) {
            throw new RuntimeException('Missing config table mapping for "letter_downloads".');
        }
        if ($this->hasTable($tableName)) {
            return;
        }

        $this->table($tableName)
            ->addColumn('id_letter', 'integer', ['signed' => false])
            ->addColumn('datetime', 'datetime')
            ->addIndex(['id_letter'])
            ->create();
    }
}
