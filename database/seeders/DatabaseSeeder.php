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
use App\Models\Question;
use App\Models\Curriculum;
use App\Models\Instructor;
use App\Models\ActivityLesson;
use App\Models\Specialization;
use Illuminate\Database\Seeder;
use App\Models\CurriculumSubject;
use App\Models\LessonSubjectStudent;
use App\Models\ActivityImage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $specializations = collect([
            Specialization::firstOrCreate(['name' => 'autism spectrum disorder']),
            Specialization::firstOrCreate(['name' => 'speech disorder']),
            Specialization::firstOrCreate(['name' => 'hearing impairment']),
        ]);

        // 1. Create Instructors
        $instructors = Instructor::factory()->count(3)->create();
        $instructors->each(function ($instructor) use ($specializations) {
            $instructor->specializations()->attach(
                $specializations->random(rand(1, 2))->pluck('id')->toArray()
            );
        });

        // 2. Create Admins
        $admins = Admin::factory()->count(3)->create();

        // 3. Create Curriculums for each instructor
        $curriculums = $instructors->map(function ($instructor) {
            return Curriculum::factory()->count(2)->create(['instructor_id' => $instructor->id]);
        })->flatten();

        // 4. Create All Subjects
        Subject::factory()->allSubjects();

        // 5. Link Subjects to Curriculums
        $subjectIds = Subject::pluck('id')->toArray();
        $curriculums->each(function ($curriculum) use ($subjectIds) {
            $randomSubjects = collect($subjectIds)
                ->shuffle()
                ->take(rand(5, 8))
                ->toArray();

            foreach ($randomSubjects as $subjectId) {
                CurriculumSubject::firstOrCreate([
                    'curriculum_id' => $curriculum->id,
                    'subject_id' => $subjectId
                ]);
            }
        });

        $curriculums->each(function ($curriculum) use ($specializations) {
            $curriculum->specializations()->attach(
                $specializations->random(rand(1, 2))->pluck('id')->toArray()
            );
        });

        // 6. Create Students
        $students = $curriculums->map(function ($curriculum) {
            return Student::factory()->count(5)->create(['instructor_id' => $curriculum->instructor_id]);
        })->flatten();

        // 7. Create Accounts
        $instructors->each(function ($instructor) {
            Account::factory()->instructor($instructor)->create([
                'username' => strtolower($instructor->first_name . $instructor->id),
                'password' => 'password123',
            ]);
        });

        $admins->each(function ($admin) {
            Account::factory()->admin($admin)->create([
                'username' => strtolower($admin->first_name . $admin->id),
                'password' => 'password123',
            ]);
        });

        $students->each(function ($student) {
            Account::factory()->student($student)->create([
                'username' => strtolower($student->first_name . $student->id),
                'password' => 'password123',
            ]);
        });

        // 8. Create Guardians, Profiles, Addresses
        $students->each(function ($student) {
            Guardian::factory()->create(['student_id' => $student->id]);
            Profile::factory()->create(['student_id' => $student->id]);
            Address::factory()->student()->create([
                'owner_id' => $student->id,
                'owner_type' => Student::class,
                'type' => 'permanent',
            ]);
            Address::factory()->student()->create([
                'owner_id' => $student->id,
                'owner_type' => Student::class,
                'type' => 'current',
            ]);
        });

        $instructors->each(function ($instructor) {
            Address::factory()->instructor()->create([
                'owner_id' => $instructor->id,
                'owner_type' => Instructor::class,
                'type' => 'permanent',
            ]);
            Address::factory()->instructor()->create([
                'owner_id' => $instructor->id,
                'owner_type' => Instructor::class,
                'type' => 'current',
            ]);
        });

        // 9. Create Lessons, Activities, Quizzes, Videos (once per lesson)
        $lessons = Lesson::factory()->count(10)->create();
        $activities = Activity::factory()->count(10)->create();
        $activities->each(function ($activity) use ($specializations) {
            $activity->specializations()->attach(
                $specializations->random(rand(1, 2))->pluck('id')->toArray()
            );
            ActivityImage::factory()->count(7)->create(['activity_id' => $activity->id]);
        });

        $lessons->each(function ($lesson) use($activities) {
            Video::factory()->create(['lesson_id' => $lesson->id]);

            $lessonActivity = ActivityLesson::firstOrCreate([
                'lesson_id' => $lesson->id,
                'activity_id' => $activities->random()->id,
            ]);
            $lesson->setRelation('lessonActivity', $lessonActivity);

            // Create 20 quizzes with questions and options
            $quiz = Quiz::factory()->create([
                'lesson_id' => $lesson->id,
            ]);
            $questions = Question::factory(3)->create(['quiz_id' => $quiz->id]);
            $questions->each(function ($question) {
                Option::factory(4)->create(['question_id' => $question->id]);
            });
        });
        $lessons->each(function ($lesson) use ($curriculums) {
            $curriculum = $curriculums->random();

            $curriculumSubject = $curriculum->curriculumSubjects->random();
            $lesson->curriculum_subject_id = $curriculumSubject->id;
        });

        // 10. Assign lessons to students (pivot) and create logs
        $students->each(function ($student) use ($lessons) {
            $lessons->each(function ($lesson) use ($student) {
                // Pivot
                LessonSubjectStudent::firstOrCreate([
                    'curriculum_subject_id' => $lesson->curriculum_subject_id,
                    'lesson_id' => $lesson->id,
                    'student_id' => $student->id,
                ]);

                // Create logs for lesson's quiz and activity
                $quiz = $lesson->quiz;
                if ($quiz) {
                    Log::factory()->create([
                        'student_id' => $student->id,
                        'loggable_id' => $quiz->id,
                        'loggable_type' => Quiz::class,
                    ]);
                }

                Log::factory()->create([
                    'student_id' => $student->id,
                    'loggable_id' => $lesson->lessonActivity->id,
                    'loggable_type' => ActivityLesson::class,
                ]);
            });
        });


        // 11. Create Feeds
        $students->each(function ($student) {
            Feed::factory()->create(['notifiable_id' => $student->id, 'group' => 'student']);
        });

        Feed::factory()->count(30)->create();
    }
}
