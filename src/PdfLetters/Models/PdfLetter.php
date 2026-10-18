<?php

declare(strict_types=1);

namespace ByTIC\DocumentGenerator\PdfLetters\Models;

use ByTIC\DocumentGenerator\PdfLetters\Models\PdfLetters\PdfLetterTrait;
use ByTIC\MediaLibrary\HasMedia\Interfaces\HasMedia;
use ByTIC\MediaLibrary\MediaRepository\MediaRepository;
use DateTime;
use Nip\Records\Record;

class PdfLetter extends Record implements HasMedia
{
    use PdfLetterTrait;

    public function getItemsManager()
    {
        return $this->getManager() instanceof PdfLetters ? $this->getManager() : PdfLetters::instance();
    }

    public function getModelExample()
    {
        return $this->getItem();
    }

    public function getIssueDate(): DateTime
    {
        return new DateTime();
    }

    public function getMediaFilesystemDisk()
    {
        return null;
    }

    public function registerMediaCollections(MediaRepository $mediaRepository): void
    {
    }
}
