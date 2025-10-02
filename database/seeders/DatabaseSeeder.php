<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;
use App\Models\Log;
use App\Models\Feed;
use App\Models\Todo;
use App\Models\Admin;
use App\Models\Award;
use App\Models\Video;
use App\Models\Domain;
use App\Models\Lesson;
use App\Models\Account;
use App\Models\Address;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Activity;
use App\Models\Guardian;
use App\Models\GameImage;
use App\Models\SubDomain;
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
        // === Domains ===
        $domains = [
            'Daily Living Skills Domain' => [
                'subdomains' => [
                    'Self-feeding' => [
                        "Expresses need to eat or drink through non-verbal or verbal means.",
                        "Chews and swallows different kinds of foods.",
                        "Swallows liquid like soup.",
                        "Picks up food with fingers or scoops with spoon.",
                        "Uses spoon and fork.",
                        "Drinks from a cup or glass.",
                        "Feeds self independently.",
                    ],
                    'Toilet' => [
                        "Urinates and defecates in proper places.",
                        "Demonstrates control of bowel and bladder.",
                        "Goes to the toilet independently.",
                        "Uses toilet paper or other available materials.",
                        "Washes hands after using the toilet.",
                    ],
                    'Dressing' => [
                        "Puts on simple clothes.",
                        "Removes clothes without assistance.",
                        "Fastens and unfastens buttons, zippers, snaps, ties.",
                        "Selects appropriate clothes for the occasion/weather.",
                        "Takes care of clothes and shoes properly.",
                    ],
                    'Grooming and Hygiene' => [
                        "Brushes teeth properly.",
                        "Washes and dries hands.",
                        "Combs or brushes hair.",
                        "Bathes with assistance.",
                        "Bathes independently.",
                        "Keeps body clean and neat.",
                    ],
                ]
            ],

            'Socio-Emotional Domain' => [
                'todos' => [
                    "Uses courteous expression appropriately.",
                    "Asks an apology when necessary.",
                    "Shows respect to elders.",
                    "Greets peers and adults.",
                    "Expresses needs and feelings appropriately.",
                    "Shows concern to others.",
                    "Waits for his/her turn.",
                    "Accepts mistakes and limitations.",
                    "Accepts responsibility as a member of the family/cultural group.",
                    "Displays positive and appropriate emotions.",
                ]
            ]
        ];

        foreach ($domains as $domainName => $data) {
            $domain = Domain::create(['name' => $domainName]);

            // If domain has subdomains
            if (isset($data['subdomains'])) {
                foreach ($data['subdomains'] as $subdomainName => $todos) {
                    $subdomain = SubDomain::create([
                        'name' => $subdomainName,
                        'domain_id' => $domain->id,
                    ]);

                    foreach ($todos as $todo) {
                        Todo::create([
                            'todo' => $todo,
                            'sub_domain_id' => $subdomain->id,
                        ]);
                    }
                }
            }

            // If domain has direct todos
            if (isset($data['todos'])) {
                foreach ($data['todos'] as $todo) {
                    Todo::create([
                        'todo' => $todo,
                        'domain_id' => $domain->id,
                    ]);
                }
            }
        }

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
            ['name' => 'Subject Specialist', 'description' => 'Earned by completing every activity within a single subject (demonstrates mastery).'],
            ['name' => 'Game Master', 'description' => 'Awarded to students who finish all game-based activities (from GameActivity).'],
            ['name' => 'Early Bird', 'description' => 'Given to the student who consistently finishes activities before others.'],
            ['name' => 'Consistency Award', 'description' => 'Recognizes students who complete activities week after week without missing any.'],
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
            $gradeLevelIds = $instructor->gradeLevels->pluck('id')->toArray();

            return Curriculum::factory()->count(12)->make()->map(function ($curriculum) use ($instructor, $gradeLevelIds) {
                $curriculum->instructor_id = $instructor->id;
                $curriculum->grade_level_id = $gradeLevelIds[array_rand($gradeLevelIds)];
                $curriculum->save();

                return $curriculum;
            });
        })->flatten();


        Subject::factory()->allSubjects();
        // ========== To be changed ==========
        Subject::all()->each(function ($subject) {
            $randomDomains = Domain::inRandomOrder()->take(rand(1, 2))->pluck('id');
            $subject->domains()->attach($randomDomains);
        });

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

        $students->each(function ($student) use ($instructors) {
            $instructor = $instructors->random();
            $gradeLevelId = $instructor->gradeLevels->random()->id;

            Account::factory()->student($student)->create([
                'username' => strtolower($student->first_name . $student->id),
                'password' => 'password123',
            ]);
            Guardian::factory()->create(['student_id' => $student->id]);
            Enrollment::factory()->create([
                'instructor_id' => $instructor->id,
                'student_id'    => $student->id,
                'grade_level_id' => $gradeLevelId,
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

        // === Activities ===
        $activities = collect(range(1, 30))->map(function () use ($specializations) {
            // Pick subject(s) first
            $subjects = Subject::inRandomOrder()->take(rand(1, 2))->get();

            // Pick a todo from one of the subjects’ domains
            $subject = $subjects->random();
            $domain = $subject->domains()->inRandomOrder()->first();

            $todo = null;
            if ($domain) {
                $todo = $domain->todos()->inRandomOrder()->first();

                if (!$todo) {
                    $subDomain = $domain->subDomains()->with('todos')->inRandomOrder()->first();
                    if ($subDomain) {
                        $todo = $subDomain->todos()->inRandomOrder()->first();
                    }
                }
            }

            // ✅ ensure todo exists, otherwise skip
            if (!$todo) {
                return null; // or throw exception if you want to enforce
            }

            // Create activity with todo_id immediately
            $activity = GameActivity::factory()->create([
                'todo_id' => $todo->id,
            ]);

            // Attach specializations
            $activity->specializations()->attach(
                $specializations->random(rand(1, 2))->pluck('id')->toArray()
            );

            // Create images
            GameImage::factory()->count(7)->create(['game_activity_id' => $activity->id]);

            // Attach subjects
            $activity->subjects()->attach($subjects->pluck('id'));

            return $activity;
        });


        // === Assign lessons per instructor (unique) ===
        $instructors->each(function ($instructor) use ($activities, $curriculums) {
            $instructorCurriculums = $curriculums->where('instructor_id', $instructor->id);

            $instructorCurriculums->each(function ($curriculum) use ($activities, $instructor) {
                $curriculumSubjects = $curriculum->curriculumSubjects;

                // ✅ Get only students that match grade_level + specialization
                $eligibleStudents = $instructor->eligibleStudents($curriculum)->get();

                // ✅ Create fresh lessons for this instructor/curriculum (not shared globally)
                $curriculumLessons = Lesson::factory()->count(2)->create([
                    'school_year_id' => now()->schoolYear()->id,
                ]);

                $curriculumLessons->each(function ($lesson) use ($activities) {
                    Video::factory()->create(['lesson_id' => $lesson->id]);

                    ActivityLesson::create([
                        'lesson_id' => $lesson->id,
                        'activity_lessonable_id' => $activities->random()->id,
                        'activity_lessonable_type' => GameActivity::class,
                    ]);
                });

                // ✅ Assign these lessons to eligible students
                $eligibleStudents->each(function ($student) use ($curriculumLessons, $curriculumSubjects) {
                    $curriculumLessons->each(function ($lesson) use ($student, $curriculumSubjects) {
                        $curriculumSubject = $curriculumSubjects->random();

                        LessonSubjectStudent::firstOrCreate([
                            'curriculum_subject_id' => $curriculumSubject->id,
                            'lesson_id'             => $lesson->id,
                            'student_id'            => $student->id,
                        ]);

                        if ($lesson->activityLessons->isNotEmpty()) {
                            foreach ($lesson->activityLessons as $activityLesson) {
                                StudentActivity::factory()->create([
                                    'student_id'         => $student->id,
                                    'activity_lesson_id' => $activityLesson->id,
                                ]);
                            }
                        }
                    });
                });
            });
        });



        // === Class Activity ===
        $instructors = Instructor::all();

        foreach ($instructors as $instructor) {
            $curriculumSubjects = CurriculumSubject::whereHas('curriculum', function ($q) use ($instructor) {
                $q->where('instructor_id', $instructor->id);
            })->with('subject.domains.subDomains.todos', 'subject.domains.todos')->get();

            $activities = collect();

            for ($i = 0; $i < 10; $i++) {
                if ($curriculumSubjects->isEmpty()) {
                    continue;
                }

                // 1. Pick random curriculum subject
                $curriculumSubject = $curriculumSubjects->random();
                $subject = $curriculumSubject->subject;

                // 2. Pick a random domain from the subject
                $domain = $subject->domains()->inRandomOrder()->first();

                // 3. Get todo (domain first, else from subdomain)
                $todo = $domain?->todos()->inRandomOrder()->first();
                if (!$todo && $domain) {
                    $subDomain = $domain->subDomains()->with('todos')->inRandomOrder()->first();
                    if ($subDomain) {
                        $todo = $subDomain->todos()->inRandomOrder()->first();
                    }
                }

                // 4. Create Class Activity
                $activity = ClassActivity::factory()->create([
                    'instructor_id'         => $instructor->id,
                    'curriculum_subject_id' => $curriculumSubject->id,
                    'todo_id'               => $todo?->id,
                ]);

                $activities->push($activity);
            }

            // 5. Activity lessons + student assignments
            foreach ($activities as $activity) {
                $activityLesson = ActivityLesson::create([
                    'activity_lessonable_id'   => $activity->id,
                    'activity_lessonable_type' => ClassActivity::class,
                ]);

                // Eligible students for this curriculum
                $eligibleStudents = $instructor->eligibleStudents($activity->curriculumSubject->curriculum)->get();
                $students = $eligibleStudents->shuffle()->take(rand(3, 6));

                foreach ($students as $student) {
                    StudentActivity::factory()->create([
                        'student_id'         => $student->id,
                        'activity_lesson_id' => $activityLesson->id,
                    ]);
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
