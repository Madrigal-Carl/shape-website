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

                $imagePlaceholder = "image{$i}#{$page}";
                $namePlaceholder  = "name{$i}#{$page}";

                $imageIndex++;

                if ($imageIndex <= $awardeeCount) {

                    // insert image
                    $templateProcessor->setImageValue($imagePlaceholder, [
                        'path'   => $imageFullPath,
                        'width'  => 200,
                        'height' => 270,
                        'ratio'  => false,
                    ]);

                    // insert the awardee name
                    $templateProcessor->setValue($namePlaceholder, $awardeeNames[$imageIndex - 1]);
                } else {
                    // empty slots
                    $templateProcessor->setValue($imagePlaceholder, '');
                    $templateProcessor->setValue($namePlaceholder, '');
                }
            }
        }

        $awardeesList = implode("\n- ", $awardeeNames);
        $awardeesList = '- ' . $awardeesList;

        // Save & return
        $safeName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $awardName);
        $fileName = 'Award_Print_' . $safeName . '_' . now()->format('Ymd_His') . '.docx';
        $outputPath = storage_path('app/' . $fileName);

        $templateProcessor->saveAs($outputPath);

        return Response::download($outputPath)->deleteFileAfterSend(true);
    }
}
