<?php

namespace ByTIC\DocumentGenerator\Tests\Letters;

use ByTIC\DocumentGenerator\PdfWriter\LetterHelper;
use ByTIC\DocumentGenerator\Tests\AbstractTest;

class LetterHelperTest extends AbstractTest
{
    public function testPdfYPositionUsesExplicitPageWithoutChangingCoordinates()
    {
        $pdf = new class() {
            private int $page = 1;

            public function getPage(): int
            {
                return $this->page;
            }

            public function getNumPages(): int
            {
                return 5;
            }

            public function setPage($page): void
            {
                $this->page = (int)$page;
            }
        };

        $y = LetterHelper::pdfYPosition($pdf, 'test', 24, 3);

        self::assertSame(24, $y);
        self::assertSame(3, $pdf->getPage());
    }
}
