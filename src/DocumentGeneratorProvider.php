<?php
declare(strict_types=1);

namespace ByTIC\DocumentGenerator;

use ByTIC\DocumentGenerator\PdfLetters\Console\DownloadStatsProcess;
use ByTIC\DocumentGenerator\PdfLetters\PdfLettersManager;
use ByTIC\DocumentGenerator\Utility\PackageConfig;
use ByTIC\DocumentGenerator\Utility\PathsHelpers;
use Nip\Container\ServiceProviders\Providers\AbstractSignatureServiceProvider;

/**
 * Class DocumentGeneratorProvider
 * @package ByTIC\DocumentGenerator
 */
class DocumentGeneratorProvider extends AbstractSignatureServiceProvider
{
    public const NAME = 'document-generator';

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

    public function migrations(): ?string
    {
        if (!PackageConfig::shouldRunMigrations()) {
            return null;
        }

        return PathsHelpers::migrations();
    }
}
