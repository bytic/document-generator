<?php

declare(strict_types=1);

namespace ByTIC\DocumentGenerator\PdfDownloads\Models;

use ByTIC\DocumentGenerator\PdfLetters\Models\Downloads\DownloadTrait;
use Nip\Records\Record;

class PdfDownload extends Record
{
    use DownloadTrait;

    public function populateFromRecipient($recipient)
    {
        return $this;
    }
}
