<?php

declare(strict_types=1);

namespace ByTIC\DocumentGenerator\PdfLetters\Models\Fields;

use Nip\Records\RecordManager;
use Nip\Utility\Traits\SingletonTrait;

class PdfLetterFields extends RecordManager
{
    use FieldsTrait;
    use SingletonTrait;

    public function getPrimaryKey(): string
    {
        return 'id';
    }

    public function generateTable(): string
    {
        return 'pdf_letter_fields';
    }

    public function getLetterManager()
    {
        return PdfLetters::instance();
    }
}
