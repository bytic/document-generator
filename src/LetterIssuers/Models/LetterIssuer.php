<?php

declare(strict_types=1);

namespace ByTIC\DocumentGenerator\LetterIssuers\Models;

use ByTIC\DocumentGenerator\Base\Models\BaseModel;
use ByTIC\DocumentGenerator\Utility\DocumentGeneratorModels;
use ByTIC\DocumentGenerator\Utility\PackageConfig;

class LetterIssuer extends BaseModel
{
    public function getName()
    {
        return $this->name ?? 'Issuer';
    }

    public function generateTable(): string
    {
        return PackageConfig::tableName(DocumentGeneratorModels::LETTER_ISSUERS, 'letter_issuers');
    }
}
