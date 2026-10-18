<?php
declare(strict_types=1);

namespace ByTIC\DocumentGenerator\Letters\Editor;

use ByTIC\DocumentGenerator\Utility\PathsHelpers;

class LetterEditorAssets
{
    public static function cssPath(): string
    {
        return PathsHelpers::assets('/letter-editor.css');
    }

    public static function jsPath(): string
    {
        return PathsHelpers::assets('/letter-editor.js');
    }
}
