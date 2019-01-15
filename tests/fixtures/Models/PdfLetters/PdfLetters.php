<?php

namespace ByTIC\DocumentGenerator\Tests\Fixtures\Models\PdfLetters;

use ByTIC\DocumentGenerator\PdfLetters\PdfLettersTrait;
use Nip\Records\RecordManager;
use Nip\Records\Traits\AbstractTrait\RecordsTrait as AbstractRecordsTrait;

/**
 * Class PdfLetter
 * @package ByTIC\DocumentGenerator\Tests\Fixtures\Models\PdfLetters
 */
class PdfLetters extends RecordManager
{
    use PdfLettersTrait;

    /**
     * @inheritdoc
     */
    public function getPrimaryKey()
    {
        return 'id';
    }

    public function generateTable()
    {
        return 'pdf_letters';
    }

    /**
     * @param $type
     * @return AbstractRecordsTrait
     */
    public function getParentManagerFromType($type)
    {
        // TODO: Implement getParentManagerFromType() method.
    }

    /**
     * @return string
     */
    protected function getCustomFieldsManagerClass()
    {
        // TODO: Implement getCustomFieldsManagerClass() method.
    }
}
