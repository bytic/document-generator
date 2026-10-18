<?php

namespace ByTIC\DocumentGenerator\Letters\Console;

use ByTIC\Console\Command;

/**
 * Class DownloadStatsProcess
 * @package ByTIC\DocumentGenerator\Letters\Console
 */
class DownloadStatsProcess extends Command
{
    protected function configure()
    {
        parent::configure();
        $this->setName('document-generator:letters:downloads-stats-process');
    }

    protected function handle()
    {
        (new \ByTIC\DocumentGenerator\Letters\Actions\DownloadStatsProcess())->handle();
    }
}
