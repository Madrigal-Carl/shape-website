<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Log;
use App\Models\Feed;
use App\Models\Admin;
use App\Models\Award;
use App\Models\Video;
use App\Models\Lesson;
use App\Models\Account;
use App\Models\Address;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Activity;
use App\Models\Guardian;
use App\Models\GameImage;
use App\Models\Curriculum;
use App\Models\Enrollment;
use App\Models\Instructor;
use App\Models\GameActivity;
use App\Models\StudentAward;
use App\Models\ActivityImage;
use App\Models\ActivityLesson;
use App\Models\Specialization;
use App\Models\StudentActivity;
use Illuminate\Database\Seeder;
use App\Models\CurriculumSubject;
use App\Models\LessonSubjectStudent;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $awards = [
            ['name' => 'Activity Ace', 'description' => 'Recognizes the student who completes the highest number of activities overall.'],
            ['name' => 'Lesson Finisher', 'description' => 'Awarded for completing all lessons assigned in the course.'],
            ['name' => 'Resilient Learner', 'description' => 'Granted to a student who keeps trying until success, completing an activity after multiple failed attempts.'],
            ['name' => 'Progress Pioneer', 'description' => 'Awarded the student who shows the greatest improvement across activities.'],
            ['name' => 'Subject Specialist', 'description' => 'Earned by completing every activity within a single subject (demonstrates mastery).'],
            ['name' => 'Speed Learner', 'description' => 'Awarded to the student who complete lessons in the shortest recorded time.'],
        ];

        foreach ($awards as $award) {
            Award::firstOrCreate(
                ['name' => $award['name']],
                ['description' => $award['description']]
            );
        }

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
        $instructorTest = Instructor::factory()->create();
        $instructorTest->specializations()->attach(
            $specializations->random(rand(1, 2))->pluck('id')->toArray()
        );

        // 2. Create Admins
        $admins = Admin::factory()->count(3)->create();
        $adminTest = Admin::factory()->create();

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
        $students = $curriculums->map(function ($curriculum) use ($specializations) {
            return Student::factory()->count(5)->create([
                'instructor_id' => $curriculum->instructor_id,
            ]);
        })->flatten();

        // 7. Create Accounts
        Account::factory()->instructor($instructorTest)->create([
            'username' => 'instructor',
            'password' => 'instructor',
        ]);
        Account::factory()->admin($adminTest)->create([
            'username' => 'admin',
            'password' => 'admin',
        ]);

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
            Enrollment::factory()->create(['student_id' => $student->id]);
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

        $allAwards = Award::all();
        $students->each(function ($student) use ($allAwards) {
            // Give each student 0 to 3 random awards
            $randomAwards = $allAwards->random(rand(0, 3));

            foreach ($randomAwards as $award) {
                StudentAward::firstOrCreate([
                    'student_id' => $student->id,
                    'award_id'   => $award->id,
                ]);
            }
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

        // 9. Create Lessons, Activities, Videos (once per lesson)
        $lessons = Lesson::factory()->count(10)->create();
        $activities = GameActivity::factory()->count(30)->create();
        $activities->each(function ($activity) use ($specializations) {
            $activity->specializations()->attach(
                $specializations->random(rand(1, 2))->pluck('id')->toArray()
            );
            GameImage::factory()->count(7)->create(['game_activity_id' => $activity->id]);
            $randomSubjects = Subject::inRandomOrder()->take(rand(1, 2))->pluck('id');
            $activity->subjects()->attach($randomSubjects);
        });

        $lessons->each(function ($lesson) use ($activities) {
            Video::factory()->create(['lesson_id' => $lesson->id]);

            $lessonActivity = ActivityLesson::firstOrCreate([
                'lesson_id' => $lesson->id,
                'activity_lessonable_id' => $activities->random()->id,
                'activity_lessonable_type' => GameActivity::class,
            ]);
            $lesson->setRelation('lessonActivity', $lessonActivity);
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

                // Activity
                if ($lesson->lessonActivity) {
                    $studentActivity = StudentActivity::firstOrCreate([
                        'student_id'          => $student->id,
                        'activity_lesson_id'  => $lesson->lessonActivity->id,
                    ]);

                    Log::factory()->create([
                        'student_activity_id'   => $studentActivity->id,
                    ]);
                }
            });
        });


        // 11. Create Feeds
        $students->each(function ($student) {
            Feed::factory()->create(['notifiable_id' => $student->id, 'group' => 'student']);
        });

        Feed::factory()->count(30)->create();
    }
}
