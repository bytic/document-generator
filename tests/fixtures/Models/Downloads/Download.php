<?php

namespace ByTIC\DocumentGenerator\Tests\Fixtures\Models\Downloads;

use ByTIC\DocumentGenerator\Letters\Models\Downloads\DownloadTrait;
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
