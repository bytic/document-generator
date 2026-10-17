<?php

namespace ByTIC\DocumentGenerator\Bundle\Frontend\Controllers;

use ByTIC\DocumentGenerator\PdfLetters\Models\PdfLetters\PdfLettersTrait;
use ByTIC\DocumentGenerator\PdfLetters\Models\PdfLetters\PdfLetterTrait;
use ByTIC\DocumentGenerator\Bundle\Frontend\Controllers\AbstractControllerTrait as BundleFrontendAbstractControllerTrait;

/**
 * Trait FrontendPdfLetterControllerTrait
 * @package ByTIC\DocumentGenerator\PdfLetters
 *
 * @method PdfLetterTrait getModelFromRequest()
 * @method PdfLettersTrait getModelManager()
 */
trait PdfLetterControllerTrait
{
    use BundleFrontendAbstractControllerTrait;

    public function generate()
    {
        $recipient = $this->getLetterRecipientFromRequest();

        /** @var PdfLetterTrait $diploma */
        $diploma = $this->getLetterFromRecipient($recipient);

        $diploma->addDownload($recipient);

        $diploma->download($recipient);
        die();
    }

    /**
     * @return \Nip\Records\AbstractModels\Record
     */
    abstract protected function getLetterRecipientFromRequest();

    abstract protected function getLetterFromRecipient($recipient);
}
