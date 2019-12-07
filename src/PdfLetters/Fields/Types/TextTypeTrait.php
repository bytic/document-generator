<?php

namespace ByTIC\DocumentGenerator\PdfLetters\Fields\Types;

use ByTIC\DocumentGenerator\PdfLetters\PdfHelper;
use setasign\Fpdi\Tcpdf\Fpdi;
use Nip\Records\Traits\AbstractTrait\RecordTrait as Record;

/**
 * Trait TextTypeTrait
 * @package ByTIC\DocumentGenerator\PdfLetters\Fields\Types
 */
trait TextTypeTrait
{
    /**
     * @param Fpdi $pdf
     * @param Record $model
     */
    public function addToPdf($pdf, $model)
    {
        /** Set positions before Fonts and colors */
        $value = $this->getItem()->getValue($model);
        $y = PdfHelper::pdfYPosition($pdf, $value, $this->getItem()->y);
        $x = PdfHelper::pdfXPosition($pdf, $value, $this->getItem()->x, $this->getItem()->align);

        $pdf->SetFont('freesans', '', $this->getItem()->size, '', true);
        PdfHelper::pdfPrepareColor($pdf, $this->getItem()->getColorArray());

        $pdf->Text($x, $y, $value);
    }
}
