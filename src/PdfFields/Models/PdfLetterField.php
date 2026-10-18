<?php

declare(strict_types=1);

namespace ByTIC\DocumentGenerator\PdfFields\Models;

use ByTIC\DocumentGenerator\Base\Models\BaseModel;
use ByTIC\DocumentGenerator\PdfLetters\Models\Fields\FieldTrait;
use ByTIC\DocumentGenerator\Utility\PackageConfig;

class PdfLetterField extends BaseModel
{
    use FieldTrait;

    public function getPdfLetter()
    {
        return $this->getManager()->getLetterManager()->findOne($this->id_letter);
    }

    public function getRegistry()
    {
        return $this->getManager();
    }

    public function generateTable(): string
    {
        return PackageConfig::tableName('letter_fields', 'letter_fields');
    }
}
