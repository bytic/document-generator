<?php

declare(strict_types=1);

namespace ByTIC\DocumentGenerator\PdfStats\Models;

use ByTIC\DocumentGenerator\Base\Models\BaseModel;
use ByTIC\DocumentGenerator\PdfLetters\Models\Stats\StatTrait;
use ByTIC\DocumentGenerator\Utility\PackageConfig;

class PdfStat extends BaseModel
{
    use StatTrait;

    public function populateFromRelated(\Nip\Records\AbstractModels\Record $related)
    {
        $this->stat_type = $related->getManager()->getController();
        $this->stat_id = $related->getPrimaryKey();
    }

    public function generateTable(): string
    {
        return PackageConfig::tableName('letter_stats', 'letter_stats');
    }
}
