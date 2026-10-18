<?php

use ByTIC\DocumentGenerator\PdfDownloads\Models\PdfDownloads;
use ByTIC\DocumentGenerator\PdfFields\Models\PdfLetterFields;
use ByTIC\DocumentGenerator\PdfIssuers\Models\PdfIssuers;
use ByTIC\DocumentGenerator\PdfLetters\Models\PdfLetters;
use ByTIC\DocumentGenerator\PdfStats\Models\PdfStats;

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
