<?php

namespace ByTIC\DocumentGenerator\LetterDownloads\Models;

use ByTIC\DocumentGenerator\PdfWriter\Models\LetterTrait;
use Nip\Records\Record;
use Nip\Records\Traits\AbstractTrait\RecordsTrait as AbstractRecordsTrait;

/**
 * Class DownloadsTrait
 * @package ByTIC\DocumentGenerator\Letters\Models\Downloads
 *
 * @method DownloadTrait|Record getNew
 */
trait DownloadsTrait
{
    use AbstractRecordsTrait;

    /**
     * @param Record $recipient
     * @param LetterTrait $letter
     */
    public function createForRecipient($recipient, $letter)
    {
        $download = $this->getNew();
        $download->populateFromLetter($letter);
        $download->populateFromRecipient($recipient);
        $download->datetime = date('Y-m-d H:i:s');
        $download->insert();
    }

    /**
     * @param LetterTrait $letter
     * @return bool
     */
    public function shouldTrackLetter($letter)
    {
        $issueDate = $letter->getIssueDate();
        $now = new \DateTime();
        $diff = $issueDate->diff($now);
        if ($diff->days < 60) {
            return true;
        }
        return false;
    }
}
