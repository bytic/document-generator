<?php

declare(strict_types=1);

use ByTIC\DocumentGenerator\Utility\DocumentGeneratorModels;
use ByTIC\DocumentGenerator\Utility\PackageConfig;
use Phinx\Migration\AbstractMigration;

final class LetterStatsTable extends AbstractMigration
{
    public function change(): void
    {
        $tableName = PackageConfig::tableName(DocumentGeneratorModels::LETTER_STATS);
        if ($tableName === null) {
            throw new RuntimeException('Missing config table mapping for "letter_stats".');
        }
        if ($this->hasTable($tableName)) {
            return;
        }

        $this->table($tableName)
            ->addColumn('id_letter', 'integer', ['signed' => false])
            ->addColumn('stat_type', 'string', ['limit' => 255])
            ->addColumn('stat_id', 'integer', ['signed' => false])
            ->addColumn('value', 'integer', ['signed' => false])
            ->addIndex(['id_letter'])
            ->addIndex(['stat_type'])
            ->addIndex(['stat_id'])
            ->create();
    }
}
