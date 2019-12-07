<?php

namespace ByTIC\DocumentGenerator\Tests\Fixtures\Models\PdfLetters\Fields;

use ByTIC\DocumentGenerator\PdfLetters\Fields\FieldTrait;
use Nip\Records\Record;

/**
 * Class FieldRecord
 * @package ByTIC\DocumentGenerator\Tests\Fixtures\Models\PdfLetters\Fields
 */
class FieldRecord extends Record
{
    use FieldTrait;

    /**
     * @inheritDoc
     */
    public function getPdfLetter()
    {
    }

    /**
     * @inheritDoc
     */
    public function getRegistry()
    {
        // TODO: Implement getRegistry() method.
    }
}
