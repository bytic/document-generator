<?php

namespace ByTIC\DocumentGenerator\Tests\Fixtures\Models\MediaRecords;

use ByTIC\MediaLibrary\HasMedia\HasMediaTrait;
use ByTIC\MediaLibrary\HasMedia\Interfaces\HasMedia;
use League\Flysystem\Adapter\Local as LocalAdapter;
use Nip\Filesystem\FileDisk;
use Nip\Records\Record;

/**
 * Class MediaRecord
 * @package ByTIC\DocumentGenerator\Tests\Fixtures\Models\MediaRecords
 */
class MediaRecord extends Record implements HasMedia
{
    use HasMediaTrait;

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
}
