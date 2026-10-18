<?php

namespace ByTIC\DocumentGenerator\Tests\Fixtures\Models\Downloads;

use ByTIC\DocumentGenerator\LetterDownloads\Models\DownloadTrait;
use Nip\Records\Record;

/**
 * Class Letter
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
