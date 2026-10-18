<?php

namespace ByTIC\DocumentGenerator\Letters\Models\Stats;

use ByTIC\DocumentGenerator\Tests\Fixtures\Models\Letters\Letter;
use Nip\Records\AbstractModels\Record;
use Nip\Records\Traits\AbstractTrait\RecordsTrait as AbstractRecordsTrait;

/**
 * Class StatsTrait
 * @package ByTIC\DocumentGenerator\Letters\Models\Stats
 *
 * @method StatTrait getNew
 */
trait StatsTrait
{
    use AbstractRecordsTrait;

    /**
     * @param Letter|Record $letter
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
