<?php

declare(strict_types=1);

use ByTIC\DocumentGenerator\Utility\PackageConfig;
use Phinx\Migration\AbstractMigration;

final class PdfLetterFieldsTable extends AbstractMigration
{
    public function up(): void
    {
        $tableName = PackageConfig::tableName('pdf_letter_fields');
        $parentTableName = PackageConfig::tableName('pdf_letters');
        if ($tableName === null || $parentTableName === null || !$this->hasTable($parentTableName) || $this->hasTable($tableName)) {
            return;
        }

        $table = $this->table($tableName);
        $table
            ->addColumn('id_letter', 'integer', ['signed' => false])
            ->addColumn('field', 'string', ['limit' => 255])
            ->addColumn('x', 'integer')
            ->addColumn('y', 'integer')
            ->addColumn('font', 'string', ['limit' => 255])
            ->addColumn('color', 'string', ['limit' => 255])
            ->addColumn('size', 'integer')
            ->addColumn('align', 'string', ['limit' => 16, 'default' => 'left'])
            ->addIndex(['id_letter'])
            ->addIndex(['field'])
            ->addForeignKey('id_letter', $parentTableName, 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->create();
    }

    public function down(): void
    {
        $tableName = PackageConfig::tableName('pdf_letter_fields');
        if ($tableName !== null && $this->hasTable($tableName)) {
            $this->table($tableName)->dropForeignKey('id_letter')->drop()->save();
        }
    }
}
