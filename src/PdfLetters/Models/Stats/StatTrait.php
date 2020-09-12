<?php

namespace ByTIC\DocumentGenerator\PdfLetters\Models\Stats;

use ByTIC\DocumentGenerator\PdfLetters\Models\PdfLetters\PdfLetterTrait;
use Nip\Records\Record;
use Nip\Records\Traits\AbstractTrait\RecordTrait as AbstractRecordTrait;

/**
 * Class StatTrait
 * @package ByTIC\DocumentGenerator\PdfLetters\Models\Stats
 *
 * @property int $id_letter
 * @property string $stat_type
 * @property int $stat_id
 * @property int $value
 */
trait StatTrait
{
    use AbstractRecordTrait;

    /**
     * @param Record|PdfLetterTrait $letter
     */
    public function populateFromLetter($letter)
    {
        $this->id_letter = $letter->getPrimaryKey();
    }

    /**
     * @param $related
     */
    public function populateFromRelated(\Nip\Records\AbstractModels\Record $related)
    {
        $this->stat_type = $related->getManager()->getController();
        $this->stat_id = $related->getPrimaryKey();
    }
}
