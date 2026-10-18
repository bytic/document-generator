<?php

declare(strict_types=1);

use ByTIC\DocumentGenerator\Utility\PackageConfig;
use Phinx\Migration\AbstractMigration;

final class LettersTable extends AbstractMigration
{
    public function up(): void
    {
        $tableName = PackageConfig::tableName('letters');
        if ($tableName === null) {
            throw new RuntimeException('Missing config table mapping for "letters".');
        }
        if ($this->hasTable($tableName)) {
            return;
        }

        $table = $this->table($tableName);
        $table
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

    public function down(): void
    {
        $tableName = PackageConfig::tableName('letters');
        if ($tableName !== null && $this->hasTable($tableName)) {
            $this->table($tableName)->drop()->save();
        }
    }
}
