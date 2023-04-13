<?php

namespace ByTIC\DocumentGenerator\PdfLetters\Models\Fields;

use ByTIC\DataObjects\Casts\Metadata\Metadata;
use ByTIC\DocumentGenerator\PdfLetters\Models\Fields\Attributes\TextTransform;
use ByTIC\DocumentGenerator\PdfLetters\Models\Fields\Types\AbstractType;
use ByTIC\DocumentGenerator\PdfLetters\Models\PdfLetters\PdfLetterTrait;
use ByTIC\Models\SmartProperties\RecordsTraits\HasTypes\RecordTrait as HasTypeRecordTrait;
use Nip\Records\Traits\AbstractTrait\RecordTrait as Record;
use ByTIC\DataObjects\Casts\Metadata\AsMetadataObject;
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
 * @property string|Metadata $metadata
 *
 * @method FieldsTrait getManager()
 * @method AbstractType getType()
 */
trait FieldTrait
{
    use HasTypeRecordTrait;

    public function bootFieldTrait()
    {
        $this->addCast('metadata', AsMetadataObject::class . ':json');
    }

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
            $valueType = html_entity_decode($valueType);

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

    public function setTextTransform($value)
    {
        $this->addMetaData(TextTransform::NAME, $value);
    }

    /**
     * @param $key
     * @param $value
     */
    public function addMetaData($key, $value)
    {
        $this->metadata->set($key, $value);
    }


    /**
     * @param $key
     * @param null $default
     * @return Metadata|mixed|string|null
     */
    public function getMetaData($key, $default = null)
    {
        return $this->metadata->get($key, $default);
    }

    /**
     * @param Fpdi $pdf
     */
    protected function pdfPrepareFont($pdf)
    {
        $pdf->SetFont('freesans', '', $this->size, '', true);
    }
}
