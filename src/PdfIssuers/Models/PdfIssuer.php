<?php

declare(strict_types=1);

namespace ByTIC\DocumentGenerator\PdfIssuers\Models;

use Nip\Records\Record;

class PdfIssuer extends Record
{
    public function getName()
    {
        return $this->name ?? 'Issuer';
    }
}
