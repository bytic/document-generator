<?php

namespace ByTIC\DocumentGenerator\Bundle\Admin\Controllers;

use ByTIC\DocumentGenerator\PdfWriter\Models\LetterTrait;
use Nip\Records\AbstractModels\Record;

/**
 * Trait LetterFieldsControllerTrait
 * @package ByTIC\DocumentGenerator\Letters
 */
trait LetterFieldsControllerTrait
{
    use AbstractControllerTrait;

    /**
     * @var LetterTrait
     */
    protected $letter;

    /**
     * @var Record
     */
    protected $parent;

    /**
     * @return LetterTrait
     */
    public function addNewModel()
    {
        /** @var LetterTrait $item */
        $item = $this->getModelManager()->getNew();
        if ($this->letter) {
            $item->populateFromLetter($this->letter);
            $this->getView()->Breadcrumbs()->addItem(
                $this->getModelManager()->getLetterManager()->getLabel('add'),
                '#'
            );
            return $item;
        }

        return $this->forward('index', 'error');
    }


    /**
     * Called before action
     */
    protected function parseRequestLetterField()
    {
        if ($this->getRequest()->get('id_letter')) {
            $this->letter = $this->checkForeignModelFromRequest(
                $this->getModelManager()->getLetterManager()->getTable(),
                'id_letter'
            );
        } else {
            $field = $this->getModelFromRequest();
            $this->letter = $field->getLetter();
        }

        $this->parent = $this->letter->getItem();
    }

    /**
     * @param bool $key
     * @return Record
     */
    abstract protected function getModelFromRequest($key = false);

    /**
     * @param $name
     * @param bool $key
     * @return mixed
     */
    abstract protected function checkForeignModelFromRequest($name, $key = false);
}
