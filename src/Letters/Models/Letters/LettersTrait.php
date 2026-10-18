<?php

namespace ByTIC\DocumentGenerator\Letters\Models\Letters;

use ByTIC\DocumentGenerator\LetterDownloads\Models\DownloadsTrait;
use ByTIC\DocumentGenerator\LetterStats\Models\StatsTrait;
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
        /** @var LetterTrait[] $letters */
        $letters = $this->findByParams(
            [
                'where' => [
                    ['id_item = ?', $idItem],
                    ['type = ?', $type],
                ],
                'order' => [['id', 'DESC']],
            ]
        );

        $return = false;

        if (count($letters)) {
            foreach ($letters as $letter) {
                if ($letter->hasFile() && !$return) {
                    $return = $letter;
                } else {
//                    $item->delete();
                }
            }
        }

        return $return;
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
        $this->initRelationsTrait();
    }

    protected function initRelationsTrait()
    {
        $this->initCustomFieldsRelation();
        $this->initDownloadsRelation();
        $this->initStatsRelation();
    }

    protected function initCustomFieldsRelation()
    {
        $this->hasMany('CustomFields', $this->getCustomFieldsRelationParams());
    }

    protected function initDownloadsRelation()
    {
        if (method_exists($this, 'getDownloadsManagerClass')) {
            $this->hasMany('Downloads', [
                'class' => $this->getDownloadsManagerClass(),
                'fk' => $this->getPrimaryFK(),
            ]);
        }
    }

    protected function initStatsRelation()
    {
        if (method_exists($this, 'getStatsManagerClass')) {
            $this->hasMany('Stats', [
                'class' => $this->getStatsManagerClass(),
                'fk' => $this->getPrimaryFK(),
            ]);
        }
    }

    /**
     * @return array
     */
    protected function getCustomFieldsRelationParams()
    {
        return [
            'class' => $this->getCustomFieldsManagerClass(),
            'fk' => $this->getPrimaryFK(),
        ];
    }

    /**
     * @return string
     */
    abstract protected function getCustomFieldsManagerClass();

//    /**
//     * @return string
//     */
//    abstract protected function getDownloadsManagerClass();

//    /**
//     * @return string
//     */
//    abstract protected function getStatsManagerClass();

    /**
     * @return string
     */
    abstract public function getPrimaryFK();
}
