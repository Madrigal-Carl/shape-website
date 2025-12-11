<?php

namespace App\Services;

use App\Models\Student;
use App\Models\GradeLevel;
use App\Models\Instructor;
use App\Models\SchoolYear;
use App\Models\Specialization;
use PhpOffice\PhpWord\TemplateProcessor;

class ClassRecordHelper
{
    public function generateClassRecord($instructorId, $disabilityId, $gradeLevelId)
    {

        // --- Find grade level ---
        $gradeLevel = GradeLevel::findOrFail($gradeLevelId);

        // --- Find specialization ---
        $spec = Specialization::findOrFail($disabilityId);

        // --- Latest school year ---
        $latestSY = SchoolYear::orderBy('id', 'desc')->first();

        // --- Fetch students ---
        $students = Student::whereHas('enrollments', function ($q) use ($gradeLevelId, $instructorId, $latestSY) {
            $q->where('instructor_id', $instructorId)
                ->where('grade_level_id', $gradeLevelId)
                ->where('school_year_id', $latestSY->id)
                ->where('status', '!=', 'pending');
        })
            ->where('disability_type', $spec->name)
            ->orderBy('last_name')
            ->get();

        // --- Load template ---
        $templatePath = resource_path('templates/class-record.docx');
        $template = new TemplateProcessor($templatePath);

        // --- Static fields ---
        $template->setValue('school_year', $latestSY->name);
        $template->setValue('grade_level', ucwords($gradeLevel->name));
        $template->setValue('disability_type', ucwords($spec->name));
        $template->setValue('instructor', $this->getInstructorName($instructorId));

        // --- Split students into groups of 12 ---
        $chunks = $students->chunk(12);

        // --- Clone template block for the number of pages needed ---
        $template->cloneBlock('students_block', max(1, $chunks->count()), true, true);

        // --- Loop through each block ---
        $pageIndex = 1;

        foreach ($chunks as $chunk) {

            // Starting number (1, 13, 25, ...)
            $startNum = (($pageIndex - 1) * 12) + 1;

            for ($i = 0; $i < 12; $i++) {

                $numPlaceholder = "num" . ($i + 1) . "#" . $pageIndex;
                $namePlaceholder = "student" . ($i + 1) . "#" . $pageIndex;

                // Auto-number buttons 1–12, then 13–24, etc.
                $template->setValue($numPlaceholder, $startNum + $i);

                // Put student name or blank
                if (isset($chunk[$i])) {
                    $template->setValue($namePlaceholder, $chunk[$i]->full_name);
                } else {
                    $template->setValue($namePlaceholder, "");
                }
            }

            $pageIndex++;
        }

        // --- Save output ---
        $fileName = "Class_Record_{$spec->name}_{$latestSY->name}.docx";
        $outputPath = storage_path("app/$fileName");

        $template->saveAs($outputPath);

        return response()->download($outputPath)->deleteFileAfterSend(true);
    }

    private function getInstructorName($id)
    {
        $user = Instructor::find($id);
        return $user ? $user->fullname : 'N/A';
    }
}
