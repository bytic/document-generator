<?php

namespace ByTIC\DocumentGenerator\Tests\PdfLetters;

use ByTIC\DocumentGenerator\Tests\AbstractTest;
use ByTIC\DocumentGenerator\Tests\Fixtures\Models\PdfLetters\PdfLetter;
use ByTIC\DocumentGenerator\Tests\Fixtures\Models\Recipients\Recipient;

/**
 * Class PdfLetterTraitTest
 * @package ByTIC\DocumentGenerator\Tests\PdfLetters
 */
class PdfLetterTraitTest extends AbstractTest
{
    public function testGenerateFile()
    {
        $recipient = new Recipient();
        $letter = new PdfLetter();
        $letter->id = 99;

        $letter->generateFile($recipient);
    }
}
