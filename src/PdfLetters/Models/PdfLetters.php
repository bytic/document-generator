<?php

declare(strict_types=1);

namespace ByTIC\DocumentGenerator\PdfLetters\Models;

use ByTIC\DocumentGenerator\Base\Models\BaseManager;
use ByTIC\DocumentGenerator\PdfFields\Models\PdfLetterFields;
use ByTIC\DocumentGenerator\PdfLetters\Models\PdfLetters\PdfLettersTrait;
use ByTIC\DocumentGenerator\Utility\PackageConfig;
use Nip\Utility\Traits\SingletonTrait;

class PdfLetters extends BaseManager
{
    use PdfLettersTrait;
    use SingletonTrait;

    public function getPrimaryKey(): string
    {
        return 'id';
    }

    public function generateTable(): string
    {
        return PackageConfig::tableName('letters', 'letter_letters');
    }

    public function getParentManagerFromType($type)
    {
        return null;
    }

    protected function getCustomFieldsManagerClass(): string
    {
        return PdfLetterFields::class;
    }
}
