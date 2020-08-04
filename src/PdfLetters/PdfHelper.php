<?php

namespace ByTIC\DocumentGenerator\PdfLetters;

use setasign\Fpdi\Tcpdf\Fpdi;

/**
 * Class PdfHelper
 * @package ByTIC\DocumentGenerator\PdfLetters
 */
class PdfHelper
{
    /**
     * @param Fpdi $pdf
     * @param $value
     * @param $x
     * @param null $align
     * @return int|string
     */
    public static function pdfXPosition($pdf, $value, $x, $align = null)
    {
        switch ($align) {
            case 'center':
                return $x - ($pdf->GetStringWidth($value) / 2);
            case 'right':
                $x = $x - $pdf->GetStringWidth($value);
                if ($x < 0) {
                    $x = 0;
                }
                return $x;
            case 'left':
            default:
                return $x;
        }
    }

    /**
     * @param Fpdi $pdf
     * @param $value
     * @param $y
     * @return int|string
     */
    public static function pdfYPosition($pdf, $value, $y)
    {
        $page = 1;
        if ($y > 297) {
            $page = round($y / 297, 0);
            $y -= ($page * 297);
            $page++;
        }

        if ($pdf->getPage() != $page && $page <= $pdf->getNumPages()) {
            $pdf->setPage($page);
        }

        return $y;
    }

    /**
     * @param Fpdi $pdf
     * @param array $colors
     * @param bool $ret
     * @return string
     */
    public static function pdfPrepareColor($pdf, $colors = [], $ret = false)
    {
        if (is_array($colors) && count($colors) >= 3) {
            return $pdf->SetTextColorArray($colors, $ret);
        }
        return $pdf->SetTextColor(0, 0, 0, $ret);
    }
}
