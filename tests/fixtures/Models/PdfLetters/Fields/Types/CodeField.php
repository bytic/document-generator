<?php

namespace ByTIC\DocumentGenerator\Tests\Fixtures\Models\PdfLetters\Fields\Types;

use ByTIC\DocumentGenerator\PdfLetters\Models\Fields\Types\AbstractType;
use ByTIC\DocumentGenerator\PdfLetters\Models\Fields\Types\BarcodeTypeTrait;

/**
 * Class CodeField
 * @package ByTIC\DocumentGenerator\Tests\Fixtures\Models\PdfLetters\Fields\Types
 */
class CodeField extends AbstractType
{
    use BarcodeTypeTrait;

    /**
     * @inheritDoc
     */
    public function getCategory()
    {
    }
}
