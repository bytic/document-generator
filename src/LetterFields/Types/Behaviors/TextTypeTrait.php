<?php
declare(strict_types=1);

namespace ByTIC\DocumentGenerator\LetterFields\Types\Behaviors;

use ByTIC\DocumentGenerator\PdfWriter\TextLine;
use Nip\Records\Traits\AbstractTrait\RecordTrait as Record;
use setasign\Fpdi\Tcpdf\Fpdi;

/**
 * Trait TextTypeTrait
 * @package ByTIC\DocumentGenerator\LetterFields\Types
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
