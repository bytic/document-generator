<?php

namespace ByTIC\DocumentGenerator\Tests\Fixtures\Models\Letters\Fields\Types;

use ByTIC\DocumentGenerator\LetterFields\Types\AbstractType;
use ByTIC\DocumentGenerator\LetterFields\Types\Behaviors\BarcodeTypeTrait;

/**
 * Class CodeField
 * @package ByTIC\DocumentGenerator\Tests\Fixtures\Models\Letters\Fields\Types
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
