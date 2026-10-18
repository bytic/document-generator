<?php

declare(strict_types=1);

namespace ByTIC\DocumentGenerator\PdfWriter\Models;

use ByTIC\DocumentGenerator\Base\Models\BaseManager;
use ByTIC\DocumentGenerator\LetterFields\Models\LetterFields;
use ByTIC\DocumentGenerator\Utility\DocumentGeneratorModels;
use ByTIC\DocumentGenerator\Utility\PackageConfig;
use Nip\Utility\Traits\SingletonTrait;

/**
 *
 */
class Letters extends BaseManager
{
    use LettersTrait;
    use SingletonTrait;

    public function getPrimaryKey(): string
    {
        return 'id';
    }

    public function generateTable(): string
    {
        return PackageConfig::tableName(DocumentGeneratorModels::LETTERS, 'letter_letters');
    }

    public function getParentManagerFromType($type)
    {
        return null;
    }
}