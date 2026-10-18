<?php

declare(strict_types=1);

namespace ByTIC\DocumentGenerator\LetterDownloads\Models;

use ByTIC\DocumentGenerator\Base\Models\BaseModel;
use ByTIC\DocumentGenerator\LetterDownloads\Models\DownloadTrait;
use ByTIC\DocumentGenerator\Utility\DocumentGeneratorModels;
use ByTIC\DocumentGenerator\Utility\PackageConfig;

/**
 *
 */
class LetterDownload extends BaseModel
{
    use DownloadTrait;

    public function populateFromRecipient($recipient)
    {
        return $this;
    }

    public function generateTable(): string
    {
        return PackageConfig::tableName(DocumentGeneratorModels::LETTER_DOWNLOADS, 'letter_downloads');
    }
}
