<?php

use ByTIC\DocumentGenerator\PdfDownloads\Models\PdfDownloads;
use ByTIC\DocumentGenerator\PdfFields\Models\PdfLetterFields;
use ByTIC\DocumentGenerator\PdfIssuers\Models\PdfIssuers;
use ByTIC\DocumentGenerator\PdfLetters\Models\PdfLetters;
use ByTIC\DocumentGenerator\PdfStats\Models\PdfStats;

return [
    'models' => [
        'letters' => PdfLetters::class,
        'letter_fields' => PdfLetterFields::class,
        'letter_downloads' => PdfDownloads::class,
        'letter_stats' => PdfStats::class,
        'letter_issuers' => PdfIssuers::class,
    ],
    'tables' => [
        'letters' => 'pdf_letters',
        'letter_fields' => 'pdf_letter_fields',
        'letter_downloads' => 'pdf_downloads',
        'letter_stats' => 'pdf_stats',
        'letter_issuers' => 'pdf_issuers',
    ],
    'database' => [
        'connection' => null,
        'migrations' => false,
    ],
];
