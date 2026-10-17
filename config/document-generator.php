<?php

use ByTIC\DocumentGenerator\PdfLetters\Models\Fields\PdfLetterFields;
use ByTIC\DocumentGenerator\PdfLetters\Models\PdfLetters\PdfLetters;

return [
    'models' => [
        'pdf_letters' => PdfLetters::class,
        'pdf_letter_fields' => PdfLetterFields::class,
    ],
    'tables' => [
        'pdf_letters' => 'pdf_letters',
        'pdf_letter_fields' => 'pdf_letter_fields',
    ],
    'database' => [
        'connection' => null,
        'migrations' => false,
    ],
];
