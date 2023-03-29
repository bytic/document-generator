<?php
declare(strict_types=1);

namespace ByTIC\DocumentGenerator\PdfLetters\Writer;

use ByTIC\DocumentGenerator\PdfLetters\Models\Fields\FieldTrait;
use setasign\Fpdi\Tcpdf\Fpdi;

abstract class AbstractObject
{
    protected Fpdi $pdf;

    protected $value;

    protected $x;
    protected $y;

    /**
     * @param FieldTrait $field
     * @param Fpdi $pdf
     */
    public static function fromField($field, $value, $pdf)
    {
        $instance = new static();
        $instance->pdf = $pdf;
        $instance->value = $value;
        $instance->populateFromField($field);
        return $instance;
    }

    /**
     * @param FieldTrait $field
     * @return void
     */
    protected function populateFromField($field): void
    {
        $this->x = $field->x;
        $this->y = $field->y;
    }

    abstract public function write();

}