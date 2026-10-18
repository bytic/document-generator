<?php

declare(strict_types=1);

namespace ByTIC\DocumentGenerator\PdfLetters\Models;

use ByTIC\DocumentGenerator\Base\Models\BaseModel;
use ByTIC\DocumentGenerator\PdfLetters\Models\PdfLetters\PdfLetterTrait;
use ByTIC\DocumentGenerator\Utility\PackageConfig;
use ByTIC\MediaLibrary\HasMedia\Interfaces\HasMedia;
use ByTIC\MediaLibrary\MediaRepository\MediaRepository;
use DateTime;

class PdfLetter extends BaseModel implements HasMedia
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

    public function generateTable(): string
    {
        return PackageConfig::tableName('letters', 'letter_letters');
    }
}
