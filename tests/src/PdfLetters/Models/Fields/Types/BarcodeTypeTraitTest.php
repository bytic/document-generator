<?php

namespace ByTIC\DocumentGenerator\Tests\PdfLetters\Models\Fields\Types;

use ByTIC\DocumentGenerator\PdfLetters\Models\PdfLetters\PdfLetterTrait;
use ByTIC\DocumentGenerator\Tests\AbstractTest;
use ByTIC\DocumentGenerator\Tests\Fixtures\Models\PdfLetters\Fields\FieldRecord;
use ByTIC\DocumentGenerator\Tests\Fixtures\Models\PdfLetters\Fields\Types\CodeField;
use Nip\Records\Record;

/**
 * Class BarcodeTypeTraitTest
 * @package ByTIC\DocumentGenerator\Tests\PdfLetters\Fields\Types
 */
class BarcodeTypeTraitTest extends AbstractTest
{
    public function test_addToPdf()
    {
        $pdf = PdfLetterTrait::newPdfBuilder();
        $pdf->AddPage();
        $codeField = new CodeField();

        $field = new FieldRecord();
        $field->x = 50;
        $field->y = 50;
        $field->field = 'CODE';
        $codeField->setItem($field);

        $model = new Record();
        $codeField->addToPdf($pdf, $model);
        $output = $pdf->Output('output.pdf', 'S');
        similar_text($output, file_get_contents(TEST_FIXTURE_PATH . '/files/barcode.pdf'), $perc);

        self::assertGreaterThan(94, $perc);
    }
}
