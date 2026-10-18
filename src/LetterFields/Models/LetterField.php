<?php

declare(strict_types=1);

namespace ByTIC\DocumentGenerator\LetterFields\Models;

use ByTIC\DocumentGenerator\Base\Models\BaseModel;
use ByTIC\DocumentGenerator\Letters\Models\Fields\FieldTrait;
use ByTIC\DocumentGenerator\Utility\DocumentGeneratorModels;
use ByTIC\DocumentGenerator\Utility\PackageConfig;

class LetterField extends BaseModel
{
    use FieldTrait;

    public function getLetter()
    {
        return $this->getManager()->getLetterManager()->findOne($this->id_letter);
    }

    public function getRegistry()
    {
        return $this->getManager();
    }

    public function generateTable(): string
    {
        return PackageConfig::tableName(DocumentGeneratorModels::LETTER_FIELDS, 'letter_fields');
    }
}
