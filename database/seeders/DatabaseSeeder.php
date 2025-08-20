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
use Illuminate\Database\Seeder;

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
            // Pick a random subset of subjects, e.g., 5-8 subjects per curriculum
            $randomSubjects = collect($subjectIds)->shuffle()->take(rand(5, 8))->toArray();
            $curriculum->subjects()->attach($randomSubjects);
        });

        // 6. Create 10 Students per curriculum
        $students = $curriculums->map(function ($curriculum) {
            return Student::factory()->count(10)->create(['instructor_id' => $curriculum->instructor_id]);
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

        // 11. Create Lessons (2 per student per subject)
        $subjects = Subject::all();
        $students->each(function ($student) use ($subjects) {
            $randomSubjects = $subjects->shuffle()->take(2);

            foreach ($randomSubjects as $subject) {
                $lesson = Lesson::factory()->create([
                    'subject_id' => $subject->id,
                ]);

                $student->lessons()->attach($lesson->id);

                Video::factory()->create([
                    'lesson_id' => $lesson->id,
                ]);

                $quiz = Quiz::factory()->create([
                    'lesson_id' => $lesson->id,
                ]);

                $questions = Question::factory(3)->create([
                    'quiz_id' => $quiz->id,
                ]);

                $questions->each(function ($question) {
                    Option::factory(4)->create([
                        'question_id' => $question->id,
                    ]);
                });

                $activity = Activity::factory()->create([
                    'lesson_id' => $lesson->id,
                ]);

                Log::factory()->create([
                    'item_id' => $quiz->id,
                    'item_type' => Quiz::class,
                ]);

                Progress::factory()->create([
                    'item_id' => $quiz->id,
                    'item_type' => Quiz::class,
                ]);

                Log::factory()->create([
                    'item_id' => $activity->id,
                    'item_type' => Activity::class,
                ]);

                Progress::factory()->create([
                    'item_id' => $activity->id,
                    'item_type' => Activity::class,
                ]);
            }
        });


        // 12. Create Feeds
        $students->each(function ($student) {
            Feed::factory()->create(['notifiable_id' => $student->id, 'group' => 'student']);
        });

        Feed::factory()->count(30)->create();
    }
}
