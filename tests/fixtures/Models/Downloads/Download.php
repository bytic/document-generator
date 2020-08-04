<?php

namespace ByTIC\DocumentGenerator\Tests\Fixtures\Models\Downloads;

use ByTIC\DocumentGenerator\PdfLetters\Models\Downloads\DownloadTrait;
use Nip\Records\Record;

/**
 * Class PdfLetter
 * @package ByTIC\DocumentGenerator\Tests\Fixtures\Models\Downloads
 */
class Download extends Record
{
    use DownloadTrait;

    public function populateFromRecipient($recipient)
    {
        // TODO: Implement populateFromRecipient() method.
    }
}
