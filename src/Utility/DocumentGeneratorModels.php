<?php
declare(strict_types=1);

namespace ByTIC\DocumentGenerator\Utility;

use ByTIC\DocumentGenerator\DocumentGeneratorProvider;
use ByTIC\DocumentGenerator\LetterDownloads\Models\LetterDownloads;
use ByTIC\DocumentGenerator\LetterFields\Models\LetterFields;
use ByTIC\DocumentGenerator\LetterIssuers\Models\LetterIssuers;
use ByTIC\DocumentGenerator\PdfWriter\Models\Letters;
use ByTIC\DocumentGenerator\LetterStats\Models\LetterStats;
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
     * @return RecordManager|Letters
     */
    public static function letters(): RecordManager
    {
        return static::getModels(self::LETTERS, Letters::class);
    }

    public static function lettersClass(): string
    {
        return static::getModelsClass(self::LETTERS, Letters::class);
    }

    /**
     * @return RecordManager|LetterFields
     */
    public static function letterFields(): RecordManager
    {
        return static::getModels(self::LETTER_FIELDS, LetterFields::class);
    }

    public static function letterFieldsClass(): string
    {
        return static::getModelsClass(self::LETTER_FIELDS, LetterFields::class);
    }

    /**
     * @return RecordManager|LetterDownloads
     */
    public static function letterDownloads(): RecordManager
    {
        return static::getModels(self::LETTER_DOWNLOADS, LetterDownloads::class);
    }

    public static function letterDownloadsClass(): string
    {
        return static::getModelsClass(self::LETTER_DOWNLOADS, LetterDownloads::class);
    }

    /**
     * @return RecordManager|LetterStats
     */
    public static function letterStats(): RecordManager
    {
        return static::getModels(self::LETTER_STATS, LetterStats::class);
    }

    public static function letterStatsClass(): string
    {
        return static::getModelsClass(self::LETTER_STATS, LetterStats::class);
    }

    /**
     * @return RecordManager|LetterIssuers
     */
    public static function letterIssuers(): RecordManager
    {
        return static::getModels(self::LETTER_ISSUERS, LetterIssuers::class);
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
