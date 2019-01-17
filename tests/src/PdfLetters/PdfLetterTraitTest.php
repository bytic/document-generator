<?php

namespace ByTIC\DocumentGenerator\Tests\PdfLetters;

use ByTIC\DocumentGenerator\Tests\AbstractTest;
use ByTIC\DocumentGenerator\Tests\Fixtures\Models\PdfLetters\PdfLetter;
use ByTIC\DocumentGenerator\Tests\Fixtures\Models\Recipients\Recipient;
use ByTIC\MediaLibrary\Media\Media;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class PdfLetterTraitTest
 * @package ByTIC\DocumentGenerator\Tests\PdfLetters
 */
class PdfLetterTraitTest extends AbstractTest
{
    /**
     *
     */
    public function testUploadFromRequestValid()
    {
        $letter = new PdfLetter();
        $letter->id = 10;

        $uploadedFile = new UploadedFile(
            TEST_FIXTURE_PATH . '/files/file.pdf',
            'test original name.pdf',
            null,
            null,
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

        $uploadedFile = new UploadedFile(
            TEST_FIXTURE_PATH . '/files/file.pdf',
            'test original name.doc',
            null,
            null,
            null,
            true
        );

        $response = $letter->uploadFromRequest($uploadedFile);
        parent::assertSame('INVALID_MIME_TYPE_ERROR', $response);
    }

    public function testGenerateFile()
    {
        $recipient = new Recipient();
        $letter = new PdfLetter();
        $letter->id = 99;

        $letter->generateFile($recipient);
    }
}
