<?php

namespace ByTIC\DocumentGenerator\Tests\PdfLetters\Models\PdfLetters;

use ByTIC\DocumentGenerator\Tests\AbstractTest;
use ByTIC\DocumentGenerator\Tests\Fixtures\Models\MediaRecords\MediaRecord;
use ByTIC\DocumentGenerator\Tests\Fixtures\Models\PdfLetters\PdfLetter;
use ByTIC\DocumentGenerator\Tests\Fixtures\Models\PdfLetters\PdfLetters;
use ByTIC\DocumentGenerator\Tests\Fixtures\Models\Recipients\Recipient;
use ByTIC\MediaLibrary\Media\Media;
use Mockery;
use Nip\Filesystem\File;
use setasign\Fpdi\Tcpdf\Fpdi;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use const setasign\Fpdi\TcpdfFpdi;

/**
 * Class PdfLetterTraitTest
 * @package ByTIC\DocumentGenerator\Tests\PdfLetters
 */
class PdfLetterTraitTest extends AbstractTest
{
    public function testUploadFromRequestValid()
    {
        $letter = new PdfLetter();
        $letter->id = 10;

        $letter->setManager(PdfLetters::instance());

        $uploadedFile = new UploadedFile(
            TEST_FIXTURE_PATH . '/files/file.pdf',
            'test original name.pdf',
            'application/pdf',
            null,
            true
        );

        $response = $letter->uploadFromRequest($uploadedFile);
        parent::assertInstanceOf(Media::class, $response);
        self::assertFileExists(TEST_FIXTURE_PATH . '/files/pdf_letters/10/file.pdf');
    }

    public function testUploadFromRequestWithInvalidFileType()
    {
        $letter = new PdfLetter();
        $letter->id = 10;

        $letter->setManager(PdfLetters::instance());

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

    public function testGenerateNewPdfObj()
    {
        /** @var PdfLetter|Mockery\Mock $letter */
        $letter = Mockery::mock(PdfLetter::class)->makePartial();
        $letter->id = 99;

        $mediaFile = new Media();
        $mediaFile->setFile((new File())
            ->setPath('/files/pdf_letters/99/file.pdf')
            ->setFilesystem($letter->getMediaFilesystemDisk())
        );

        $letter->shouldReceive('getFile')->andReturn($mediaFile);

        $letter->setManager(PdfLetters::instance());

        $pdf = $letter->generateNewPdfObj();
        $output = $pdf->Output('output.pdf', 'S');

        parent::assertStringStartsWith('%PDF-1.7', $output);
        parent::assertStringContainsString('%%EOF', $output);
    }

    public function testGenerateFileWithMediaObject()
    {
        /** @var PdfLetter|Mockery\Mock $letter */
        $letter = Mockery::mock(PdfLetter::class);
        $letter->shouldReceive('getCustomFields')->andReturn([]);
        $letter = $letter->makePartial();

        $letter->setManager(PdfLetters::instance());
        $letter->id = 99;

        $mediaFile = new Media();
        $mediaFile->setFile((new File())
            ->setPath('/files/pdf_letters/99/file.pdf')
            ->setFilesystem($letter->getMediaFilesystemDisk())
        );

        $letter->shouldReceive('getFile')->andReturn($mediaFile);

        $recipient = new Recipient();
        $mediaRecord = Mockery::mock(MediaRecord::class);
        $mediaRecord->shouldReceive('addFileFromContent');

        $pdf = $letter->generateFile($recipient, $mediaRecord);
        self::assertInstanceOf(Fpdi::class, $pdf);
    }
}
