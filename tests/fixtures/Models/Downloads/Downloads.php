<?php

namespace ByTIC\DocumentGenerator\Tests\Fixtures\Models\Downloads;

use ByTIC\DocumentGenerator\LetterDownloads\Models\DownloadsTrait;
use Nip\Records\RecordManager;
use Nip\Utility\Traits\SingletonTrait;

/**
 * Class Downloads
 * @package ByTIC\DocumentGenerator\Tests\Fixtures\Models\Downloads
 */
class Downloads extends RecordManager
{
    use DownloadsTrait;
    use SingletonTrait;
}
