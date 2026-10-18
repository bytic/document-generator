<?php

declare(strict_types=1);

namespace ByTIC\DocumentGenerator\LetterFields\Models;

use ByTIC\DocumentGenerator\Base\Models\BaseManager;
use ByTIC\DocumentGenerator\LetterFields\Models\FieldsTrait;
use ByTIC\DocumentGenerator\PdfWriter\Models\Letters;
use ByTIC\DocumentGenerator\Utility\DocumentGeneratorModels;
use ByTIC\DocumentGenerator\Utility\PackageConfig;
use Nip\Utility\Traits\SingletonTrait;

class LetterFields extends BaseManager
{
    use FieldsTrait;
    use SingletonTrait;

    public function getPrimaryKey(): string
    {
        return 'id';
    }

    public function generateTable(): string
    {
        return PackageConfig::tableName(DocumentGeneratorModels::LETTER_FIELDS, 'letter_fields');
    }

    public function getLetterManager()
    {
        return Letters::instance();
    }
}
