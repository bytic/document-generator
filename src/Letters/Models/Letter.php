<?php

declare(strict_types=1);

namespace ByTIC\DocumentGenerator\Letters\Models;

use ByTIC\DocumentGenerator\Base\Models\BaseModel;
use ByTIC\DocumentGenerator\Letters\Models\Letters\LetterTrait;
use ByTIC\DocumentGenerator\Utility\DocumentGeneratorModels;
use ByTIC\DocumentGenerator\Utility\PackageConfig;
use ByTIC\MediaLibrary\HasMedia\Interfaces\HasMedia;
use ByTIC\MediaLibrary\MediaRepository\MediaRepository;
use DateTime;

class Letter extends BaseModel implements HasMedia
{
    use LetterTrait;

    public function getItemsManager()
    {
        return $this->getManager() instanceof Letters ? $this->getManager() : Letters::instance();
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
        return PackageConfig::tableName(DocumentGeneratorModels::LETTERS, 'letter_letters');
    }
}
