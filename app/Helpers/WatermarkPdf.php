<?php

namespace App\Helpers;

use setasign\Fpdi\Fpdi;

class WatermarkPdf
{
    public static function addWatermark($inputPath, $outputPath, $userName, $userPhone)
    {
        $pdf = new Fpdi();
        $pageCount = $pdf->setSourceFile($inputPath);

        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $templateId = $pdf->importPage($pageNo);
            $size = $pdf->getTemplateSize($templateId);

            $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
            $pdf->useTemplate($templateId);

            $pdf->SetFont('Arial', 'B', 18);
            $pdf->SetTextColor(190, 190, 190);
            $x = $size['width'] / 2;
            $y = $size['height'] / 2;
            $pdf->SetXY($x - 50, $y - 8);
            $pdf->Cell(100, 8, $userName, 0, 0, 'C');
            $pdf->SetXY($x - 50, $y + 2);
            $pdf->Cell(100, 8, $userPhone, 0, 0, 'C');
        }

        $pdf->Output('F', $outputPath);
        return true;
    }
}
