<?php
declare(strict_types=1);

namespace ByTIC\DocumentGenerator\Utility;

use ByTIC\DocumentGenerator\DocumentGeneratorProvider;
use ByTIC\DocumentGenerator\PdfDownloads\Models\PdfDownloads;
use ByTIC\DocumentGenerator\PdfFields\Models\PdfLetterFields;
use ByTIC\DocumentGenerator\PdfIssuers\Models\PdfIssuers;
use ByTIC\DocumentGenerator\PdfLetters\Models\PdfLetters;
use ByTIC\DocumentGenerator\PdfStats\Models\PdfStats;
use ByTIC\PackageBase\Utility\ModelFinder;
use Nip\Records\RecordManager;

/**
 * Class DocumentGeneratorModels.
 */
class DocumentGeneratorModels extends ModelFinder
{
    public const LETTERS = 'letters';
    public const LETTER_FIELDS = 'letter_fields';
    public const LETTER_DOWNLOADS = 'letter_downloads';
    public const LETTER_STATS = 'letter_stats';
    public const LETTER_ISSUERS = 'letter_issuers';

    /**
     * @return RecordManager|PdfLetters
     */
    public static function letters(): RecordManager
    {
        return static::getModels(self::LETTERS, PdfLetters::class);
    }

    /**
     * @return RecordManager|PdfLetterFields
     */
    public static function letterFields(): RecordManager
    {
        return static::getModels(self::LETTER_FIELDS, PdfLetterFields::class);
    }

    /**
     * @return RecordManager|PdfDownloads
     */
    public static function letterDownloads(): RecordManager
    {
        return static::getModels(self::LETTER_DOWNLOADS, PdfDownloads::class);
    }

    /**
     * @return RecordManager|PdfStats
     */
    public static function letterStats(): RecordManager
    {
        return static::getModels(self::LETTER_STATS, PdfStats::class);
    }

    /**
     * @return RecordManager|PdfIssuers
     */
    public static function letterIssuers(): RecordManager
    {
        return static::getModels(self::LETTER_ISSUERS, PdfIssuers::class);
    }

    /**
     * @deprecated use letters() instead
     */
    public static function pdfLetters(): RecordManager
    {
        return static::letters();
    }

    /**
     * @deprecated use letterFields() instead
     */
    public static function pdfLetterFields(): RecordManager
    {
        return static::letterFields();
    }

    protected static function packageName(): string
    {
        return DocumentGeneratorProvider::NAME;
    }
}
