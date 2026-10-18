<?php

namespace ByTIC\DocumentGenerator\Tests\Fixtures\Models\Letters;

use ByTIC\DocumentGenerator\Letters\Models\LetterTrait;
use ByTIC\MediaLibrary\HasMedia\Interfaces\HasMedia;
use ByTIC\MediaLibrary\Loaders\Filesystem;
use ByTIC\MediaLibrary\MediaRepository\MediaRepository;
use DateTime;
use League\Flysystem\Local\LocalFilesystemAdapter as LocalAdapter;
use Nip\Filesystem\FileDisk;
use Nip\Records\Record;
use Nip\Records\Traits\AbstractTrait\RecordTrait as AbstractRecordTrait;

/**
 * Class Letter
 * @package ByTIC\DocumentGenerator\Tests\Fixtures\Models\Letters
 */
class Letter extends Record implements HasMedia
{
    use LetterTrait;

    /**
     * @return FileDisk
     */
    public function getMediaFilesystemDisk()
    {
        if (!isset($this->disk)) {
            $this->disk = new FileDisk(
                new LocalAdapter(
                    TEST_FIXTURE_PATH
                )
            );
        }
        return $this->disk;
    }

    public function getItemsManager()
    {
    }

    /**
     * @param MediaRepository $mediaCollection
     */
    public function registerMediaCollections($mediaRepository)
    {
        $mediaRepository->getCollection('files')->setLoaderClass(Filesystem::class);
    }

    /**
     * @return AbstractRecordTrait
     */
    public function getModelExample()
    {
    }

    public function getIssueDate(): DateTime
    {
        return $this->issueDate;
    }
}
