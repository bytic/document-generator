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

    public const DEFAULT_PAGE = 1;

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

    public function setPage($value): void
    {
        $page = (int)$value;
        $this->addMetaData('page', $page > 0 ? $page : static::DEFAULT_PAGE);
    }

    public function getPage(): int
    {
        $page = (int)$this->getMetaData('page', 0);
        if ($page < 1) {
            $page = $this->inferPageFromYPosition();
        }

        return $page > 0 ? $page : static::DEFAULT_PAGE;
    }

    public function getEditorYPosition(): float
    {
        $y = (float)$this->y;
        $page = $this->getPage();
        if ($page > 1) {
            $y -= (($page - 1) * 297);
        }

        return round($y, 2);
    }

    public function fillFromEditorData(array $data): void
    {
        if (isset($data['field'])) {
            $this->field = trim((string)$data['field']);
        }
        if (isset($data['x'])) {
            $this->x = round((float)$data['x'], 2);
        }
        if (isset($data['y'])) {
            $this->y = round((float)$data['y'], 2);
        }
        if (isset($data['size'])) {
            $this->size = max(1, (int)$data['size']);
        }
        if (isset($data['align'])) {
            $this->align = (string)$data['align'];
        }
        if (array_key_exists('color', $data)) {
            $this->color = $this->normalizeEditorColor($data['color']);
        }
        if (array_key_exists('page', $data)) {
            $this->setPage($data['page']);
        }
        if (array_key_exists('textTransform', $data)) {
            $this->setTextTransform($data['textTransform']);
        }
    }

    public function toEditorArray(): array
    {
        return [
            'id' => $this->id ?? null,
            'field' => $this->field,
            'label' => $this->getName(),
            'type' => $this->getTypeValue(),
            'x' => (float)$this->x,
            'y' => $this->getEditorYPosition(),
            'size' => (int)$this->size,
            'align' => $this->align ?: 'left',
            'color' => $this->color ?: '0,0,0',
            'page' => $this->getPage(),
            'textTransform' => $this->getMetaData(TextTransform::NAME),
        ];
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

    protected function normalizeEditorColor($color): string
    {
        if (is_string($color) && preg_match('/^#([a-f0-9]{6})$/i', $color, $matches)) {
            return implode(
                ',',
                [
                    hexdec(substr($matches[1], 0, 2)),
                    hexdec(substr($matches[1], 2, 2)),
                    hexdec(substr($matches[1], 4, 2)),
                ]
            );
        }

        if (is_string($color) && preg_match('/^\d{1,3},\d{1,3},\d{1,3}$/', $color)) {
            return $color;
        }

        return '0,0,0';
    }

    protected function inferPageFromYPosition(): int
    {
        $y = (float)$this->y;
        if ($y <= 297) {
            return static::DEFAULT_PAGE;
        }

        return (int)floor($y / 297) + 1;
    }
}
