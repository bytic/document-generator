<?php

declare(strict_types=1);

namespace ByTIC\DocumentGenerator\LetterStats\Models;

use ByTIC\DocumentGenerator\Base\Models\BaseModel;
use ByTIC\DocumentGenerator\LetterStats\Models\StatTrait;
use ByTIC\DocumentGenerator\Utility\DocumentGeneratorModels;
use ByTIC\DocumentGenerator\Utility\PackageConfig;

class LetterStat extends BaseModel
{
    use StatTrait;

    public function populateFromRelated(\Nip\Records\AbstractModels\Record $related)
    {
        $this->stat_type = $related->getManager()->getController();
        $this->stat_id = $related->getPrimaryKey();
    }

    public function generateTable(): string
    {
        return PackageConfig::tableName(DocumentGeneratorModels::LETTER_STATS, 'letter_stats');
    }
}
