<?php

namespace App\Services;

use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Facades\Response;
use Exception;

class AwardPrinterHelper
{
    public static function generate(string $awardName, array $awardeeNames, string $imagePath)
    {
        $templatePath = resource_path('templates/award-template.docx');
        if (!file_exists($templatePath)) {
            throw new Exception("Template not found at: $templatePath");
        }

        $templateProcessor = new TemplateProcessor($templatePath);

        $imageFullPath = storage_path('app/public/' . $imagePath);
        if (!file_exists($imageFullPath)) {
            throw new Exception("Award image not found at: $imageFullPath");
        }

        // Each block (page) can hold 6 images
        $perPage = 6;
        $awardeeCount = count($awardeeNames);
        $pages = (int) ceil($awardeeCount / $perPage);

        // Clone the block according to how many pages we need
        $templateProcessor->cloneBlock('award_block', $pages, true, true);

        $imageIndex = 0;

        for ($page = 1; $page <= $pages; $page++) {
            for ($i = 1; $i <= $perPage; $i++) {
                $placeholder = "image{$i}#{$page}";
                $imageIndex++;

                if ($imageIndex <= $awardeeCount) {
                    $templateProcessor->setImageValue($placeholder, [
                        'path'   => $imageFullPath,
                        'width'  => 220,
                        'height' => 290,
                        'ratio'  => false,
                    ]);
                } else {
                    $templateProcessor->setValue($placeholder, '');
                }
            }
        }

        $lastPage = $pages;
        $awardeesList = implode("\n- ", $awardeeNames);
        $awardeesList = '- ' . $awardeesList;
        $templateProcessor->setValue("awardees_names#{$lastPage}", $awardeesList);

        // Save & return
        $safeName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $awardName);
        $fileName = 'Award_Print_' . $safeName . '_' . now()->format('Ymd_His') . '.docx';
        $outputPath = storage_path('app/' . $fileName);

        $templateProcessor->saveAs($outputPath);

        return Response::download($outputPath)->deleteFileAfterSend(true);
    }
}
