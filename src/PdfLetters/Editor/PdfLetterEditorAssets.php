<?php

namespace ByTIC\DocumentGenerator\PdfLetters\Editor;

class PdfLetterEditorAssets
{
    public static function templatePath(): string
    {
        return static::basePath() . '/Resources/views/pdf-letter-editor.phtml';
    }

    public static function cssPath(): string
    {
        return static::basePath() . '/Resources/assets/pdf-letter-editor.css';
    }

    public static function jsPath(): string
    {
        return static::basePath() . '/Resources/assets/pdf-letter-editor.js';
    }

    protected static function basePath(): string
    {
        return dirname(__DIR__);
    }
}
