<?php

namespace ByTIC\DocumentGenerator;

use ByTIC\DocumentGenerator\PdfLetters\Console\ProcessDownloadStats;
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
    public function register()
    {
    }


    /**
     * @inheritdoc
     */
    public function provides()
    {
        return [];
    }

    protected function registerCommands()
    {
        $this->commands(
            ProcessDownloadStats::class
        );
    }
}
