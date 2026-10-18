<?php

declare(strict_types=1);

namespace ByTIC\DocumentGenerator\PdfIssuers\Models;

use ByTIC\DocumentGenerator\Base\Models\BaseManager;
use ByTIC\DocumentGenerator\Utility\PackageConfig;
use Nip\Utility\Traits\SingletonTrait;

class PdfIssuers extends BaseManager
{
    use SingletonTrait;

    public function getPrimaryKey(): string
    {
        return 'id';
    }

    public function generateTable(): string
    {
        return PackageConfig::tableName('letter_issuers', 'letter_issuers');
    }
}
