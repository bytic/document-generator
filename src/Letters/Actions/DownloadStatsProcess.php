<?php

namespace ByTIC\DocumentGenerator\Letters\Actions;

use ByTIC\DocumentGenerator\Letters\Models\Downloads\DownloadsTrait;
use ByTIC\DocumentGenerator\Letters\Models\Letters\LettersTrait;
use ByTIC\DocumentGenerator\Letters\LettersManager;
use Nip\MailModule\Models\EmailsTable\EmailsTrait;
use Nip\Records\AbstractModels\RecordManager as AbstractRecordManager;
use Nip\Records\RecordManager;
use Nip\Records\Locator\ModelLocator;

/**
 * Class DownloadStatsProcess
 * @package ByTIC\DocumentGenerator\Letters\Actions
 */
class DownloadStatsProcess
{
    /**
     * @var LettersManager[]
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
     * @param RecordManager|AbstractRecordManager|LettersTrait $letterManager
     */
    protected function processForManager(AbstractRecordManager $letterManager)
    {
        /** @noinspection PhpUnhandledExceptionInspection */
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
     * @param LettersTrait|RecordManager $letterManager
     * @param DownloadsTrait|RecordManager $downloadsManager
     */
    protected function getLastLettersFromDownloads($letterManager, $downloadsManager)
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $letterPK = $letterManager->getRelation('Downloads')->getFK();

        $queryDownloads = $downloadsManager->newSelectQuery();
        $queryDownloads->setCols($letterPK);
        $queryDownloads->group($letterPK);

        $queryLetters = $letterManager->newSelectQuery();
        $queryLetters->where('id IN ?', $queryDownloads);
        $queryLetters->limit(10);

        return $letterManager->findByQuery($queryLetters);
    }
}
