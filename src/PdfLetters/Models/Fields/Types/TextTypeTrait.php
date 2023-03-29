<?php
declare(strict_types=1);

namespace ByTIC\DocumentGenerator\PdfLetters\Models\Fields\Types;

use ByTIC\DocumentGenerator\PdfLetters\Models\Fields\Attributes\TextTransform;
use ByTIC\DocumentGenerator\PdfLetters\PdfHelper;
use ByTIC\DocumentGenerator\PdfLetters\Writer\TextLine;
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
        TextLine::fromField($this->getItem(), $this->getItem()->getValue($model), $pdf)
            ->write();
    }
}
