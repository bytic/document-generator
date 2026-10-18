<?php

declare(strict_types=1);

namespace ByTIC\DocumentGenerator\PdfLetters\Models\Fields;

use Nip\Records\Record;

class PdfLetterField extends Record
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
}
