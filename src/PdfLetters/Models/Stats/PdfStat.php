<?php

declare(strict_types=1);

namespace ByTIC\DocumentGenerator\PdfLetters\Models\Stats;

use Nip\Records\Record;

class PdfStat extends Record
{
    use StatTrait;

    public function populateFromRelated(\Nip\Records\AbstractModels\Record $related)
    {
        $this->stat_type = $related->getManager()->getController();
        $this->stat_id = $related->getPrimaryKey();
    }
}
