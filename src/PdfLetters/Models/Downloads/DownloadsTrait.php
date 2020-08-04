<?php

namespace ByTIC\DocumentGenerator\PdfLetters\Models\Downloads;

use ByTIC\DocumentGenerator\PdfLetters\Models\PdfLetters\PdfLetterTrait;
use Nip\Records\Record;
use Nip\Records\Traits\AbstractTrait\RecordsTrait as AbstractRecordsTrait;

/**
 * Class DownloadsTrait
 * @package ByTIC\DocumentGenerator\PdfLetters\Models\Downloads
 *
 * @method DownloadTrait|Record getNew
 */
trait DownloadsTrait
{
    use AbstractRecordsTrait;

    /**
     * @param Record $recipient
     * @param PdfLetterTrait $letter
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
     * @param PdfLetterTrait $letter
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
