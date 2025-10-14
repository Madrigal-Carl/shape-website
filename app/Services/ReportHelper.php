<?php

namespace App\Services;

use Exception;
use Carbon\Carbon;
use App\Models\Todo;
use App\Models\Student;
use App\Models\SchoolYear;
use PhpOffice\PhpWord\TemplateProcessor;

class ReportHelper
{
    public function getAutismStudentActivities($studentId, $schoolYearId = null, $quarter = null)
    {
        $student = Student::with([
            'lessons.classActivities.todos',
            'lessons.gameActivityLessons.gameActivity.todos',
        ])->findOrFail($studentId);
        $schoolYearId = $schoolYearId ?? now()->schoolYear()?->id;
        $schoolYear   = SchoolYear::findOrFail($schoolYearId);
        $results = [];

        // Collect all activities from lessons up to the given quarter
        foreach ($student->lessons as $lesson) {
            // Determine the lesson quarter
            $lessonQuarter = null;
            foreach ([1, 2, 3, 4] as $q) {
                if ($lesson->isInQuarter($schoolYear, $q)) {
                    $lessonQuarter = $q;
                    break;
                }
            }

            // Skip if lesson not in a quarter or quarter beyond selected
            if (!$lessonQuarter || ($quarter && $lessonQuarter > $quarter))
                continue;

            // ----- CLASS ACTIVITIES -----
            foreach ($lesson->classActivities as $activity) {
                if ($activity->todos->isEmpty()) continue;

                foreach ($activity->todos as $todo) {
                    $todoKey = 't' . $todo->id;
                    $field = $todoKey . '.q' . $lessonQuarter;

                    $status = $student->activityStatus($activity);
                    if ($status) {
                        $results[$field][] = $status;
                    }
                }
            }

            // ----- GAME ACTIVITIES -----
            foreach ($lesson->gameActivityLessons as $activity) {
                if ($activity->todos->isEmpty()) continue;

                foreach ($activity->todos as $todo) {
                    $todoKey = 't' . $todo->id;
                    $field = $todoKey . '.q' . $lessonQuarter;

                    $status = $student->activityStatus($activity);
                    if ($status) {
                        $results[$field][] = $status;
                    }
                }
            }
        }

        // Aggregate results for each todo and quarter
        $final = [];
        $allTodos = Todo::pluck('id')->toArray();

        foreach ($allTodos as $todoId) {
            for ($q = 1; $q <= 4; $q++) {
                $key = 't' . $todoId . '.q' . $q;

                // Future quarters (beyond selected) remain blank
                if ($quarter && $q > $quarter) {
                    $final[$key] = '';
                    continue;
                }

                $statuses = $results[$key] ?? [];

                // 1️⃣ If no activities at all → NA (not blank)
                if (empty($statuses)) {
                    $final[$key] = 'NA';
                    continue;
                }

                // 2️⃣ Compute completion rate
                $total = count($statuses);
                $finishedCount = collect($statuses)->filter(fn($s) => $s === 'finished')->count();
                $completionRate = $finishedCount / $total;

                // 3️⃣ Assign performance rating
                if ($completionRate >= 0.9) {
                    $final[$key] = 'P';
                } elseif ($completionRate >= 0.7) {
                    $final[$key] = 'AP';
                } elseif ($completionRate >= 0.4) {
                    $final[$key] = 'D';
                } elseif ($completionRate >= 0.2) {
                    $final[$key] = 'B';
                } else {
                    $final[$key] = 'NO';
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

        // Get activities (this method already respects up-to-quarter logic)
        $studentActivities = $reportHelper->getAutismStudentActivities($studentId, $schoolYearId, $quarter);
        $studentActivities['student_name'] = $studentFullName;

        // Load school year
        $schoolYear = $schoolYearId ? SchoolYear::findOrFail($schoolYearId) : now()->schoolYear();
        $schoolYearName = str_replace(' ', '_', $schoolYear->name ?? 'UnknownYear');
        $quarterLabel = $quarter ? 'Q' . $quarter : 'AllQuarters';

        // Generate filename
        $studentFullNameSafe = preg_replace('/[^A-Za-z0-9_\-]/', '_', $studentFullName);
        $fileName = "{$schoolYearName}_{$quarterLabel}_{$studentFullNameSafe}.docx";
        $outputPath = storage_path('app/' . $fileName);

        // Load all todos and quarters
        $allTodos = Todo::pluck('id')->toArray();
        $allQuarters = [1, 2, 3, 4];

        // Initialize placeholders
        $allPlaceholders = [];

        foreach ($allTodos as $todoId) {
            foreach ($allQuarters as $q) {
                $key = 't' . $todoId . '.q' . $q;

                if ($quarter && $q > $quarter) {
                    $allPlaceholders[$key] = '';
                    continue;
                }

                if (array_key_exists($key, $studentActivities)) {
                    $value = $studentActivities[$key];
                    $allPlaceholders[$key] = $value;
                } else {
                    $allPlaceholders[$key] = ($quarter && $q <= $quarter) ? 'NO/NA' : '';
                }
            }
        }

        // Merge into the Word template
        $templateProcessor = new TemplateProcessor($templatePath);

        foreach ($allPlaceholders as $key => $value) {
            $templateProcessor->setValue($key, (string) $value);
        }

        $templateProcessor->saveAs($outputPath);

        return response()->download($outputPath)->deleteFileAfterSend(true);
    }


    public function getSpeechHearingStudentActivities($studentId, $schoolYearId = null, $quarter = null)
    {
        $student = Student::with([
            'lessons.classActivities.todos',
            'lessons.gameActivityLessons.gameActivity.todos',
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

            // Class activities
            foreach ($lesson->classActivities as $activity) {
                if ($activity->todos->isEmpty()) continue;

                foreach ($activity->todos as $todo) {
                    $todoKey = 't' . $todo->id;
                    $field = $todoKey . '.q' . $lessonQuarter;

                    $status = $student->activityStatus($activity);
                    if ($status) {
                        $results[$field][] = $status;
                    }
                }
            }

            // Game activities
            foreach ($lesson->gameActivityLessons as $activity) {
                if ($activity->todos->isEmpty()) continue;

                foreach ($activity->todos as $todo) {
                    $todoKey = 't' . $todo->id;
                    $field = $todoKey . '.q' . $lessonQuarter;

                    $status = $student->activityStatus($activity);
                    if ($status) {
                        $results[$field][] = $status;
                    }
                }
            }
        }

        // --- Aggregate ratings ---
        $final = [];
        $allTodos = Todo::pluck('id')->toArray();

        foreach ($allTodos as $todoId) {
            for ($q = 1; $q <= 4; $q++) {
                $key = 't' . $todoId . '.q' . $q;

                // Skip future quarters
                if ($quarter && $q > $quarter) {
                    $final[$key] = '';
                    continue;
                }

                $statuses = $results[$key] ?? [];
                $total = count($statuses);

                // If no activities at all → NYI
                if ($total === 0) {
                    $final[$key] = 'NYI';
                    continue;
                }

                $finishedCount = collect($statuses)->filter(fn($s) => $s === 'finished')->count();
                $completionRate = $total > 0 ? $finishedCount / $total : 0;

                // Assign performance rating
                if ($completionRate >= 0.9) {
                    $final[$key] = 'M';
                } elseif ($completionRate >= 0.7) {
                    $final[$key] = 'S';
                } elseif ($completionRate >= 0.4) {
                    $final[$key] = 'FS';
                } elseif ($completionRate >= 0.2) {
                    $final[$key] = 'AIN';
                } else {
                    $final[$key] = 'AIN';
                }
            }
        }

        return $final;
    }

    public function generateSpeechHearingReportCard($studentId, $schoolYearId = null, $quarter = null)
    {
        $templatePath = resource_path('templates/speech-hearing-report-card.docx');

        if (!file_exists($templatePath)) {
            throw new Exception('Template not found: ' . $templatePath);
        }

        $reportHelper = new self();

        // --- Load student ---
        $student = Student::findOrFail($studentId);
        $studentFullName = $student->full_name ?? $student->name ?? 'N_A';

        // --- Get student activity ratings ---
        $studentActivities = $reportHelper->getSpeechHearingStudentActivities($studentId, $schoolYearId, $quarter);
        $studentActivities['student_name'] = $studentFullName;

        // --- Load school year ---
        $schoolYear = $schoolYearId ? SchoolYear::findOrFail($schoolYearId) : now()->schoolYear();
        $schoolYearName = str_replace(' ', '_', $schoolYear->name ?? 'UnknownYear');
        $quarterLabel = $quarter ? 'Q' . $quarter : 'AllQuarters';

        // --- Generate filename ---
        $studentFullNameSafe = preg_replace('/[^A-Za-z0-9_\-]/', '_', $studentFullName);
        $fileName = "{$schoolYearName}_{$quarterLabel}_{$studentFullNameSafe}.docx";
        $outputPath = storage_path('app/' . $fileName);

        // --- Prepare all possible placeholders ---
        $allTodos = Todo::pluck('id')->toArray();
        $allQuarters = [1, 2, 3, 4];

        $allPlaceholders = [];
        foreach ($allTodos as $todoId) {
            foreach ($allQuarters as $q) {
                $key = 't' . $todoId . '.q' . $q;
                $allPlaceholders[$key] = '';
            }
        }

        // --- Merge activity data into placeholders ---
        $allPlaceholders = array_merge($allPlaceholders, $studentActivities);

        // --- Static student info placeholders ---
        $enrollment = $student->enrollments()
            ->where('school_year_id', $schoolYear->id)
            ->first();

        $birthDate = $student->birth_date
            ? Carbon::parse($student->birth_date)->format('F j, Y')
            : 'N/A';

        $gradeLevel = $enrollment?->gradeLevel?->name ?? 'N/A';
        $gradeLevel = preg_replace('/^grade\s*/i', '', $gradeLevel);

        $disabilityType = ucfirst($student->disability_type ?? 'N/A');

        $start = Carbon::parse($schoolYear->first_quarter_start)->format('F Y');
        $end = Carbon::parse($schoolYear->fourth_quarter_end)->format('F Y');
        $covered = "{$start} - {$end}";

        $staticInfo = [
            'name' => strtoupper($student->full_name),
            'sy' => $schoolYear->name,
            'birth_date' => $birthDate,
            'grade_level' => $gradeLevel,
            'disability_type' => $disabilityType,
            'covered' => $covered,
        ];

        // --- Merge static + dynamic placeholders ---
        $finalPlaceholders = array_merge($allPlaceholders, $staticInfo);

        // --- Fill the Word template ---
        $templateProcessor = new TemplateProcessor($templatePath);
        foreach ($finalPlaceholders as $key => $value) {
            $templateProcessor->setValue($key, (string) $value);
        }

        $templateProcessor->saveAs($outputPath);

        // --- Return the generated file ---
        return response()->download($outputPath)->deleteFileAfterSend(true);
    }
}
