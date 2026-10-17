<?php

namespace ByTIC\DocumentGenerator\PdfLetters\Editor;

use ByTIC\DocumentGenerator\Utility\PathsHelpers;

class PdfLetterEditorAssets
{
    public static function templatePath(): string
    {
        return PathsHelpers::views('/admin/pdf-letter-editor.php');
    }

    public static function cssPath(): string
    {
        return PathsHelpers::assets('/pdf-letter-editor.css');
    }

    public static function jsPath(): string
    {
        return PathsHelpers::assets('/pdf-letter-editor.js');
    }
}
