<?php

namespace ByTIC\DocumentGenerator\PdfLetters\Fields\Types;

use ByTIC\DocumentGenerator\PdfLetters\Fields\FieldTrait;
use ByTIC\Common\Records\Properties\Types\Generic;

/**
 * Class AbstractType
 * @package ByTIC\DocumentGenerator\PdfLetters\Fields\Types
 *
 * @method FieldTrait getItem()
 */
abstract class AbstractType extends Generic
{

    /**
     * @param $model
     * @return null
     */
    public function getValue($model)
    {
        return null;
    }

    /**
     * @return string
     */
    public function providesTags()
    {
        return $this->getName();
    }

    /**
     * @return string
     */
    abstract public function getCategory();

    /**
     * @return mixed
     */
    protected function getFieldName()
    {
        return $this->getItem()->field;
    }
}
