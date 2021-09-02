<?php

namespace ByTIC\DocumentGenerator\PdfLetters\Models\Fields\Types;

use ByTIC\DocumentGenerator\PdfLetters\Models\Fields\Attributes\TextTransform;
use ByTIC\DocumentGenerator\PdfLetters\PdfHelper;
use setasign\Fpdi\Tcpdf\Fpdi;
use Nip\Records\Traits\AbstractTrait\RecordTrait as Record;

/**
 * Trait TextTypeTrait
 * @package ByTIC\DocumentGenerator\PdfLetters\Models\Fields\Types
 */
trait TextTypeTrait
{
    /**
     * @param Fpdi $pdf
     * @param Record $model
     */
    public function addToPdf($pdf, $model)
    {
        $pdf->SetFont('freesans', '', $this->getItem()->size, '', true);
        PdfHelper::pdfPrepareColor($pdf, $this->getItem()->getColorArray());

        /** Set positions before Fonts and colors */
        $value = $this->getItem()->getValue($model);
        $value = TextTransform::transform($value, $this->getItem()->getMetaData(TextTransform::NAME));

        $y = PdfHelper::pdfYPosition($pdf, $value, $this->getItem()->y);
        $x = PdfHelper::pdfXPosition($pdf, $value, $this->getItem()->x, $this->getItem()->align);

        $pdf->Text($x, $y, $value);
    }
}
