<?php

use ByTIC\DocumentGenerator\LetterDownloads\Models\LetterDownloads;
use ByTIC\DocumentGenerator\LetterFields\Models\LetterFields;
use ByTIC\DocumentGenerator\LetterIssuers\Models\LetterIssuers;
use ByTIC\DocumentGenerator\Letters\Models\Letters;
use ByTIC\DocumentGenerator\LetterStats\Models\LetterStats;

return [
    'models' => [
        'letters' => Letters::class,
        'letter_fields' => LetterFields::class,
        'letter_downloads' => LetterDownloads::class,
        'letter_stats' => LetterStats::class,
        'letter_issuers' => LetterIssuers::class,
    ],
    'tables' => [
        'letters' => 'letter_letters',
        'letter_fields' => 'letter_fields',
        'letter_downloads' => 'letter_downloads',
        'letter_stats' => 'letter_stats',
        'letter_issuers' => 'letter_issuers',
    ],
    'database' => [
        'connection' => null,
        'migrations' => false,
    ],
];
