<?php
declare(strict_types=1);

namespace ByTIC\DocumentGenerator;

use ByTIC\DocumentGenerator\PdfWriter\Console\DownloadStatsProcess;
use ByTIC\DocumentGenerator\PdfWriter\LettersManager;
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
        return ['dg.letters.manager'];
    }

    /**
     * @inheritdoc
     */
    public function register()
    {
        $this->registerLettersManager();
    }

    protected function registerLettersManager()
    {
        $this->getContainer()->share('dg.letters.manager', function () {
            return new LettersManager();
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
