<?php

namespace ByTIC\DocumentGenerator\PdfLetters\Models\Fields;

use ByTIC\DocumentGenerator\PdfLetters\Models\Fields\Types\AbstractType;
use ByTIC\DocumentGenerator\PdfLetters\Models\PdfLetters\PdfLetterTrait;
use Nip\Records\Traits\AbstractTrait\RecordTrait as Record;
use ByTIC\Models\SmartProperties\RecordsTraits\HasTypes\RecordTrait as HasTypeRecordTrait;
use setasign\Fpdi\Fpdi;

/**
 * Class FieldTrait
 * @package ByTIC\DocumentGenerator\PdfLetters\Models\Fields
 *
 * @property string $id_letter
 * @property string $field
 * @property string $size
 * @property string $color
 * @property string $align
 * @property string $x
 * @property string $y
 *
 * @method FieldsTrait getManager()
 * @method AbstractType getType()
 */
trait FieldTrait
{
    use HasTypeRecordTrait;

    /**
     * @return string
     */
    public function getName()
    {
        return translator()->trans($this->field);
    }

    /**
     * @return mixed
     */
    public function getTypeValue()
    {
        return $this->getManager()->getFieldTypeFromMergeTag($this->field);
    }

    /**
     * @param PdfLetterTrait $letter
     */
    public function populateFromLetter($letter)
    {
        $this->id_letter = $letter->id;
    }

    /**
     * @param Fpdi $pdf
     * @param Record $model
     */
    public function addToPdf($pdf, $model)
    {
        $this->getType()->addToPdf($pdf, $model);
    }

    /**
     * @param Record $model
     * @return string
     */
    public function getValue($model)
    {
        if ($model->id > 0) {
            $valueType = $this->getType()->getValue($model);

            return $valueType;
        }

        return '<<' . $this->field . '>>';
    }

    /**
     * @return PdfLetterTrait
     */
    abstract public function getPdfLetter();

    /**
     * @return bool
     */
    public function hasColor()
    {
        return substr_count($this->color, ',') == 2;
    }

    /**
     * @return array|null
     */
    public function getColorArray()
    {
        if ($this->hasColor()) {
            list($red, $green, $blue) = explode(',', $this->color);
            if ($red && $green && $blue) {
                return [intval($red), intval($green), intval($blue)];
            }
        }

        return null;
    }

    /**
     * @param Fpdi $pdf
     */
    protected function pdfPrepareFont($pdf)
    {
        $pdf->SetFont('freesans', '', $this->size, '', true);
    }
}
