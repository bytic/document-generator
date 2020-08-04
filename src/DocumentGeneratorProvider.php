<?php

namespace ByTIC\DocumentGenerator;

use ByTIC\DocumentGenerator\PdfLetters\Console\DownloadStatsProcess;
use ByTIC\DocumentGenerator\PdfLetters\PdfLettersManager;
use Nip\Container\ServiceProviders\Providers\AbstractSignatureServiceProvider;

/**
 * Class DocumentGeneratorProvider
 * @package ByTIC\DocumentGenerator
 */
class DocumentGeneratorProvider extends AbstractSignatureServiceProvider
{
    /**
     * @inheritdoc
     */
    public function provides()
    {
        return ['dg.pdf-letters.manager'];
    }

    /**
     * @inheritdoc
     */
    public function register()
    {
        $this->registerPdfLettersManager();
    }

    protected function registerPdfLettersManager()
    {
        $this->getContainer()->share('dg.pdf-letters.manager', function () {
            return new PdfLettersManager();
        });
    }

    protected function registerCommands()
    {
        $this->commands(
            DownloadStatsProcess::class
        );
    }
}
