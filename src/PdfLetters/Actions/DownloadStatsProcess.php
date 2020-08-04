<?php

namespace ByTIC\DocumentGenerator\PdfLetters\Actions;

use Nip\MailModule\Models\EmailsTable\EmailsTrait;
use Nip\Records\Locator\ModelLocator;

/**
 * Class DownloadStatsProcess
 * @package ByTIC\DocumentGenerator\PdfLetters\Actions
 */
class DownloadStatsProcess
{

    /**
     * @return int
     */
    public function handle()
    {
        /** @var EmailsTrait $emailsManager */
        $emailsManager = ModelLocator::get('emails');
        $result = $emailsManager->reduceOldEmailsData();
        return $result->numRows();
    }
}
