<?php

namespace ByTIC\DocumentGenerator\PdfLetters\Forms\Fields;

/**
 * Trait AdminPdfLetterFieldsControllerTrait
 * @package ByTIC\DocumentGenerator\PdfLetters\Forms\Fields
 */
trait AdminPdfLetterFieldsFormTrait
{

    protected function initGenericElements()
    {
        $this->initPositionElements();
        $this->initSizeElement();
        $this->initColorElement();
        $this->initAlignElement();
    }

    protected function initPositionElements()
    {
        $this->addInput('x', 'X', true);
        $this->addInput('y', 'Y', true);
    }

    protected function initColorElement()
    {
        $this->addInput('color', translator()->trans('color'), false);
    }

    protected function initSizeElement()
    {
        $this->addSelect('size', translator()->trans('size'), true);
        foreach (range(9, 500) as $size) {
            $this->size->addOption($size, $size);
        }
    }

    protected function initAlignElement()
    {
        $this->addSelect('align', translator()->trans('align'), true);
        foreach (['left', 'center', 'right'] as $option) {
            $this->getElement('align')->addOption($option, translator()->trans($option));
        }
    }
}
