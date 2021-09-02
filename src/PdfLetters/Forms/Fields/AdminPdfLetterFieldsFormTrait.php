<?php

namespace ByTIC\DocumentGenerator\PdfLetters\Forms\Fields;

use ByTIC\DocumentGenerator\PdfLetters\Models\Fields\Attributes\TextTransform;

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
        $this->initTextTransformElement();
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

    protected function initTextTransformElement()
    {
        $this->addSelect(TextTransform::NAME, translator()->trans('text-transform'), true);
        foreach (TextTransform::OPTIONS as $option) {
            $this->getElement(TextTransform::NAME)->addOption($option, translator()->trans($option));
        }
    }
}
