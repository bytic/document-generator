<?php

declare(strict_types=1);

namespace ByTIC\DocumentGenerator\PdfStats\Models;

use ByTIC\DocumentGenerator\PdfLetters\Models\Stats\StatsTrait;
use Nip\Records\RecordManager;
use Nip\Utility\Traits\SingletonTrait;

class PdfStats extends RecordManager
{
    use StatsTrait;
    use SingletonTrait;

    public function getPrimaryKey(): string
    {
        return 'id';
    }

    public function generateTable(): string
    {
        return 'pdf_stats';
    }
}
