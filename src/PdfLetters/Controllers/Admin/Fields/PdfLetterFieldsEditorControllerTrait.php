<?php

namespace ByTIC\DocumentGenerator\PdfLetters\Controllers\Admin\Fields;

use ByTIC\DocumentGenerator\PdfLetters\Editor\PdfLetterEditorAssets;
use ByTIC\DocumentGenerator\PdfLetters\Editor\PdfLetterEditorRenderer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait PdfLetterFieldsEditorControllerTrait
{
    public function editor(): Response
    {
        $letter = $this->requirePdfLetterEditorRecord();
        $content = PdfLetterEditorRenderer::render(
            [
                'title' => $letter->getName(),
                'payload' => $letter->getEditorPayload(),
                'saveUrl' => $this->getPdfLetterEditorSaveUrl(),
                'dataUrl' => $this->getPdfLetterEditorDataUrl(),
                'css' => file_get_contents(PdfLetterEditorAssets::cssPath()),
                'js' => file_get_contents(PdfLetterEditorAssets::jsPath()),
            ]
        );

        return new Response($content);
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
