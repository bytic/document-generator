<?php

namespace ByTIC\DocumentGenerator\Tests\Fixtures\Models\PdfLetters;

use ByTIC\DocumentGenerator\PdfLetters\Models\PdfLetters\PdfLetterTrait;
use ByTIC\MediaLibrary\Collections\Collection;
use ByTIC\MediaLibrary\HasMedia\Interfaces\HasMedia;
use ByTIC\MediaLibrary\Loaders\Filesystem;
use ByTIC\MediaLibrary\MediaRepository\MediaRepository;
use DateTime;
use Nip\Filesystem\FileDisk;
use League\Flysystem\Adapter\Local as LocalAdapter;
use Nip\Records\Record;
use Nip\Records\Traits\AbstractTrait\RecordTrait as AbstractRecordTrait;

/**
 * Class PdfLetter
 * @package ByTIC\DocumentGenerator\Tests\Fixtures\Models\PdfLetters
 */
class PdfLetter extends Record implements HasMedia
{
    use PdfLetterTrait;

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
