<?php
declare(strict_types=1);

namespace ByTIC\DocumentGenerator\Letters\Models;

use ByTIC\DocumentGenerator\LetterDownloads\Models\DownloadsTrait;
use ByTIC\DocumentGenerator\Letters\Actions\Finder\GetLetterByParent;
use ByTIC\DocumentGenerator\LetterStats\Models\StatsTrait;
use ByTIC\DocumentGenerator\Utility\DocumentGeneratorModels;
use ByTIC\MediaLibrary\HasMedia\HasMediaRecordsTrait;
use Nip\Records\AbstractModels\RecordManager;
use Nip\Records\Traits\AbstractTrait\RecordsTrait as AbstractRecordsTrait;

/**
 * Class LettersTrait
 * @package ByTIC\DocumentGenerator\Letters\Models\Letters
 *
 * @method LetterTrait[] findByParams($params)
 */
trait LettersTrait
{
    use AbstractRecordsTrait;
    use HasMediaRecordsTrait;

    /**
     * @param string $type
     * @param int $idItem
     * @return bool|LetterTrait
     */
    public function getByItem($type, $idItem)
    {
        return GetLetterByParent::byItemType($type, $idItem)->handle();
    }

    /**
     * @return DownloadsTrait|RecordManager
     */
    public function getDownloadsManager()
    {
        return $this->getRelation('Downloads')->getWith();
    }

    /**
     * @return StatsTrait|RecordManager
     */
    public function getStatsManager()
    {
        return $this->getRelation('Stats')->getWith();
    }

    /**
     * @param $type
     * @return AbstractRecordsTrait
     */
    abstract public function getParentManagerFromType($type);

    protected function initRelations()
    {
        /** @noinspection PhpUndefinedClassInspection */
        parent::initRelations();
        $this->initRelationsDocument();
    }

    protected function initRelationsDocument()
    {
        $this->initLetterFieldsRelation();
        $this->initDownloadsRelation();
        $this->initStatsRelation();
    }

    protected function initLetterFieldsRelation()
    {
        $this->hasMany('LetterFields', $this->getLetterFieldsRelationParams());
    }

    protected function initDownloadsRelation()
    {
        $this->hasMany('Downloads', [
            'class' => DocumentGeneratorModels::letterDownloadsClass(),
            'fk' => $this->getPrimaryFK(),
        ]);
    }

    protected function initStatsRelation()
    {
        $this->hasMany('LetterStats', [
            'class' => DocumentGeneratorModels::letterStatsClass(),
            'fk' => $this->getPrimaryFK(),
        ]);
    }

    /**
     * @return array
     */
    protected function getLetterFieldsRelationParams()
    {
        return [
            'class' => DocumentGeneratorModels::letterFieldsClass(),
            'fk' => $this->getPrimaryFK(),
        ];
    }

    /**
     * @return string
     */
    abstract public function getPrimaryFK();
}
