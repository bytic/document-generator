<?php

namespace ByTIC\DocumentGenerator\PdfLetters\Editor;

class PdfLetterEditorRenderer
{
    public static function render(
        string $title,
        array $payload,
        string $saveUrl,
        string $dataUrl,
        string $css,
        string $js
    ): string
    {
        $template = PdfLetterEditorAssets::templatePath();
        $js = str_replace('</script>', '<\/script>', $js);

        ob_start();
        include $template;

        return (string)ob_get_clean();
    }
}
