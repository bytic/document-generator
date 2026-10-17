<?php

namespace ByTIC\DocumentGenerator\PdfLetters\Editor;

class PdfLetterEditorRenderer
{
    public static function render(array $data = []): string
    {
        $template = PdfLetterEditorAssets::templatePath();
        extract($data, EXTR_SKIP);

        ob_start();
        include $template;

        return (string)ob_get_clean();
    }
}
