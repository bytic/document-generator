<?php

declare(strict_types=1);

namespace ByTIC\DocumentGenerator\PdfStats\Models;

use ByTIC\DocumentGenerator\Base\Models\BaseManager;
use ByTIC\DocumentGenerator\PdfLetters\Models\Stats\StatsTrait;
use ByTIC\DocumentGenerator\Utility\PackageConfig;
use Nip\Utility\Traits\SingletonTrait;

class PdfStats extends BaseManager
{
    use StatsTrait;
    use SingletonTrait;

    public function getPrimaryKey(): string
    {
        return 'id';
    }

    public function generateTable(): string
    {
        return PackageConfig::tableName('letter_stats', 'letter_stats');
    }
}
