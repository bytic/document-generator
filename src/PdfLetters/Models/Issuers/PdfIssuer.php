<?php

declare(strict_types=1);

namespace ByTIC\DocumentGenerator\PdfLetters\Models\Issuers;

use Nip\Records\Record;

class PdfIssuer extends Record
{
    public function getName()
    {
        return $this->name ?? 'Issuer';
    }
}
