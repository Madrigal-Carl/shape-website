<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Log;
use App\Models\Feed;
use App\Models\Quiz;
use App\Models\Admin;
use App\Models\Video;
use App\Models\Lesson;
use App\Models\Option;
use App\Models\Account;
use App\Models\Address;
use App\Models\Profile;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Activity;
use App\Models\Guardian;
use App\Models\Progress;
use App\Models\Question;
use App\Models\Curriculum;
use App\Models\Instructor;
use App\Models\LessonSubject;
use App\Models\ActivityLesson;
use Illuminate\Database\Seeder;
use App\Models\CurriculumSubject;
use App\Models\CurriculumStudentSubject;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create 3 Instructors
        $instructors = Instructor::factory()->count(3)->create();

        // 2. Create 3 Admins
        $admins = Admin::factory()->count(3)->create();

        // 3. Create Curriculums for each instructor
        $curriculums = $instructors->map(function ($instructor) {
            return Curriculum::factory()->count(2)->create(['instructor_id' => $instructor->id]);
        })->flatten();

        // 4. Create All Subjects
        Subject::factory()->allSubjects();

        // 5. Create Curriculum_Subject links
        $subjectIds = Subject::pluck('id')->toArray();

        $curriculums->each(function ($curriculum) use ($subjectIds) {
            // Pick a random subset of subjects for this curriculum
            $randomSubjects = collect($subjectIds)
                ->shuffle()
                ->take(rand(5, 8))
                ->toArray();

            foreach ($randomSubjects as $subjectId) {
                // Use firstOrCreate to avoid violating the unique constraint
                CurriculumSubject::firstOrCreate([
                    'curriculum_id' => $curriculum->id,
                    'subject_id' => $subjectId
                ]);
            }
        });

        // 6. Create 10 Students per curriculum
        $students = $curriculums->map(function ($curriculum) {
            return Student::factory()->count(5)->create(['instructor_id' => $curriculum->instructor_id]);
        })->flatten();

        // 7. Create Accounts
        // Instructor accounts
        $instructors->each(function ($instructor) {
        Account::factory()->instructor($instructor)->create([
            'username' => strtolower($instructor->first_name . $instructor->id),
            'password' => 'password123',
            ]);
        });

        // Admin accounts
        $admins->each(function ($admin) {
            Account::factory()->admin($admin)->create([
                'username' => strtolower($admin->first_name . $admin->id),
                'password' => 'password123',
            ]);
        });

        // Student accounts
        $students->each(function ($student) {
            Account::factory()->student($student)->create([
                'username' => strtolower($student->first_name . $student->id),
                'password' => 'password123',
            ]);
        });

        // 8. Create Guardians
        $students->each(function ($student) {
            Guardian::factory()->create(['student_id' => $student->id]);
        });

        // 9. Create Profiles
        $students->each(function ($student) {
            Profile::factory()->create(['student_id' => $student->id]);
        });

        // 10. Create Addresses
        $students->each(function ($student) {
            Address::factory()->student()->create(['owner_id' => $student->id, 'owner_type' => 'App\Models\Student']);
        });

        $instructors->each(function ($instructor) {
            Address::factory()->instructor()->create(['owner_id' => $instructor->id, 'owner_type' => 'App\Models\Instructor']);
        });

        // 11. Create Lessons
        $activities = Activity::factory()->count(20)->create();

        $students->each(function ($student) use ($activities, $curriculums) {
            $curriculums->each(function ($curriculum) use ($student, $activities) {
                // Get subjects that belong to THIS curriculum only
                $curriculumSubjectIds = CurriculumSubject::where('curriculum_id', $curriculum->id)
                    ->pluck('id')
                    ->toArray();

                // Pick random subjects from this curriculum
                $randomSubjects = collect($curriculumSubjectIds)
                    ->shuffle()
                    ->take(rand(3, 5)); // you can adjust how many

                foreach ($randomSubjects as $curriculumSubjectId) {
                    // Create or get lesson_subject
                    $lessonSubject = LessonSubject::firstOrCreate([
                        'curriculum_subject_id' => $curriculumSubjectId,
                        'student_id'            => $student->id,
                    ]);

                    // Create Lesson linked to this lesson_subject
                    $lesson = Lesson::factory()->create([
                        'lesson_subject_id' => $lessonSubject->id,
                    ]);

                    // Add video
                    Video::factory()->create([
                        'lesson_id' => $lesson->id,
                    ]);

                    // Attach random activity
                    $activity = $activities->random();
                    $activityLesson = ActivityLesson::factory()->create([
                        'lesson_id'   => $lesson->id,
                        'activity_id' => $activity->id,
                    ]);

                    // Create quiz
                    $quiz = Quiz::factory()->create([
                        'lesson_id' => $lesson->id,
                    ]);

                    // Create questions + options
                    $questions = Question::factory(3)->create([
                        'quiz_id' => $quiz->id,
                    ]);

                    $questions->each(function ($question) {
                        Option::factory(4)->create([
                            'question_id' => $question->id,
                        ]);
                    });

                    // Logs + progress
                    Log::factory()->create([
                        'item_id'   => $quiz->id,
                        'item_type' => Quiz::class,
                    ]);

                    Progress::factory()->create([
                        'item_id'   => $quiz->id,
                        'item_type' => Quiz::class,
                    ]);

                    Log::factory()->create([
                        'item_id'   => $activityLesson->id,
                        'item_type' => ActivityLesson::class,
                    ]);

                    Progress::factory()->create([
                        'item_id'   => $activityLesson->id,
                        'item_type' => ActivityLesson::class,
                    ]);
                }
            });
        });



        // 12. Create Feeds
        $students->each(function ($student) {
            Feed::factory()->create(['notifiable_id' => $student->id, 'group' => 'student']);
        });

        Feed::factory()->count(30)->create();
    }
}
