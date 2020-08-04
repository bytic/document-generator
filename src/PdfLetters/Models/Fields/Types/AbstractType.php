<?php

namespace ByTIC\DocumentGenerator\PdfLetters\Models\Fields\Types;

use ByTIC\DocumentGenerator\PdfLetters\Models\Fields\FieldTrait;
use Nip\Records\Traits\AbstractTrait\RecordTrait as Record;
use setasign\Fpdi\Tcpdf\Fpdi;

/**
 * Class AbstractType
 * @package ByTIC\DocumentGenerator\PdfLetters\Models\Fields\Types
 *
 * @method FieldTrait getItem()
 */
abstract class AbstractType extends \ByTIC\Models\SmartProperties\Properties\Types\Generic
{
    use TextTypeTrait;

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
