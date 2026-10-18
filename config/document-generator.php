<?php

use ByTIC\DocumentGenerator\PdfLetters\Models\Downloads\PdfDownloads;
use ByTIC\DocumentGenerator\PdfLetters\Models\Fields\PdfLetterFields;
use ByTIC\DocumentGenerator\PdfLetters\Models\Issuers\PdfIssuers;
use ByTIC\DocumentGenerator\PdfLetters\Models\PdfLetters\PdfLetters;
use ByTIC\DocumentGenerator\PdfLetters\Models\Stats\PdfStats;

return [
    'models' => [
        'pdf_letters' => PdfLetters::class,
        'pdf_letter_fields' => PdfLetterFields::class,
        'pdf_downloads' => PdfDownloads::class,
        'pdf_stats' => PdfStats::class,
        'pdf_issuers' => PdfIssuers::class,
    ],
    'tables' => [
        'pdf_letters' => 'pdf_letters',
        'pdf_letter_fields' => 'pdf_letter_fields',
        'pdf_downloads' => 'pdf_downloads',
        'pdf_stats' => 'pdf_stats',
        'pdf_issuers' => 'pdf_issuers',
    ],
    'database' => [
        'connection' => null,
        'migrations' => false,
    ],
];
