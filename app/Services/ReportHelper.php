<?php

namespace App\Services;

use Exception;
use App\Models\Todo;
use App\Models\Student;
use App\Models\SchoolYear;
use PhpOffice\PhpWord\TemplateProcessor;

class ReportHelper
{
    public function getAutismStudentActivities($studentId, $schoolYearId = null, $quarter = null)
    {
        $student = Student::with([
            'lessons.classActivities.todo',
            'lessons.gameActivityLessons.gameActivity.todo',
        ])->findOrFail($studentId);

        $schoolYearId = $schoolYearId ?? now()->schoolYear()?->id;
        $schoolYear   = SchoolYear::findOrFail($schoolYearId);

        $results = [];

        foreach ($student->lessons as $lesson) {
            // Determine lesson quarter
            $lessonQuarter = null;
            foreach ([1, 2, 3, 4] as $q) {
                if ($lesson->isInQuarter($schoolYear, $q)) {
                    $lessonQuarter = $q;
                    break;
                }
            }
            if (!$lessonQuarter) continue;

            // Skip if lesson quarter > requested quarter
            if ($quarter && $lessonQuarter > $quarter) {
                continue;
            }

            // class activities
            foreach ($lesson->classActivities as $activity) {
                if (!$activity->todo) continue;

                $todoKey = 't' . $activity->todo->id;
                $field   = $todoKey . '.q' . $lessonQuarter;

                $status = $student->activityStatus($activity);
                if ($status) {
                    $results[$field][] = $status;
                }
            }

            // game activities
            foreach ($lesson->gameActivityLessons as $activity) {
                if (!$activity->gameActivity?->todo) continue;

                $todoKey = 't' . $activity->gameActivity->todo->id;
                $field   = $todoKey . '.q' . $lessonQuarter;

                $status = $student->activityStatus($activity);
                if ($status) {
                    $results[$field][] = $status;
                }
            }
        }

        // Aggregate ratings
        $final = [];
        $allTodos = Todo::pluck('id')->toArray();

        foreach ($allTodos as $todoId) {
            for ($q = 1; $q <= 4; $q++) {
                $key = 't' . $todoId . '.q' . $q;

                // Future quarters remain blank
                if ($quarter && $q > $quarter) {
                    $final[$key] = '';
                    continue;
                }

                $statuses = $results[$key] ?? [];
                $total = count($statuses);

                if ($total === 0) {
                    $final[$key] = 'NO/NA'; // No activities for this todo in this quarter
                    continue;
                }

                $finishedCount = collect($statuses)->filter(fn($s) => $s === 'finished')->count();
                $completionRate = $finishedCount / $total;

                if ($completionRate === 1) {
                    $final[$key] = 'P';
                } elseif ($completionRate > 0.5) {
                    $final[$key] = 'AP';
                } elseif ($completionRate >= 0.3) {
                    $final[$key] = 'D';
                } elseif ($completionRate > 0 && $completionRate <= 0.2) {
                    $final[$key] = 'B';
                } else {
                    $final[$key] = 'NO/NA';
                }
            }
        }

        return $final;
    }


    public function generateAutismReportCard($studentId, $schoolYearId = null, $quarter = null)
    {
        $templatePath = resource_path('templates/autism-report-card.docx');

        if (!file_exists($templatePath)) {
            throw new Exception('Template not found: ' . $templatePath);
        }

        $reportHelper = new self();

        // Load student
        $student = Student::findOrFail($studentId);
        $studentFullName = $student->full_name ?? $student->name ?? 'N_A';
        $studentActivities = $reportHelper->getAutismStudentActivities($studentId, $schoolYearId, $quarter);
        $studentActivities['student_name'] = $studentFullName;

        // Load school year
        $schoolYear = $schoolYearId ? SchoolYear::findOrFail($schoolYearId) : now()->schoolYear();
        $schoolYearName = str_replace(' ', '_', $schoolYear->name ?? 'UnknownYear'); // replace spaces with underscores
        $quarterLabel = $quarter ? 'Q' . $quarter : 'AllQuarters';

        // Generate filename
        $studentFullNameSafe = preg_replace('/[^A-Za-z0-9_\-]/', '_', $studentFullName);
        $fileName = "{$schoolYearName}_{$quarterLabel}_{$studentFullNameSafe}.docx";
        $outputPath = storage_path('app/' . $fileName);

        // Load all todos from DB to generate all possible placeholders
        $allTodos = Todo::pluck('id')->toArray();
        $allQuarters = [1, 2, 3, 4];

        // Initialize blank placeholders
        $allPlaceholders = [];
        foreach ($allTodos as $todoId) {
            foreach ($allQuarters as $q) {
                $key = 't' . $todoId . '.q' . $q;
                $allPlaceholders[$key] = '';
            }
        }

        // Merge actual student activities
        $allPlaceholders = array_merge($allPlaceholders, $studentActivities);

        // Load template and replace placeholders
        $templateProcessor = new TemplateProcessor($templatePath);
        foreach ($allPlaceholders as $key => $value) {
            $templateProcessor->setValue($key, (string) $value);
        }

        $templateProcessor->saveAs($outputPath);

        // Return as download
        return response()->download($outputPath)->deleteFileAfterSend(true);
    }

    public function generateSpeechHearingReportCard($studentId, $schoolYearId = null, $quarter = null) {}
}
