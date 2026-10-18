<?php

declare(strict_types=1);

namespace ByTIC\DocumentGenerator\PdfLetters\Models\Issuers;

use Nip\Records\RecordManager;
use Nip\Utility\Traits\SingletonTrait;

class PdfIssuers extends RecordManager
{
    use SingletonTrait;

    public function getPrimaryKey(): string
    {
        return 'id';
    }

    public function generateTable(): string
    {
        return 'pdf_issuers';
    }
}
