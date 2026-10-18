<?php

declare(strict_types=1);

use ByTIC\DocumentGenerator\Utility\PackageConfig;
use Phinx\Migration\AbstractMigration;

final class PdfLetterFieldsTable extends AbstractMigration
{
    public function up(): void
    {
        $tableName = PackageConfig::tableName('letter_fields');
        $parentTableName = PackageConfig::tableName('letters');
        if ($tableName === null) {
            throw new RuntimeException('Missing config table mapping for "letter_fields".');
        }
        if ($parentTableName === null) {
            throw new RuntimeException('Missing config table mapping for "letters".');
        }
        if ($this->hasTable($tableName)) {
            return;
        }

        if (!$this->hasTable($parentTableName)) {
            throw new RuntimeException(sprintf('Parent table "%s" for "%s" does not exist.', $parentTableName, $tableName));
        }

        $table = $this->table($tableName);
        $table
            ->addColumn('id_letter', 'integer', ['signed' => false])
            ->addColumn('field', 'string', ['limit' => 255])
            ->addColumn('x', 'decimal', ['precision' => 10, 'scale' => 2])
            ->addColumn('y', 'decimal', ['precision' => 10, 'scale' => 2])
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
        $tableName = PackageConfig::tableName('letter_fields');
        if ($tableName !== null && $this->hasTable($tableName)) {
            $this->table($tableName)->dropForeignKey('id_letter')->drop()->save();
        }
    }
}
