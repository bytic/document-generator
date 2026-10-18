<?php
declare(strict_types=1);

namespace ByTIC\DocumentGenerator\Letters\Models\Fields\Types;

use ByTIC\DocumentGenerator\Letters\Models\Fields\Attributes\TextTransform;
use ByTIC\DocumentGenerator\Letters\LetterHelper;
use ByTIC\DocumentGenerator\Letters\Writer\TextLine;
use setasign\Fpdi\Tcpdf\Fpdi;
use Nip\Records\Traits\AbstractTrait\RecordTrait as Record;

/**
 * Trait TextTypeTrait
 * @package ByTIC\DocumentGenerator\Letters\Models\Fields\Types
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
