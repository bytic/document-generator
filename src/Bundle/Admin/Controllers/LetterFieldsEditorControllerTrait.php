<?php

namespace ByTIC\DocumentGenerator\Bundle\Admin\Controllers;

use ByTIC\DocumentGenerator\Letters\Editor\LetterEditorAssets;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @property mixed $pdfLetter
 * @method mixed getModelFromRequest($key = false)
 */
trait LetterFieldsEditorControllerTrait
{
    public function editor(): void
    {
        $letter = $this->requireLetterEditorRecord();
        $css = file_get_contents(LetterEditorAssets::cssPath());
        $js = file_get_contents(LetterEditorAssets::jsPath());
        if (!is_string($css) || !is_string($js)) {
            throw new \RuntimeException('Unable to load PDF letter editor assets');
        }
        if (stripos($css, '</style>') !== false) {
            throw new \RuntimeException('Invalid CSS content in PDF letter editor assets');
        }
        if (stripos($js, '</script>') !== false) {
            throw new \RuntimeException('Invalid JS content in PDF letter editor assets');
        }

        $this->payload()->with(
            [
                'title' => $letter->getName(),
                'payload' => $letter->getEditorPayload(),
                'saveUrl' => $this->getLetterEditorSaveUrl(),
                'dataUrl' => $this->getLetterEditorDataUrl(),
                'css' => $css,
                'js' => $js,
            ]
        );
    }

    public function editorData(): JsonResponse
    {
        return new JsonResponse($this->requireLetterEditorRecord()->getEditorPayload());
    }

    public function editorSave(): JsonResponse
    {
        $letter = $this->requireLetterEditorRecord();
        $payload = $this->getLetterEditorRequestPayload();
        $fields = is_array($payload['fields'] ?? null) ? $payload['fields'] : [];

        return new JsonResponse(
            [
                'fields' => $letter->syncEditorFields($fields),
                'availableFields' => $letter->getAvailableEditorFields(),
            ]
        );
    }

    protected function getLetterEditorDataUrl(): string
    {
        // Intentionally shared with save URL; routing differentiates by HTTP method.
        return $this->getRequest()->getRequestUri();
    }

    protected function getLetterEditorSaveUrl(): string
    {
        // Intentionally shared with data URL; routing differentiates by HTTP method.
        return $this->getRequest()->getRequestUri();
    }

    protected function getLetterEditorRequestPayload(): array
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

    protected function requireLetterEditorRecord()
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
