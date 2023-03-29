<?php
declare(strict_types=1);

namespace ByTIC\DocumentGenerator\PdfLetters\Writer;

use ByTIC\DocumentGenerator\PdfLetters\Models\Fields\Attributes\TextTransform;
use ByTIC\DocumentGenerator\PdfLetters\PdfHelper;

class TextLine extends AbstractObject
{

    protected $size;

    protected $align = null;

    protected $colorArray;

    protected $multiline = true;

    /**
     * @inheritDoc
     */
    protected function populateFromField($field): void
    {
        parent::populateFromField($field);
        $this->size = $field->size;
        $this->align = $field->align;
        $this->colorArray = $field->getColorArray();

        $this->value = TextTransform::transform($this->value, $field->getMetaData(TextTransform::NAME));
    }

    public function write()
    {
        $this->prepareStyles();
        /** Set positions before Fonts and colors */
        if ($this->multiline) {
            $this->writeMultiLine($this->value);
            return;
        }
        $this->writeLine($this->value);
    }

    protected function writeMultiLine($value)
    {
        $value = (string) $value;
        $lines = explode("\n", $value);
        $y = $this->y;
        $height = $this->size*0.5;
        foreach ($lines as $line) {
            $this->writeLine($line, null, $y);
            $y += $height;
        }
    }
    protected function writeLine($value, $x = null , $y = null)
    {
        $y = $y ?: $this->y;
        $x = $x ?: $this->x;
        $y = PdfHelper::pdfYPosition($this->pdf, $value, $y);
        $x = PdfHelper::pdfXPosition($this->pdf, $value, $x, $this->align);

        $this->pdf->Text($x, $y, $value);
    }

    protected function prepareStyles()
    {
        $this->pdf->setFont('freesans', '', $this->size, '', true);
        PdfHelper::pdfPrepareColor($this->pdf, $this->colorArray);
    }
}