<?php

namespace ByTIC\DocumentGenerator\Bundle\Admin\Controllers;

use ByTIC\DocumentGenerator\PdfLetters\Editor\PdfLetterEditorAssets;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @property mixed $pdfLetter
 * @method mixed getModelFromRequest($key = false)
 */
trait PdfLetterFieldsEditorControllerTrait
{
    public function editor(): void
    {
        $letter = $this->requirePdfLetterEditorRecord();
        $css = file_get_contents(PdfLetterEditorAssets::cssPath());
        $js = file_get_contents(PdfLetterEditorAssets::jsPath());
        if (!is_string($css) || !is_string($js)) {
            throw new \RuntimeException('Unable to load PDF letter editor assets');
        }
        if (stripos($css, '</style>') !== false) {
            throw new \RuntimeException('Invalid CSS content in PDF letter editor assets');
        }
        $js = str_replace('</script>', '<\/script>', $js);

        $this->payload()->with(
            [
                'title' => $letter->getName(),
                'payload' => $letter->getEditorPayload(),
                'saveUrl' => $this->getPdfLetterEditorSaveUrl(),
                'dataUrl' => $this->getPdfLetterEditorDataUrl(),
                'css' => $css,
                'js' => $js,
            ]
        );
    }

    public function editorData(): JsonResponse
    {
        return new JsonResponse($this->requirePdfLetterEditorRecord()->getEditorPayload());
    }

    public function editorSave(): JsonResponse
    {
        $letter = $this->requirePdfLetterEditorRecord();
        $payload = $this->getPdfLetterEditorRequestPayload();
        $fields = is_array($payload['fields'] ?? null) ? $payload['fields'] : [];

        return new JsonResponse(
            [
                'fields' => $letter->syncEditorFields($fields),
                'availableFields' => $letter->getAvailableEditorFields(),
            ]
        );
    }

    protected function getPdfLetterEditorDataUrl(): string
    {
        return $this->getRequest()->getRequestUri();
    }

    protected function getPdfLetterEditorSaveUrl(): string
    {
        return $this->getRequest()->getRequestUri();
    }

    protected function getPdfLetterEditorRequestPayload(): array
    {
        $request = $this->getRequest();
        $content = $request->getContent();
        if (is_string($content) && $content !== '') {
            $decoded = json_decode($content, true);
            if (is_array($decoded)) {
                return $decoded;
            }
        }

        return $request->request->all();
    }

    protected function requirePdfLetterEditorRecord()
    {
        if ($this->pdfLetter) {
            return $this->pdfLetter;
        }

        $letter = $this->getModelFromRequest();
        if ($letter) {
            return $letter;
        }

        throw new \RuntimeException('No PDF letter available for editor');
    }
}
