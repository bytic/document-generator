<?php
declare(strict_types=1);

namespace ByTIC\DocumentGenerator\Utility;

use ByTIC\DocumentGenerator\DocumentGeneratorProvider;
use ByTIC\DocumentGenerator\PdfFields\Models\PdfLetterFields;
use ByTIC\DocumentGenerator\PdfLetters\Models\PdfLetters;
use ByTIC\PackageBase\Utility\ModelFinder;
use Nip\Records\RecordManager;

/**
 * Class NotifierBuilderModels.
 */
class DocumentGeneratorModels extends ModelFinder
{
    public const LETTERS = 'letters';
    public const LETTER_FIELDS = 'letter_fields';

    /**
     * @return RecordManager|Forms
     */
    public static function pdfLetters()
    {
        return static::getModels(self::LETTERS, PdfLetters::class);
    }

    /**
     * @return RecordManager|FormsFields
     */
    public static function pdfLetterFields()
    {
        return static::getModels(self::LETTER_FIELDS, PdfLetterFields::class);
    }

    protected static function packageName(): string
    {
        return DocumentGeneratorProvider::NAME;
    }
}
