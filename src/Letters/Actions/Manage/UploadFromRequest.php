<?php
declare(strict_types=1);

namespace ByTIC\DocumentGenerator\PdfWriter\Actions\Manage;

use Bytic\Actions\Action;
use Bytic\Actions\Behaviours\HasSubject\HasSubject;
use ByTIC\DocumentGenerator\PdfWriter\Models\Letter;
use ByTIC\DocumentGenerator\PdfWriter\Models\LetterTrait;
use ByTIC\MediaLibrary\Exceptions\FileCannotBeAdded\FileUnacceptableForCollection;
use ByTIC\MediaLibrary\Media\Media;
use RuntimeException;
use setasign\Fpdi;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 *
 */
class UploadFromRequest extends Action
{
    use HasSubject;

    protected ?UploadedFile $uploadedFile = null;

    public function withUploadedFile(UploadedFile $uploadedFile): self
    {
        $this->uploadedFile = $uploadedFile;

        return $this;
    }

    /**
     * @return Media|string
     */
    public function handle()
    {
        $uploadedFile = $this->uploadedFile;
        if (!$uploadedFile instanceof UploadedFile) {
            throw new RuntimeException('The uploaded file is missing.');
        }

        /** @var LetterTrait $letter */
        $letter = $this->getSubject();
        $fileCollection = $letter->getFiles();

        if (!$uploadedFile->isValid()) {
            return $uploadedFile->getErrorMessage();
        }

        if (!$this->canOpenPdfWithFpdi($uploadedFile)) {
            return 'INVALID_PDF: Pdf engine cannot open the file.';
        }

        try {
            $fileAdder = $letter->addFile($uploadedFile);
            $newMedia = $fileAdder->getMedia();
        } catch (FileUnacceptableForCollection $exception) {
            return $exception->violations->getMessageString();
        }

        foreach ($fileCollection as $name => $media) {
            if ($name != $newMedia->getName()) {
                $media->delete();
            }
        }

        return $newMedia;
    }

    protected function canOpenPdfWithFpdi(UploadedFile $uploadedFile): bool
    {
        $path = $uploadedFile->getRealPath();
        if (!$path || !is_file($path)) {
            return false;
        }

        $pdf = null;
        try {
            $pdf = Letter::newPdfBuilder('L');
            $pdf->setSourceFile($path);

            return true;
        } catch (\Throwable $throwable) {
            return false;
        } finally {
            if ($pdf instanceof Fpdi\Tcpdf\Fpdi) {
                $pdf->close();
            }
        }
    }
}
