<?php

declare(strict_types=1);

namespace ByTIC\DocumentGenerator\PdfFields\Models;

use ByTIC\DocumentGenerator\Base\Models\BaseManager;
use ByTIC\DocumentGenerator\PdfLetters\Models\Fields\FieldsTrait;
use ByTIC\DocumentGenerator\PdfLetters\Models\PdfLetters;
use ByTIC\DocumentGenerator\Utility\PackageConfig;
use Nip\Utility\Traits\SingletonTrait;

class PdfLetterFields extends BaseManager
{
    use FieldsTrait;
    use SingletonTrait;

    public function getPrimaryKey(): string
    {
        return 'id';
    }

    public function generateTable(): string
    {
        return PackageConfig::tableName('letter_fields', 'letter_fields');
    }

    public function getLetterManager()
    {
        return PdfLetters::instance();
    }
}
