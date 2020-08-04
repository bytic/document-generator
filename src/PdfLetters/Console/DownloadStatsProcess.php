<?php

namespace ByTIC\DocumentGenerator\PdfLetters\Console;

use ByTIC\Console\Command;

/**
 * Class DownloadStatsProcess
 * @package ByTIC\DocumentGenerator\PdfLetters\Console
 */
class DownloadStatsProcess extends Command
{
    protected function configure()
    {
        parent::configure();
        $this->setName('document-generator:pdf-letters:downloads-stats-process');
    }

    protected function handle()
    {
        (new \ByTIC\DocumentGenerator\PdfLetters\Actions\DownloadStatsProcess())->handle();
    }
}
