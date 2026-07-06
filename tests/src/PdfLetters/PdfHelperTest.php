<?php

namespace ByTIC\DocumentGenerator\Tests\PdfLetters;

use ByTIC\DocumentGenerator\PdfLetters\PdfHelper;
use ByTIC\DocumentGenerator\Tests\AbstractTest;

class PdfHelperTest extends AbstractTest
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

        $y = PdfHelper::pdfYPosition($pdf, 'test', 24, 3);

        self::assertSame(24, $y);
        self::assertSame(3, $pdf->getPage());
    }
}
