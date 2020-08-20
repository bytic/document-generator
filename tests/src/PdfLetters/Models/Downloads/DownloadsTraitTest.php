<?php

namespace ByTIC\DocumentGenerator\Tests\PdfLetters\Models\Downloads;

use ByTIC\DocumentGenerator\Tests\AbstractTest;
use ByTIC\DocumentGenerator\Tests\Fixtures\Models\Downloads\Downloads;
use ByTIC\DocumentGenerator\Tests\Fixtures\Models\PdfLetters\PdfLetter;
use DateInterval;

/**
 * Class DownloadsTraitTest
 * @package ByTIC\DocumentGenerator\Tests\Models\Downloads
 */
class DownloadsTraitTest extends AbstractTest
{
    public function test_shouldTrackLetter()
    {
        $letter = new PdfLetter();

        $letter->issueDate = (new \DateTime())->add(new DateInterval('P10D'));
        self::assertTrue(Downloads::instance()->shouldTrackLetter($letter));

        $letter->issueDate = (new \DateTime())->sub(new DateInterval('P10D'));
        self::assertTrue(Downloads::instance()->shouldTrackLetter($letter));

        $letter->issueDate = (new \DateTime())->sub(new DateInterval('P30D'));
        self::assertTrue(Downloads::instance()->shouldTrackLetter($letter));

        $letter->issueDate = (new \DateTime())->sub(new DateInterval('P61D'));
        self::assertFalse(Downloads::instance()->shouldTrackLetter($letter));
    }
}
