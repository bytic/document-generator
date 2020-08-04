<?php

namespace ByTIC\DocumentGenerator\PdfLetters\Models\Fields\Types;

use ByTIC\DocumentGenerator\PdfLetters\PdfHelper;
use Nip\Records\Traits\AbstractTrait\RecordTrait as Record;
use setasign\Fpdi\Tcpdf\Fpdi;

/**
 * Trait BarcodeTypeTrait
 * @package ByTIC\DocumentGenerator\PdfLetters\Models\Fields\Types
 */
trait BarcodeTypeTrait
{
    /**
     * @param Fpdi $pdf
     * @param Record $model
     */
    public function addToPdf($pdf, $model)
    {
        $value = $this->getItem()->getValue($model);
        $y = PdfHelper::pdfYPosition($pdf, $value, $this->getItem()->y);
        $x = PdfHelper::pdfXPosition($pdf, $value, $this->getItem()->x, $this->getItem()->align);

        $style = [
            'position' => '',
            'align' => 'C',
            'stretch' => false,
            'fitwidth' => true,
            'cellfitalign' => '',
            'border' => true,
            'hpadding' => 'auto',
            'vpadding' => 'auto',
            'fgcolor' => [0,0,0],
            'bgcolor' => false, //array(255,255,255),
            'text' => true,
            'font' => 'helvetica',
            'fontsize' => 8,
            'stretchtext' => 4
        ];
        $pdf->write1DBarcode($value, 'C128', $x, $y, '', 18, 0.4, $style, 'N');
    }
}
