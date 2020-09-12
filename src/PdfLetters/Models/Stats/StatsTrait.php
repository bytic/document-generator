<?php

namespace ByTIC\DocumentGenerator\PdfLetters\Models\Stats;

use ByTIC\DocumentGenerator\Tests\Fixtures\Models\PdfLetters\PdfLetter;
use Nip\Records\AbstractModels\Record;
use Nip\Records\Traits\AbstractTrait\RecordsTrait as AbstractRecordsTrait;

/**
 * Class StatsTrait
 * @package ByTIC\DocumentGenerator\PdfLetters\Models\Stats
 *
 * @method StatTrait getNew
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

    /**
     * @param $letter
     * @param $related
     * @param $value
     * @return StatTrait
     */
    public function create($letter, $related, $value)
    {
        $stat = $this->getNew();
        $stat->populateFromLetter($letter);
        $stat->populateFromRelated($related);
        $stat->value = $value;
        $stat->insert();
        return $stat;
    }
}
