<?php

namespace ByTIC\DocumentGenerator\PdfLetters\Actions;

use ByTIC\DocumentGenerator\PdfLetters\Models\Downloads\DownloadsTrait;
use ByTIC\DocumentGenerator\PdfLetters\Models\PdfLetters\PdfLettersTrait;
use ByTIC\DocumentGenerator\PdfLetters\PdfLettersManager;
use Nip\MailModule\Models\EmailsTable\EmailsTrait;
use Nip\Records\AbstractModels\RecordManager;
use Nip\Records\Locator\ModelLocator;

/**
 * Class DownloadStatsProcess
 * @package ByTIC\DocumentGenerator\PdfLetters\Actions
 */
class DownloadStatsProcess
{

    /**
     * @var PdfLettersManager[]
     */
    protected $managers = [];

    /**
     * DownloadStatsProcess constructor.
     * @param array $managers
     */
    public function __construct(array $managers = null)
    {
        $this->managers = is_array($managers) ? $managers : app('dg.pdf-letters.manager')->getManagerClasses();
    }

    public function handle()
    {
        foreach ($this->managers as $manager) {
            $manager = is_object($manager) ? $manager : ModelLocator::get($manager);
            $this->processForManager($manager);
        }
    }

    /**
     * @param RecordManager|PdfLettersTrait $letterManager
     */
    protected function processForManager(RecordManager $letterManager)
    {
        if (!$letterManager->hasRelation('Downloads')) {
            return;
        }
        $downloadsManager = $letterManager->getDownloadsManager();
        $letters = $this->getLastLettersFromDownloads($letterManager, $downloadsManager);

        $statsManager = $letterManager->getStatsManager();
        foreach ($letters as $letter) {
            if ($downloadsManager->shouldTrackLetter($letter)) {
                continue;
            }
            $statsManager->compileForLetter($letter);
        }
    }

    /**
     * @param PdfLettersTrait|RecordManager $letterManager
     * @param DownloadsTrait|RecordManager $downloadsManager
     */
    protected function getLastLettersFromDownloads($letterManager, $downloadsManager)
    {
        $letterPK = $letterManager->getRelation('Downloads')->getFK();

        $queryDownloads = $downloadsManager->newSelectQuery();
        $queryDownloads->setCols($letterPK);
        $queryDownloads->group($letterPK);
        $queryDownloads->limit(10);

        $queryLetters = $letterManager->newSelectQuery();
        $queryLetters->where('id IN ?', $queryDownloads);

        return $letterManager->findByQuery($queryLetters);
    }
}
