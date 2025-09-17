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
        $instructorTest->specializations()->attach(
            $specializations->random(rand(1, 2))->pluck('id')->toArray()
        );
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
            return Curriculum::factory()->count(5)->create(['instructor_id' => $instructor->id]);
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
        $students = $instructors->map(function ($instructor) use ($specializations) {
            return Student::factory()->count(20)->create([
                'instructor_id' => $instructor->id,
            ]);
        })->flatten();

        $students->each(function ($student) {
            Account::factory()->student($student)->create([
                'username' => strtolower($student->first_name . $student->id),
                'password' => 'password123',
            ]);
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
        $lessons = Lesson::factory()->count(10)->create();
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
                $eligibleStudents = $instructor->students->filter(function ($student) use ($curriculum) {
                    $studentGradeLevel = $student->enrollments->first()?->grade_level;
                    $studentDisability = $student->disability_type;

                    $curriculumSpecializations = $curriculum->specializations->pluck('name')->toArray();

                    return $studentGradeLevel === $curriculum->grade_level &&
                        in_array($studentDisability, $curriculumSpecializations);
                });

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

        // === Feeds ===
        $students->each(function ($student) {
            Feed::factory()->create(['notifiable_id' => $student->id, 'group' => 'student']);
        });
        Feed::factory()->count(30)->create();
    }
}
