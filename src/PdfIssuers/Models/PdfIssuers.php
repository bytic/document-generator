<?php

declare(strict_types=1);

namespace ByTIC\DocumentGenerator\PdfIssuers\Models;

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
        return 'letter_issuers';
    }
}
