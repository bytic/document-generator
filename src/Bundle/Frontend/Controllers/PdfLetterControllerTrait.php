<?php

namespace ByTIC\DocumentGenerator\Bundle\Frontend\Controllers;

use ByTIC\DocumentGenerator\PdfLetters\Models\PdfLetters\PdfLettersTrait;
use ByTIC\DocumentGenerator\PdfLetters\Models\PdfLetters\PdfLetterTrait;

/**
 * Trait AdminPdfLetterControllerTrait
 * @package ByTIC\DocumentGenerator\PdfLetters
 *
 * @method PdfLetterTrait getModelFromRequest()
 * @method PdfLettersTrait getModelManager()
 */
trait PdfLetterControllerTrait
{
    use AbstractControllerTrait;

    public function generate()
    {
        $recipient = $this->getLetterRecipientFromRequest();

        /** @var PdfLetterTrait $diploma */
        $diploma = $this->getLetterFromRecipient($recipient);

        $diploma->addDownload($result);

        $diploma->download($recipient);
        die();
    }

    /**
     * @return \Nip\Records\AbstractModels\Record
     */
    abstract protected function getLetterRecipientFromRequest();

    abstract protected function getLetterFromRecipient($recipient);
}
