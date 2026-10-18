<?php

namespace ByTIC\DocumentGenerator\Tests\Letters\Models\Letters;

use ByTIC\DocumentGenerator\Tests\AbstractTest;
use ByTIC\DocumentGenerator\Tests\Fixtures\Models\MediaRecords\MediaRecord;
use ByTIC\DocumentGenerator\Tests\Fixtures\Models\Letters\Letter;
use ByTIC\DocumentGenerator\Tests\Fixtures\Models\Letters\Letters;
use ByTIC\DocumentGenerator\Tests\Fixtures\Models\Recipients\Recipient;
use ByTIC\MediaLibrary\Media\Media;
use Nip\Filesystem\File;
use setasign\Fpdi\Tcpdf\Fpdi;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class LetterTraitTest
 * @package ByTIC\DocumentGenerator\Tests\Letters
 */
class LetterTraitTest extends AbstractTest
{
    public function testUploadFromRequestValid()
    {
        $letter = new Letter();
        $letter->id = 10;

        $letter->setManager(Letters::instance());

        $uploadedFile = new UploadedFile(
            TEST_FIXTURE_PATH . '/files/file.pdf',
            'test original name.pdf',
            'application/pdf',
            null,
            true
        );

        $response = $letter->uploadFromRequest($uploadedFile);
        parent::assertInstanceOf(Media::class, $response);
        self::assertFileExists(TEST_FIXTURE_PATH . '/files/letter_letters/10/test original name.pdf');
    }

    public function testUploadFromRequestWithInvalidFileType()
    {
        $letter = new Letter();
        $letter->id = 10;

        $letter->setManager(Letters::instance());

        $uploadedFile = new UploadedFile(
            TEST_FIXTURE_PATH . '/files/file.pdf',
            'test original name.doc',
            null,
            null,
            true
        );

        $response = $letter->uploadFromRequest($uploadedFile);
        parent::assertSame('INVALID_MIME_TYPE_ERROR', $response);
    }

    public function testUploadFromRequestWithInvalidPdfContent()
    {
        $letter = new Letter();
        $letter->id = 10;

        $letter->setManager(Letters::instance());

        $uploadedFile = new UploadedFile(
            TEST_FIXTURE_PATH . '/files/not-a-pdf.txt',
            'broken.pdf',
            'application/pdf',
            null,
            true
        );

        $response = $letter->uploadFromRequest($uploadedFile);
        parent::assertSame('INVALID_PDF_CONTENT_ERROR', $response);
    }

    public function testGenerateNewPdfObj()
    {
        $letter = new class() extends Letter {
            public Media $mockedFile;

            public function getFile()
            {
                return $this->mockedFile;
            }
        };
        $letter->id = 99;
        $letter->orientation = 'L';
        $letter->format = 'A4';

        $mediaFile = new Media();
        $mediaFile->setFile(new File($letter->getMediaFilesystemDisk(), '/files/file.pdf'));
        $letter->mockedFile = $mediaFile;

        $letter->setManager(Letters::instance());

        $pdf = $letter->generateNewPdfObj();
        $output = $pdf->Output('output.pdf', 'S');

        parent::assertStringStartsWith('%PDF-1.7', $output);
        parent::assertStringContainsString('%%EOF', $output);
    }

    public function testGenerateFileWithMediaObject()
    {
        $letter = new class() extends Letter {
            public Media $mockedFile;

            public function getFile()
            {
                return $this->mockedFile;
            }

            public function getLetterFields()
            {
                return [];
            }
        };

        $letter->setManager(Letters::instance());
        $letter->id = 99;
        $letter->orientation = 'L';
        $letter->format = 'A4';

        $mediaFile = new Media();
        $mediaFile->setFile(new File($letter->getMediaFilesystemDisk(), '/files/file.pdf'));
        $letter->mockedFile = $mediaFile;

        $recipient = new Recipient();
        $mediaRecord = new class() extends MediaRecord {
            public function addFileFromContent($content, $name)
            {
                return null;
            }
        };

        $pdf = $letter->generateFile($recipient, $mediaRecord);
        self::assertInstanceOf(Fpdi::class, $pdf);
    }
}
