<?php

namespace ByTIC\DocumentGenerator\PdfLetters\Fields;

use ByTIC\DocumentGenerator\PdfLetters\PdfLetterTrait;
use Nip\Controllers\Traits\AbstractControllerTrait;
use Nip\Records\AbstractModels\Record;

/**
 * Trait AdminPdfLetterFieldsControllerTrait
 * @package ByTIC\DocumentGenerator\PdfLetters
 */
trait AdminPdfLetterFieldsControllerTrait
{
    use AbstractControllerTrait;

    /**
     * @var PdfLetterTrait
     */
    protected $pdfLetter;

    /**
     * @var Record
     */
    protected $parent;

    /**
     * @return PdfLetterTrait
     */
    public function addNewModel()
    {
        /** @var PdfLetterTrait $item */
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
    protected function parseRequestPdfLetterField()
    {
        if ($this->getRequest()->get('id_letter')) {
            $this->pdfLetter = $this->checkForeignModelFromRequest(
                $this->getModelManager()->getLetterManager()->getTable(),
                'id_letter'
            );
        } else {
            $field = $this->getModelFromRequest();
            $this->pdfLetter = $field->getPdfLetter();
        }

        $this->parent = $this->pdfLetter->getItem();
    }

    /**
     * @param bool $key
     * @return FieldTrait|Record
     */
    abstract protected function getModelFromRequest($key = false);

    /**
     * @param $name
     * @param bool $key
     * @return mixed
     */
    abstract protected function checkForeignModelFromRequest($name, $key = false);
}