<?php
declare(strict_types=1);

namespace ByTIC\DocumentGenerator\PdfLetters\Editor;

use ByTIC\DocumentGenerator\Utility\PathsHelpers;

class PdfLetterEditorAssets
{
    public static function cssPath(): string
    {
        return PathsHelpers::assets('/pdf-letter-editor.css');
    }

    public static function jsPath(): string
    {
        return PathsHelpers::assets('/pdf-letter-editor.js');
    }
}
