<?php

declare(strict_types=1);

namespace ByTIC\DocumentGenerator\PdfLetters\Models\Downloads;

use Nip\Records\Record;

class PdfDownload extends Record
{
    use DownloadTrait;

    public function populateFromRecipient($recipient)
    {
        return $this;
    }
}
