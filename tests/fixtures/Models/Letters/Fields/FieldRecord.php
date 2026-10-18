<?php

namespace ByTIC\DocumentGenerator\Tests\Fixtures\Models\Letters\Fields;

use ByTIC\DocumentGenerator\LetterFields\Models\FieldTrait;
use Nip\Records\Record;

/**
 * Class FieldRecord
 * @package ByTIC\DocumentGenerator\Tests\Fixtures\Models\Letters\Fields
 */
class FieldRecord extends Record
{
    use FieldTrait;

    /**
     * @inheritDoc
     */
    public function getLetter()
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
