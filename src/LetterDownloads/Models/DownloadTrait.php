<?php

namespace ByTIC\DocumentGenerator\LetterDownloads\Models;

use ByTIC\DocumentGenerator\Letters\Models\Letters\LetterTrait;
use Nip\Records\Record;

/**
 * Class DownloadTrait
 * @package ByTIC\DocumentGenerator\Letters\Models\Downloads
 *
 * @property string $datetime
 */
trait DownloadTrait
{
    /**
     * @param Record|LetterTrait $letter
     */
    public function populateFromLetter($letter)
    {
        $this->id_letter = $letter->getPrimaryKey();
    }

    /**
     * @param Record $recipient
     * @return void
     */
    abstract public function populateFromRecipient($recipient);
}
