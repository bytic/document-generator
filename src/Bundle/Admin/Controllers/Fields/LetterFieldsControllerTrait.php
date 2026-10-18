<?php

namespace ByTIC\DocumentGenerator\Bundle\Admin\Controllers\Fields;

use ByTIC\DocumentGenerator\Bundle\Admin\Controllers\AbstractControllerTrait;
use ByTIC\DocumentGenerator\Letters\Models\Letters\LetterTrait;
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
    protected $pdfLetter;

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
        if ($this->pdfLetter) {
            $item->populateFromLetter($this->pdfLetter);
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
            $this->pdfLetter = $this->checkForeignModelFromRequest(
                $this->getModelManager()->getLetterManager()->getTable(),
                'id_letter'
            );
        } else {
            $field = $this->getModelFromRequest();
            $this->pdfLetter = $field->getLetter();
        }

        $this->parent = $this->pdfLetter->getItem();
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
