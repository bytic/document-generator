<?php

namespace ByTIC\DocumentGenerator\PdfLetters\Models\Downloads;

use ByTIC\DocumentGenerator\PdfLetters\Models\PdfLetters\PdfLetterTrait;
use Nip\Records\Record;

/**
 * Class DownloadTrait
 * @package ByTIC\DocumentGenerator\PdfLetters\Models\Downloads
 *
 * @property string $datetime
 */
trait DownloadTrait
{
    /**
     * @param Record|PdfLetterTrait $letter
     */
    public function populateFromLetter($letter)
    {
        $this->id_letter = $letter->getPrimaryKey();
    }

    /**
     * @param Record $recipient
     * @return void
     */
    abstract public function populateFromRecipient($recipient);
}
