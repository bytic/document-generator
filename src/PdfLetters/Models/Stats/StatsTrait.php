<?php

namespace ByTIC\DocumentGenerator\PdfLetters\Models\Stats;

use ByTIC\DocumentGenerator\Tests\Fixtures\Models\PdfLetters\PdfLetter;
use Nip\Records\AbstractModels\Record;
use Nip\Records\Traits\AbstractTrait\RecordsTrait as AbstractRecordsTrait;

/**
 * Class StatsTrait
 * @package ByTIC\DocumentGenerator\PdfLetters\Models\Stats
 */
trait StatsTrait
{
    use AbstractRecordsTrait;

    /**
     * @param PdfLetter|Record $letter
     */
    public function compileForLetter($letter)
    {
    }
}
