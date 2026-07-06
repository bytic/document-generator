<?php

namespace ByTIC\DocumentGenerator\PdfLetters\Models\PdfLetters;

use ByTIC\DocumentGenerator\Helpers;
use ByTIC\DocumentGenerator\PdfLetters\Models\Downloads\DownloadsTrait;
use ByTIC\DocumentGenerator\PdfLetters\Models\Fields\FieldTrait;
use ByTIC\MediaLibrary\Exceptions\FileCannotBeAdded\FileUnacceptableForCollection;
use ByTIC\MediaLibrary\HasMedia\HasMediaTrait;
use ByTIC\MediaLibrary\HasMedia\Interfaces\HasMedia;
use ByTIC\MediaLibrary\Media\Media;
use ByTIC\MediaLibrary\MediaRepository\MediaRepository;
use DateTime;
use Nip\Records\Record;
use Nip\Records\Traits\AbstractTrait\RecordTrait as AbstractRecordTrait;
use setasign\Fpdi;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use TCPDF;

/**
 * Class PdfLetterTrait
 * @package ByTIC\DocumentGenerator\PdfLetters
 *
 * @method FieldTrait[] getCustomFields()
 *
 * @property int $id_item
 * @property string $type
 * @property string $orientation
 * @property string $format
 */
trait PdfLetterTrait
{
    use AbstractRecordTrait;
    use HasMediaTrait;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->getManager()->getLabel('title.singular') . ' #' . $this->id;
    }

    /**
     * @return bool
     */
    public function hasFile()
    {
        $file = $this->getFile();

        return $file instanceof Media;
    }

    /**
     * @return bool|Media
     */
    public function getFile()
    {
        $files = $this->getFiles();
        if (count($files) < 1) {
            return false;
        }

        return $files->getDefaultMedia();
    }

    /**
     * @return mixed
     */
    public function delete()
    {
        $this->deleteLetters();

        /** @noinspection PhpUndefinedClassInspection */
        return parent::delete();
    }

    public function deleteLetters()
    {
        $this->getFiles()->delete();
    }

    public function downloadExample()
    {
        $result = $this->getModelExample();
        /** @noinspection PhpUndefinedFieldInspection */
        $result->demo = true;

        $this->download($result);
    }

    /**
     * @param AbstractRecordTrait $model
     */
    public function download($model)
    {
        $pdf = $this->generatePdfObj($model);

        $pdf->Output($this->getFileNameFromModel($model) . '.pdf', 'D');
        die();
    }

    public function downloadBlank()
    {
        $file = $this->getFile();
        $model = $this->getModelExample();
        $name = $this->getFileNameFromModel($model) . '.pdf';

        header('Content-Type: application/pdf');
        header('Content-Description: File Transfer');
        header('Cache-Control: private, must-revalidate, post-check=0, pre-check=0, max-age=1');
        header('Pragma: public');
        header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Content-Disposition: attachment; filename="' . $name . '";');
        header("Content-Transfer-Encoding: Binary");
        echo $file->read();
        die();
    }

    /**
     * @param Record $recipient
     */
    public function addDownload($recipient)
    {
        /** @var DownloadsTrait $downloadsManager */
        $downloadsManager = $this->getManager()->getRelation('Downloads')->getWith();
        $downloadsManager->createForRecipient($recipient, $this);
    }

    /**
     * @param $model
     * @param $output
     * @return bool|Fpdi|TCPDF
     */
    public function generateFile($model, $output = null)
    {
        $pdf = $this->generatePdfObj($model);

        if ($model->demo === true) {
            $this->pdfDrawGuidelines($pdf);
        }
        $fileName = $this->getFileNameFromModel($model) . '.pdf';
        if (is_string($output) && is_dir($output)) {
            return $pdf->Output($output . $fileName, 'F');
        }
        if ($output instanceof HasMedia) {
            /** @var HasMediaTrait $output */
            $output->addFileFromContent(
                $pdf->Output($fileName, 'S'),
                $fileName
            );
        }
        return $pdf;
    }

    /**
     * @param AbstractRecordTrait $model
     * @return FPDI|TCPDF
     */
    public function generatePdfObj($model)
    {
        $pdf = $this->generateNewPdfObj();

        /** @noinspection PhpUndefinedFieldInspection */
        if ($model->demo === true) {
            $this->pdfDrawGuidelines($pdf);
        }

        $this->addFieldsToPDF($pdf, $model);

        return $pdf;
    }

    public function getEditorPayload(): array
    {
        return [
            'pdfSource' => $this->getEditorPdfSource(),
            'pages' => $this->getEditorPages(),
            'fields' => $this->getEditorFields(),
            'availableFields' => $this->getAvailableEditorFields(),
        ];
    }

    public function getEditorPages(): array
    {
        $pdf = $this->generateNewPdfObj();
        $pages = [];
        $pageCount = $pdf->getNumPages();
        for ($page = 1; $page <= $pageCount; $page++) {
            $pdf->setPage($page);
            $pages[] = [
                'number' => $page,
                'width' => (float)$pdf->getPageWidth(),
                'height' => (float)$pdf->getPageHeight(),
            ];
        }
        if ($pageCount > 0) {
            $pdf->setPage(1);
        }

        return $pages;
    }

    public function getEditorFields(): array
    {
        $fields = [];
        foreach ($this->getCustomFields() as $field) {
            $fields[] = $field->toEditorArray();
        }

        return $fields;
    }

    public function getEditorPdfSource(): string
    {
        $file = $this->getFile();
        if (!$file) {
            return '';
        }

        return 'data:application/pdf;base64,' . base64_encode($file->read());
    }

    public function getAvailableEditorFields(): array
    {
        $manager = $this->getCustomFieldsManager();
        $mergeFields = $manager->getMergeFields();
        $counters = $this->getEditorFieldCounters();
        $data = [];
        foreach ($mergeFields as $category => $fields) {
            $categoryFields = [];
            foreach ($fields as $field) {
                $categoryFields[] = [
                    'name' => $field,
                    'label' => translator()->trans($field),
                    'type' => $manager->getFieldTypeFromMergeTag($field),
                    'count' => $counters[$field] ?? 0,
                ];
            }
            $data[] = [
                'name' => $category,
                'label' => translator()->trans($category),
                'fields' => $categoryFields,
            ];
        }

        return $data;
    }

    public function syncEditorFields(array $fields): array
    {
        $manager = $this->getCustomFieldsManager();
        $existingFields = [];
        foreach ($this->getCustomFields() as $field) {
            if (isset($field->id)) {
                $existingFields[(int)$field->id] = $field;
            }
        }

        $persisted = [];
        $submittedIds = [];
        foreach ($fields as $definition) {
            if (!is_array($definition) || empty($definition['field'])) {
                continue;
            }

            $fieldId = isset($definition['id']) ? (int)$definition['id'] : 0;
            $field = $fieldId > 0 && isset($existingFields[$fieldId])
                ? $existingFields[$fieldId]
                : $manager->getNew();

            if (!$fieldId || !isset($existingFields[$fieldId])) {
                $field->populateFromLetter($this);
            }

            $field->fillFromEditorData($definition);
            if ($fieldId > 0 && isset($existingFields[$fieldId])) {
                $field->save();
            } else {
                $field->insert();
            }

            if (isset($field->id)) {
                $submittedIds[(int)$field->id] = true;
            }
            $persisted[] = $field->toEditorArray();
        }

        foreach ($existingFields as $fieldId => $field) {
            if (!isset($submittedIds[$fieldId])) {
                $field->delete();
            }
        }

        return $persisted;
    }

    /**
     * @return Fpdi\Tcpdf\Fpdi|TCPDF
     * @throws Fpdi\PdfParser\CrossReference\CrossReferenceException
     * @throws Fpdi\PdfParser\Filter\FilterException
     * @throws Fpdi\PdfParser\PdfParserException
     * @throws Fpdi\PdfParser\Type\PdfTypeException
     * @throws Fpdi\PdfReader\PdfReaderException
     */
    public function generateNewPdfObj()
    {
        $pdf = static::newPdfBuilder('L');

        $mediaFile = $this->getFile();
        $pageCount = $pdf->setSourceFile($mediaFile->getFile()->readStream());
        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $tplidx = $pdf->importPage($pageNo, '/MediaBox');

            $pdf->AddPage(ucfirst($this->orientation), $this->format);
            $pdf->useTemplate($tplidx);
            $pdf->endPage();
        }
        $pdf->setPage(1);

        return $pdf;
    }

    /**
     * @param mixed ...$params
     * @return Fpdi\Tcpdf\Fpdi
     */
    public static function newPdfBuilder(...$params)
    {
        $pdf = new Fpdi\Tcpdf\Fpdi(...$params);
        $pdf->setPrintHeader(false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor(Helpers::author());

        return $pdf;
    }

    /**
     * @return AbstractRecordTrait
     */
    public function getItem()
    {
        $manager = $this->getItemsManager();

        return $manager->findOne($this->id_item);
    }

    /**
     * @param UploadedFile $uploadedFile
     * @return string|boolean
     */
    public function uploadFromRequest($uploadedFile)
    {
        $fileCollection = $this->getFiles();

        if (!$uploadedFile->isValid()) {
            return $uploadedFile->getErrorMessage();
        }

        try {
            $fileAdder = $this->addFile($uploadedFile);
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

    /**
     * @return AbstractRecordTrait
     */
    abstract public function getItemsManager();

    /**
     * @return AbstractRecordTrait
     */
    abstract public function getModelExample();

    /**
     * @return DateTime
     */
    abstract public function getIssueDate(): DateTime;

    /**
     * @param $pdf
     * @param $model
     */
    protected function addFieldsToPDF($pdf, $model)
    {
        /** @var FieldTrait[] $fields */
        $fields = $this->getCustomFields();
        foreach ($fields as $field) {
            $field->addToPdf($pdf, $model);
        }
    }

    /**
     * @return string
     */
    protected function getFileNameDefault()
    {
        return 'letter';
    }

    /**
     * @param FPDI|TCPDF $pdf
     */
    protected function pdfDrawGuidelines($pdf)
    {
        for ($pos = 5; $pos < 791; $pos = $pos + 5) {
            if (($pos % 100) == 0) {
                $pdf->SetDrawColor(0, 0, 200);
                $pdf->SetLineWidth(.7);
            } elseif (($pos % 50) == 0) {
                $pdf->SetDrawColor(200, 0, 0);
                $pdf->SetLineWidth(.4);
            } else {
                $pdf->SetDrawColor(128, 128, 128);
                $pdf->SetLineWidth(.05);
            }

            $pdf->Line(0, $pos, 611, $pos);
            if ($pos < 611) {
                $pdf->Line($pos, 0, $pos, 791);
            }
        }
    }

    /** @noinspection PhpUnusedParameterInspection
     * @param $model
     * @return string
     */
    protected function getFileNameFromModel($model)
    {
        return $this->getFileNameDefault();
    }

    /**
     * @param MediaRepository $mediaRepository
     * @return MediaRepository
     */
    protected function hydrateMediaRepositoryCustom($mediaRepository)
    {
        $filesCollection = $mediaRepository->getCollection('files');
        $filesCollection->getConstraint()->mimeTypes = ['application/pdf'];
        return $mediaRepository;
    }

    protected function getCustomFieldsManager()
    {
        return $this->getManager()->getRelation('CustomFields')->getWith();
    }

    protected function getEditorFieldCounters(): array
    {
        $counters = [];
        foreach ($this->getCustomFields() as $field) {
            if (!isset($counters[$field->field])) {
                $counters[$field->field] = 0;
            }
            $counters[$field->field]++;
        }

        return $counters;
    }
}
