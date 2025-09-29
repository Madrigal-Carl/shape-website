<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;
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
use App\Models\GradeLevel;
use App\Models\Instructor;
use App\Models\SchoolYear;
use App\Models\GameActivity;
use App\Models\StudentAward;
use App\Models\ActivityImage;
use App\Models\ClassActivity;
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
        // === School Year ===
        $first_quarter_start = Carbon::now()->startOfDay();
        $first_quarter_end   = $first_quarter_start->copy()->addDays(6);

        $second_quarter_start = $first_quarter_end->copy()->addDay();
        $second_quarter_end   = $second_quarter_start->copy()->addDays(6);

        $third_quarter_start  = $second_quarter_end->copy()->addDay();
        $third_quarter_end    = $third_quarter_start->copy()->addDays(6);

        $fourth_quarter_start = $third_quarter_end->copy()->addDay();
        $fourth_quarter_end   = $fourth_quarter_start->copy()->addDays(6);

        SchoolYear::create([
            'name' => $first_quarter_start->format('Y') . "-" . $fourth_quarter_end->format('Y'),
            'first_quarter_start'  => $first_quarter_start,
            'first_quarter_end'    => $first_quarter_end,
            'second_quarter_start' => $second_quarter_start,
            'second_quarter_end'   => $second_quarter_end,
            'third_quarter_start'  => $third_quarter_start,
            'third_quarter_end'    => $third_quarter_end,
            'fourth_quarter_start' => $fourth_quarter_start,
            'fourth_quarter_end'   => $fourth_quarter_end,
        ]);

        // === Grade Levels ===
        $levels = [
            'Kindergarten 1',
            'Kindergarten 2',
            'Kindergarten 3',
            'Grade 1',
            'Grade 2',
            'Grade 3',
            'Grade 4',
            'Grade 5',
            'Grade 6',
        ];

        foreach ($levels as $level) {
            GradeLevel::firstOrCreate(['name' => $level]);
        }

        // === Awards ===
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

        // === Specializations ===
        $specializations = collect([
            Specialization::firstOrCreate(['name' => 'autism spectrum disorder'], ['icon' => 'autism-icon.png']),
            Specialization::firstOrCreate(['name' => 'speech disorder'], ['icon' => 'speech-icon.png']),
            Specialization::firstOrCreate(['name' => 'hearing impairment'], ['icon' => 'hearing-icon.png']),
        ]);

        // === Admin (only 1) ===
        $admin = Admin::factory()->create();
        Account::factory()->admin($admin)->create([
            'username' => 'admin',
            'password' => 'admin',
        ]);

        // === Instructors (3 total, including test account) ===
        $instructorTest = Instructor::factory()->create();

        Account::factory()->instructor($instructorTest)->create([
            'username' => 'instructor',
            'password' => 'instructor',
        ]);
        Address::factory()->instructor()->create([
            'owner_id' => $instructorTest->id,
            'owner_type' => Instructor::class,
            'type' => 'permanent',
        ]);
        Address::factory()->instructor()->create([
            'owner_id' => $instructorTest->id,
            'owner_type' => Instructor::class,
            'type' => 'current',
        ]);

        $instructors = Instructor::factory()->count(2)->create();
        $instructors->push($instructorTest);

        $instructors->each(function ($instructor) use ($specializations, $instructorTest) {
            $instructor->specializations()->attach(
                $specializations->random(rand(1, 2))->pluck('id')->toArray()
            );
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

            $gradeLevels = GradeLevel::inRandomOrder()->take(rand(1, 3))->pluck('id');
            $instructor->gradeLevels()->attach($gradeLevels);

            // Extra instructor accounts
            if ($instructor->id !== $instructorTest->id) {
                Account::factory()->instructor($instructor)->create([
                    'username' => strtolower($instructor->first_name . $instructor->id),
                    'password' => 'password123',
                ]);
            }
        });

        // === Curriculums for each instructor ===
        $curriculums = $instructors->map(function ($instructor) {
            return Curriculum::factory()->count(12)->create([
                'instructor_id'   => $instructor->id,
                'grade_level_id'  => $instructor->gradeLevels()->inRandomOrder()->first()->id,
            ]);
        })->flatten();

        Subject::factory()->allSubjects();
        $subjectIds = Subject::pluck('id')->toArray();
        $curriculums->each(function ($curriculum) use ($subjectIds, $specializations) {
            $randomSubjects = collect($subjectIds)->shuffle()->take(rand(5, 8))->toArray();
            foreach ($randomSubjects as $subjectId) {
                CurriculumSubject::firstOrCreate([
                    'curriculum_id' => $curriculum->id,
                    'subject_id' => $subjectId
                ]);
            }
            $curriculum->specializations()->attach(
                $specializations->random(rand(1, 2))->pluck('id')->toArray()
            );
        });

        // === Students (20 per instructor) ===
        $instructors = Instructor::take(3)->get();
        $students = collect();

        foreach ($instructors as $instructor) {
            $students = $students->merge(
                Student::factory()->count(20)->create()
            );
        }

        $students->each(function ($student) {
            Account::factory()->student($student)->create([
                'username' => strtolower($student->first_name . $student->id),
                'password' => 'password123',
            ]);
            Guardian::factory()->create(['student_id' => $student->id]);
            Enrollment::factory()->create([
                'instructor_id' => Instructor::inRandomOrder()->first()->id,
                'student_id' => $student->id,
                'grade_level_id' => GradeLevel::inRandomOrder()->first()->id,
            ]);
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

        // === Awards for students ===
        $allAwards = Award::all();
        $students->each(function ($student) use ($allAwards) {
            $randomAwards = $allAwards->random(rand(0, 3));
            foreach ($randomAwards as $award) {
                StudentAward::firstOrCreate([
                    'student_id' => $student->id,
                    'award_id'   => $award->id,
                ]);
            }
        });

        // === Lessons, Activities, Videos ===
        $lessons = Lesson::factory()->count(36)->create();
        $activities = GameActivity::factory()->count(30)->create();

        $activities->each(function ($activity) use ($specializations) {
            $activity->specializations()->attach(
                $specializations->random(rand(1, 2))->pluck('id')->toArray()
            );
            GameImage::factory()->count(7)->create(['game_activity_id' => $activity->id]);
            $activity->subjects()->attach(Subject::inRandomOrder()->take(rand(1, 2))->pluck('id'));
        });

        // Assign lessons properly to a curriculum (which belongs to an instructor)
        $lessons->each(function ($lesson) use ($activities, $curriculums) {
            Video::factory()->create(['lesson_id' => $lesson->id]);

            $lessonActivity = ActivityLesson::firstOrCreate([
                'lesson_id' => $lesson->id,
                'activity_lessonable_id' => $activities->random()->id,
                'activity_lessonable_type' => GameActivity::class,
            ]);
            $lesson->setRelation('lessonActivity', $lessonActivity);
        });

        // === Assign lessons to the respective instructor's students ===
        $instructors->each(function ($instructor) use ($lessons, $curriculums) {
            // Get this instructor’s curriculums and subjects
            $instructorCurriculums = $curriculums->where('instructor_id', $instructor->id);

            $instructorCurriculums->each(function ($curriculum) use ($lessons, $instructor) {
                $curriculumSubjects = $curriculum->curriculumSubjects;

                // ✅ Get only the students that match grade_level + specialization
                $eligibleStudents = $instructor->eligibleStudents($curriculum)->get();

                // ✅ Assign 2 lessons per curriculum
                $curriculumLessons = $lessons->random(2);

                $eligibleStudents->each(function ($student) use ($curriculumLessons, $curriculumSubjects) {
                    $curriculumLessons->each(function ($lesson) use ($student, $curriculumSubjects) {
                        $curriculumSubject = $curriculumSubjects->random();

                        LessonSubjectStudent::firstOrCreate([
                            'curriculum_subject_id' => $curriculumSubject->id,
                            'lesson_id'             => $lesson->id,
                            'student_id'            => $student->id,
                        ]);

                        // Assign activity logs too
                        if ($lesson->activityLessons->isNotEmpty()) {
                            foreach ($lesson->activityLessons as $activityLesson) {
                                $studentActivity = StudentActivity::firstOrCreate([
                                    'student_id'         => $student->id,
                                    'activity_lesson_id' => $activityLesson->id,
                                ]);
                                Log::factory()->create(['student_activity_id' => $studentActivity->id]);
                            }
                        }
                    });
                });
            });
        });


        // === Class Activity ===
        $instructors = Instructor::all();

        foreach ($instructors as $instructor) {
            $activities = ClassActivity::factory()
                ->count(10)
                ->create([
                    'instructor_id' => $instructor->id,
                ]);

            foreach ($activities as $activity) {
                $activityLesson = ActivityLesson::create([
                    'activity_lessonable_id'   => $activity->id,
                    'activity_lessonable_type' => ClassActivity::class,
                ]);

                // Apply same filters as in ActivityEditModal
                $eligibleStudents = $instructor->eligibleStudents($activity->curriculumSubject->curriculum)->get();
                $students = $eligibleStudents->shuffle()->take(rand(3, 6));

                foreach ($students as $student) {
                    $studentActivity = StudentActivity::create([
                        'student_id'         => $student->id,
                        'activity_lesson_id' => $activityLesson->id,
                    ]);

                    $attempts = rand(1, 3);

                    for ($i = 1; $i <= $attempts; $i++) {
                        $isLast = $i === $attempts;

                        $studentActivity->logs()->create([
                            'score'              => fake()->numberBetween(60, 100),
                            'time_spent_seconds' => fake()->numberBetween(300, 1800),
                            'attempt_number'     => $i,
                            'status'             => $isLast ? 'completed' : 'in-progress',
                        ]);
                    }
                }
            }
        }



        // === Feeds ===
        $students->each(function ($student) {
            Feed::factory()->create(['notifiable_id' => $student->id, 'group' => 'student']);
        });
        Feed::factory()->count(30)->create();
    }
}
