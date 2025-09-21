<?php

namespace App\Services;

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\SimpleType\JcTable;
use Illuminate\Support\Facades\Response;

class ReportHelper
{
    public static function generateLearningProgressReport(string $fileName = 'learning-progress.docx')
    {
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        // Title
        $section->addText(
            'REPORT ON LEARNING PROGRESS AND ACHIEVEMENT',
            ['bold' => true],
            ['align' => 'center']
        );

        // Progress Table
        $table = $section->addTable([
            'borderSize' => 6,
            'borderColor' => '000000',
            'alignment'   => JcTable::CENTER,
        ]);

        // Header Row
        $table->addRow();
        $table->addCell(4000)->addText('LEARNING DOMAINS', ['bold' => true], ['align' => 'center']);
        $table->addCell(1000)->addText('1st', ['bold' => true], ['align' => 'center']);
        $table->addCell(1000)->addText('2nd', ['bold' => true], ['align' => 'center']);
        $table->addCell(1000)->addText('3rd', ['bold' => true], ['align' => 'center']);
        $table->addCell(1000)->addText('4th', ['bold' => true], ['align' => 'center']);
        $table->addCell(1200)->addText('FINAL RATING', ['bold' => true], ['align' => 'center']);

        // Learning Domains
        $domains = [
            'I. SELF-HELP SKILLS',
            'II. SOCIAL SKILLS',
            'III. NUMERACY SKILLS',
            'IV. LITERACY SKILLS',
            'V. LANGUAGE / COMMUNICATION SKILLS',
            'VI. MOTOR SKILLS',
            '• Gross Motor Skills',
            '• Fine Motor Skills',
            'VII. PRE-VOCATIONAL SKILLS',
            'VIII. VOCATIONAL SKILLS',
            'IX. ORIENTATION AND MOBILITY (For Children with Visual Impairment)',
        ];

        foreach ($domains as $domain) {
            $table->addRow();
            $table->addCell(4000)->addText($domain);
            for ($i = 0; $i < 5; $i++) {
                $table->addCell(1000)->addText('');
            }
        }

        $section->addText(
            "The descriptive rating system used in this learner progress report is based upon your child's individual progress at his/her level of capability.",
            ['italic' => true, 'size' => 9],
            ['align' => 'center']
        );

        $section->addTextBreak(1);

        // Scoring and Performance Criteria
        $section->addText('SCORING AND PERFORMANCE CRITERIA', ['bold' => true], ['align' => 'center']);

        $criteriaTable = $section->addTable(['borderSize' => 6, 'borderColor' => '000000']);
        $criteriaTable->addRow();
        $criteriaTable->addCell(1500)->addText('Performance Code', ['bold' => true], ['align' => 'center']);
        $criteriaTable->addCell(2500)->addText('Description', ['bold' => true], ['align' => 'center']);
        $criteriaTable->addCell(5000)->addText('Performance Criteria', ['bold' => true], ['align' => 'center']);

        $rows = [
            ['M', 'Mastered', 'Student is able to perform skill independently with 90-100% accuracy'],
            ['P', 'Progressing', 'The student is able to perform skill with 70-89% accuracy and minimal prompts/cues'],
            ['D', 'Developing', 'The student is able to perform skill with 50-69% accuracy and moderate prompts/cues'],
            ['E', 'Emerging', 'The student is able to perform skill with 50% accuracy and maximal assistance'],
            ['NI / NA', 'Needs Improvement / Not Applicable', 'No manifestation of the skills at all (Reconsider Target) / Not Applicable'],
        ];

        foreach ($rows as $row) {
            $criteriaTable->addRow();
            $criteriaTable->addCell(1500)->addText($row[0], ['bold' => true], ['align' => 'center']);
            $criteriaTable->addCell(2500)->addText($row[1], [], ['align' => 'center']);
            $criteriaTable->addCell(5000)->addText($row[2]);
        }

        // Save
        $tempFile = tempnam(sys_get_temp_dir(), $fileName);
        IOFactory::createWriter($phpWord, 'Word2007')->save($tempFile);

        return Response::download($tempFile, $fileName)->deleteFileAfterSend(true);
    }
}
