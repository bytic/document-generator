<?php

declare(strict_types=1);

namespace ByTIC\DocumentGenerator\LetterDownloads\Models;

use ByTIC\DocumentGenerator\Base\Models\BaseManager;
use ByTIC\DocumentGenerator\Letters\Models\Downloads\DownloadsTrait;
use ByTIC\DocumentGenerator\Utility\PackageConfig;
use Nip\Utility\Traits\SingletonTrait;

class LetterDownloads extends BaseManager
{
    use DownloadsTrait;
    use SingletonTrait;

    public function getPrimaryKey(): string
    {
        return 'id';
    }

    public function generateTable(): string
    {
        return PackageConfig::tableName('letter_downloads', 'letter_downloads');
    }
}
