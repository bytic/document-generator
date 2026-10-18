<?php
declare(strict_types=1);

namespace ByTIC\DocumentGenerator\PdfWriter;

use setasign\Fpdi\Tcpdf\Fpdi;
use TCPDF;

class DrawGuidelines
{
    protected Fpdi|TCPDF $pdf;

    public static function forPdf(Fpdi|TCPDF $pdf): self
    {
        $instance = new self();
        $instance->pdf = $pdf;

        return $instance;
    }

    public function draw(): void
    {
        for ($pos = 5; $pos < 791; $pos = $pos + 5) {
            if (($pos % 100) == 0) {
                $this->pdf->SetDrawColor(0, 0, 200);
                $this->pdf->SetLineWidth(.7);
            } elseif (($pos % 50) == 0) {
                $this->pdf->SetDrawColor(200, 0, 0);
                $this->pdf->SetLineWidth(.4);
            } else {
                $this->pdf->SetDrawColor(128, 128, 128);
                $this->pdf->SetLineWidth(.05);
            }

            $this->pdf->Line(0, $pos, 611, $pos);
            if ($pos < 611) {
                $this->pdf->Line($pos, 0, $pos, 791);
            }
        }
    }
}
