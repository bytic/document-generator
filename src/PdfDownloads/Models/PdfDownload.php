<?php

declare(strict_types=1);

namespace ByTIC\DocumentGenerator\PdfDownloads\Models;

use ByTIC\DocumentGenerator\Base\Models\BaseModel;
use ByTIC\DocumentGenerator\PdfLetters\Models\Downloads\DownloadTrait;
use ByTIC\DocumentGenerator\Utility\PackageConfig;

class PdfDownload extends BaseModel
{
    use DownloadTrait;

    public function populateFromRecipient($recipient)
    {
        return $this;
    }

    public function generateTable(): string
    {
        return PackageConfig::tableName('letter_downloads', 'letter_downloads');
    }
}
