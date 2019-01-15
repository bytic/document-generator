<?php

namespace ByTIC\DocumentGenerator\PdfLetters;

use ByTIC\DocumentGenerator\Helpers;
use ByTIC\DocumentGenerator\PdfLetters\Fields\FieldTrait;
use ByTIC\MediaLibrary\HasMedia\HasMediaTrait;
use ByTIC\MediaLibrary\HasMedia\Interfaces\HasMedia;
use ByTIC\MediaLibrary\Media\Media;
use Nip\Records\RecordManager;
use Nip\Records\Traits\AbstractTrait\RecordTrait as AbstractRecordTrait;
use setasign\Fpdi;
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
     * @return AbstractRecordTrait
     */
    abstract public function getModelExample();

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

        header('Content-Type: application/pdf');
        header('Content-Description: File Transfer');
        header('Cache-Control: private, must-revalidate, post-check=0, pre-check=0, max-age=1');
        header('Pragma: public');
        header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Content-Disposition: attachment; filename="' . basename($file) . '";');
        header("Content-Transfer-Encoding: Binary");
        echo $file->read();
        die();
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
        if (is_dir($output)) {
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

        /** @var FieldTrait[] $fields */
        $fields = $this->getCustomFields();
        foreach ($fields as $field) {
            $field->addToPdf($pdf, $model);
        }

        return $pdf;
    }

    /**
     * @return FPDI|TCPDF
     */
    public function generateNewPdfObj()
    {
        /** @var Fpdi|TCPDF $pdf */
        $pdf = new Fpdi\TcpdfFpdi('L');
        $pdf->setPrintHeader(false);
        $pdf->SetCreator(PDF_CREATOR);

        $pdf->SetAuthor(Helpers::author());

        $mediaFile = $this->getFile();
        $pageCount = $pdf->setSourceFile($mediaFile->getFile()->readStream());
        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $tplidx = $pdf->importPage($pageNo, '/MediaBox');

            $pdf->addPage(ucfirst($this->orientation), $this->format);
            $pdf->useTemplate($tplidx);
            $pdf->endPage();
        }
        $pdf->setPage(1);

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
     * @return AbstractRecordTrait
     */
    abstract public function getItemsManager();

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
}
