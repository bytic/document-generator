<?php

namespace ByTIC\DocumentGenerator\PdfLetters\Models\PdfLetters;

use Nip\Records\Traits\AbstractTrait\RecordsTrait as AbstractRecordsTrait;

/**
 * Class PdfLettersTrait
 * @package ByTIC\DocumentGenerator\PdfLetters\Models\PdfLetters
 *
 * @method PdfLetterTrait[] findByParams($params)
 */
trait PdfLettersTrait
{
    use AbstractRecordsTrait;

    /**
     * @param string $type
     * @param int $idItem
     * @return bool|PdfLetterTrait
     */
    public function getByItem($type, $idItem)
    {
        /** @var PdfLetterTrait[] $letters */
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
    }

    protected function initCustomFieldsRelation()
    {
        $this->hasMany('CustomFields', $this->getCustomFieldsRelationParams());
    }

    protected function initDownloadsRelation()
    {
        $this->hasMany('Downloads', [
            'class' => $this->getDownloadsManagerClass(),
            'fk' => $this->getPrimaryFK(),
        ]);
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

    /**
     * @return string
     */
    abstract protected function getDownloadsManagerClass();

    /**
     * @return string
     */
    abstract public function getPrimaryFK();
}
