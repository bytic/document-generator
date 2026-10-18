<?php

declare(strict_types=1);

namespace ByTIC\DocumentGenerator\PdfDownloads\Models;

use ByTIC\DocumentGenerator\PdfLetters\Models\Downloads\DownloadsTrait;
use Nip\Records\RecordManager;
use Nip\Utility\Traits\SingletonTrait;

class PdfDownloads extends RecordManager
{
    use DownloadsTrait;
    use SingletonTrait;

    public function getPrimaryKey(): string
    {
        return 'id';
    }

    public function generateTable(): string
    {
        return 'letter_downloads';
    }
}
