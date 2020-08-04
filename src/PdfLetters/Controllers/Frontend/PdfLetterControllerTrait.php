<?php

namespace ByTIC\DocumentGenerator\PdfLetters\Controllers\Frontend;

use ByTIC\DocumentGenerator\PdfLetters\Models\PdfLetters\PdfLettersTrait;
use ByTIC\DocumentGenerator\PdfLetters\Models\PdfLetters\PdfLetterTrait;
use ByTIC\MediaLibrary\Media\Media;
use Nip\Controllers\Traits\AbstractControllerTrait;
use Nip\Records\Record;
use Nip\Records\RecordManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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
