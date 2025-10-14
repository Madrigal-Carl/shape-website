<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;
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
use App\Models\ClassActivity;
use App\Models\Specialization;
use App\Models\StudentActivity;
use Illuminate\Database\Seeder;
use App\Models\CurriculumSubject;
use App\Models\GameActivityLesson;
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
                    'Self-Feeding' => [
                        "Expresses need to eat or drink through non-verbal or verbal means.",
                        "Chews and swallows different kinds of foods.",
                        "Swallows liquid like soup.",
                        "Picks up food with fingers or scoops with spoon.",
                        "Picks up and eats finger foods.",
                        "Sips and drinks liquid.",
                        "Eats with spoon and fork.",
                        "Uses the table knife for spreading.",
                        "Cuts food using table knife.",
                        "Distinguishes edible and non-edible foods and substances.",
                        "Peels/unwraps food.",
                        "Uses table napkins.",
                        "Exhibits table setting skills.",
                    ],
                    'Toileting' => [
                        "Uses comfort room/toilet bowl to urinate or defecate.",
                        "Uses the toilet paper to clean-up self and dispossess it properly.",
                        "Uses diaper correctly.",
                        "Cleans self with soap and water after toileting.",
                    ],
                    'Dressing' => [
                        "Removes/puts on shoes or slippers.",
                        "Removes/puts on socks.",
                        "Removes/puts on clothes.",
                        "Opens and closes dressing implements (zip/unzip, button/unbutton).",
                    ],
                    'Grooming and Hygiene' => [
                        "Washes and dries hands properly.",
                        "Cleans own self.",
                        "Brushes teeth.",
                        "Combs/brushes hair.",
                    ],
                ]
            ],

            'Socio-Emotional Domain' => [
                'todos' => [
                    "Uses courteous expressions appropriately.",
                    "Asks an apology when necessary.",
                    "Pays attention to someone talking.",
                    "Engages in communication to others.",
                    "Plays with peers.",
                    "Makes friends easily.",
                    "Follows rules and regulations.",
                    "Seeks/accepts help.",
                    "Expresses/shows appropriate emotions.",
                    "Waits for one's turn.",
                    "Asks permission to use things owned by others.",
                    "Seeks help from older friends.",
                    "Imitates adult activities.",
                    "Displays sense of humor.",
                    "Identifies self as a member of the family/cultural group.",
                    "Identifies personal belongings.",
                    "Displays sensitivity to the feelings of others.",
                    "Shows sportsmanship.",
                    "Shows interest in work or tasks.",
                    "Works independently.",
                    "Shows self-confidence.",
                ]
            ],

            'Language Development Domain' => [
                'subdomains' => [
                    'Listening' => [
                        "Follows simple directions.",
                        "Distinguishes different types of sounds.",
                        "Comprehends similar and familiar stories.",
                        "Listens attentively to stories, poems/rhymes.",
                    ],
                    'Speaking' => [
                        "Increases vocabulary to describe things.",
                        "Increases vocabulary to express one's feelings.",
                        "Increases vocabulary to share information.",
                        "Answers and responds to questions accordingly.",
                        "Narrates simple and familiar stories.",
                    ],
                    'Reading' => [
                        "Discriminates similarities and differences between pictures and objects.",
                        "Classifies objects according to function.",
                        "Notes details on pictures.",
                        "Visualizes objects and pictures from memory.",
                        "Comprehends picture stories.",
                        "Performs relevant study skills.",
                    ],
                    'Writing' => [
                        "Holds/grips pencil properly.",
                        "Traces lines and shapes.",
                        "Traces letters, numbers, and one's name properly.",
                        "Copies lines, shapes, letters, numbers, and one's name properly.",
                        "Draws basic figures.",
                        "Uses basic strokes correctly.",
                    ],
                ]
            ],

            'Fine Motor Competencies Domain' => [
                'subdomains' => [
                    'Basic Movement' => [
                        "Sits, stands, and walks with good posture.",
                        "Runs and jumps gradually in increasing distance.",
                        "Jumps and performs other exercises with or without music.",
                        "Lifts increasingly heavy weights.",
                        "Balances on one foot for gradually increasing period.",
                        "Imitates motor movement of people and animals.",
                        "Bends and strengthens knees properly while knees flat on the floor.",
                        "Goes up and down the stairs.",
                    ],
                    'Fine Motor Competencies' => [
                        "Makes an object using clay.",
                        "Squeezes soft rubber ball of convenient sizes.",
                        "Squeezes water from wet rag.",
                        "Folds, divides, and tears paper into halves/pieces.",
                        "Cuts out shapes, outline and objects.",
                        "Pastes paper properly.",
                        "Strings and threads beads.",
                        "Turns doorknob with forearm motion..",
                        "Removes bottle cap.",
                    ],
                ]
            ],

            'Perceptual Motor Skills Domain' => [
                'subdomains' => [
                    'Perceptual Motor Skills' => [
                        "Uses clay to make simple but increasingly meaningful shapes and objects.",
                        "Uses crayon to color.",
                    ],
                ]
            ],

            'Gross Motor Competencies Domain' => [
                'subdomains' => [
                    'Gross Motor Competencies' => [
                        "Walks while carrying an object.",
                        "Jumps towards without falling.",
                        "Throws and catches objects.",
                        "Kicks ball without losing balance.",
                        "Hops skillfully without falling.",
                    ],
                ]
            ],

            'Cognitive Domain' => [
                'todos' => [
                    "Identifies colors.",
                    "Identifies shapes.",
                    "Identifies letters of the alphabet.",
                    "Identifies the sounds of the letters of the alphabet.",
                    "Identifies sizes; long-short, big-small, tall-short.",
                    "Sorts objects according to color.",
                    "Sorts objects according to size.",
                    "Sorts objects according to shape.",
                    "Tells the size of the object.",
                    "Identifies numbers up to 5.",
                    "Counts numbers up to 20.",
                ]
            ],

            'Language/Communication Development' => [
                'todos' => [
                    "Says/Signs/Writes about oneself",
                    "Says/Signs and speechreads one’s name",
                    "Associates one’s name with printed symbols",
                    "Says/Signs and speechreads one’s grade",
                    "Says/Signs and speechreads one’s address",
                    "Uses expressions of social amenities in appropriate situations",
                    "Identifies correctly letters/words commonly interchanged",
                    "Names and speechreads one’s brother’s/sister’s name",
                    "Arranges big/small letters of the alphabet sequentially",
                    "Names places in school",
                    "Answers “where” questions",
                    "Answers “who” questions",
                    "Talks about school materials",
                    "Names objects using a, an",
                    "Uses in, on, under with names of objects",
                    "Uses this is and these are correctly",
                    "Talks about farm animals",
                    "Recognizes beginning and ending of words",
                    "Tells the number of syllables of words read",
                    "Talks about the days of the week",
                    "Follows simple directions",
                ]
            ],

            'Reading Skills' => [
                'todos' => [
                    "Recognizes his name in print",
                    "Identifies the letters of the alphabet",
                    "Fingerspells the letters of the alphabet",
                    "Writes the letters of the alphabet with correct form",
                    "Fingerspells one’s name and family members’ names",
                    "Writes one’s name and names of family members",
                    "Signs one’s name and names of family members and friends",
                ]
            ],

            'Writing Skills' => [
                'todos' => [
                    "Grips pencil properly while writing",
                    "Executes fundamental strokes",
                    "Shows mastery of letter forms",
                    "Writes name accurately",
                    "Copies simple words correctly",
                    "Copies evenly following lines",
                ]
            ],

            'Numerical Skills' => [
                'todos' => [
                    "Sets and numerals",
                    "Place value of whole numbers",
                    "Ordering & constructing sets from least to greatest (and vice versa)",
                    "Ordinal numbers",
                    "Odd and even numbers",
                    "Roman numerals",
                    "Rounding numbers to the nearest tens, hundreds, and thousands",
                    "Skip counting",
                    "Addition of two–three digit numbers",
                    "Addition of two-digit numbers with regrouping",
                    "Addition of three-digit numbers with regrouping",
                    "Subtraction of whole numbers",
                    "Subtraction of two-digit numbers with regrouping",
                    "Subtraction of three-digit numbers with regrouping",
                    "Subtraction with zero number",
                    "Multiplication of whole numbers",
                    "Multiplying by 6",
                    "Multiplying by 7",
                    "Multiplying by 8",
                    "Multiplying by 9",
                    "Multiplying two–three digit numbers by one-digit number",
                    "Multiplying two-digit numbers by one-digit number with regrouping",
                    "Multiplying three-digit numbers by one-digit number with regrouping",
                    "Multiplying three-digit numbers by two-digit number with regrouping",
                ]
            ],

            'Motor Development' => [
                'subdomains' => [
                    'Gross Motor Skills' => [
                        "Jumps over an object with both feet",
                        "Walks forward independently",
                        "Climbs upstairs and goes downstairs using alternate feet",
                        "Skips well with or without rope",
                        "Handles balls and blocks with ease",
                        "Throws and catches ball properly",
                        "Balances well within a given path",
                        "Hops well",
                        "Kicks while standing",
                    ],
                    'Fine Motor Skills' => [
                        "Builds tower (2nd stage of block building)",
                        "Strings beads on thread or shoelace",
                        "Performs twisting activities efficiently",
                        "Folds paper or napkins with ease",
                        "Cuts straight lines",
                        "Cuts curved lines",
                        "Cuts jagged lines",
                        "Cuts round picture",
                        "Rolls up mats, paper, or similar materials",
                        "Rolls balls",
                        "Holds pencils, crayons, and paintbrush properly",
                        "Uses three-finger grasp",
                        "Puts small objects in a bottle",
                        "Handles pegs on board properly",
                    ],
                ]
            ],

            'Social and Emotional Development' => [
                'todos' => [
                    "Plays at ease with others",
                    "Shares with others",
                    "Responds positively",
                    "Exhibits self-confidence",
                    "Welcomes responsibility",
                    "Shows a happy disposition",
                    "Copes well with varying situations",
                    "Initiates interaction (through eye contact, touching, and calling)",
                    "Responds to his name when called",
                    "Stops crying with verbal attention",
                    "Shows affection to adults",
                    "Interacts with strangers appropriately",
                    "Explores his environment",
                    "Plays appropriately with toys and packs them away",
                    "Plays alone near peers",
                    "Initiates play with peers",
                    "Interacts with peers",
                    "Identifies personal belongings",
                    "Cares for his own belongings",
                    "Accepts routines and adjusts to changes",
                    "Knows how to listen",
                    "Knows how to follow adult direction",
                    "Greets visitors and familiar personalities",
                    "Behaves appropriately in various social settings",
                    "Knows how to say “Please”",
                    "Knows how to say “Excuse Me”",
                    "Knows how to say “Thank You”",
                    "Knows how to say “You’re Welcome”",
                    "Knows how to say “Po and Opo”",
                ]
            ],

            'Self Help Skills' => [
                'subdomains' => [
                    'Feeding' => [
                        "Drinks from a cup/glass",
                        "Drinks with a straw",
                        "Pours liquid from a container",
                        "Uses eating utensils (spoon, knife, fork) properly",
                        "Serves self from serving plate",
                        "Cleans spillage",
                        "Eats independently",
                    ],
                    'Toileting' => [
                        "Sounds off when or soiled",
                        "Uses toilet without help",
                        "Follows complete toileting steps (wiping, flushing, washing hands)",
                    ],
                    'Hygiene and Grooming' => [
                        "Washes hands with soap",
                        "Washes face with soap",
                        "Dries hands/face independently",
                        "Combs/brushes hair properly",
                        "Brushes teeth regularly",
                        "Blows nose on command",
                        "Keeps nose clean with hanky or tissue",
                        "Takes care of personal needs",
                    ],
                    'Safety' => [
                        "Handles sharp objects with care",
                        "Recognizes safety rules",
                    ],
                ]
            ],
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
            ['name' => 'Activity Ace', 'description' => 'Recognizes the student who completes the highest number of activities overall.', 'path' => 'award-icons/activity-ace.png'],
            ['name' => 'Lesson Finisher', 'description' => 'Awarded for completing all lessons assigned in the course.', 'path' => 'award-icons/lesson-finisher.png'],
            ['name' => 'Subject Specialist', 'description' => 'Earned by completing every activity within a single subject (demonstrates mastery).', 'path' => 'award-icons/subject-specialist.png'],
            ['name' => 'Game Master', 'description' => 'Awarded to students who finish all game-based activities (from GameActivity).', 'path' => 'award-icons/game-master.png'],
            ['name' => 'Early Bird', 'description' => 'Given to the student who consistently finishes activities before others.', 'path' => 'award-icons/early-bird.png'],
            ['name' => 'Consistency Award', 'description' => 'Recognizes students who complete activities week after week without missing any.', 'path' => 'award-icons/consistency-award.png'],
        ];

        foreach ($awards as $award) {
            Award::firstOrCreate(
                ['name' => $award['name']],
                ['description' => $award['description'], 'path' => $award['path']]
            );
        }

        // === Specializations ===
        $specializations = collect([
            Specialization::firstOrCreate(['name' => 'autism spectrum disorder'], ['icon' => 'autism-icon.png']),
            Specialization::firstOrCreate(['name' => 'speech disorder'], ['icon' => 'speech-icon.png']),
            Specialization::firstOrCreate(['name' => 'hearing impaired'], ['icon' => 'hearing-icon.png']),
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
                $specializations->random()->pluck('id')->toArray()
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
        // Define the mapping of domains to subjects
        $domainSubjects = [
            'Language/Communication Development' => ['filipino', 'english', 'filipino sign language'],
            'Reading Skills' => ['filipino', 'english', 'filipino sign language'],
            'Writing Skills' => ['filipino', 'english'],
            'Numerical Skills' => ['mathematics'],
            'Motor Development' => ['mapeh', 'filipino sign language'],
            'Social and Emotional Development' => ['araling panlipunan', 'filipino'],
            'Self Help Skills' => ['science', 'araling panlipunan', 'filipino', 'mapeh'],
            'Daily Living Skills Domain' => ['self care', 'daily living skills', 'practical life skills'],
            'Socio-Emotional Domain' => ['edukasyon sa pagpapakatao'],
            'Language Development Domain' => ['english', 'language and literacy'],
            'Perceptual Motor Skills Domain' => ['sensory', 'health and pe'],
            'Gross Motor Competencies Domain' => ['health and pe'],
            'Fine Motor Competencies Domain' => ['practical life skills', 'health and pe', 'music and arts'],
            'Cognitive Domain' => ['numeracy', 'science', 'practical life skills'],
        ];


        // Loop through each domain and assign the subjects
        foreach ($domainSubjects as $domainName => $subjects) {
            $domain = Domain::where('name', $domainName)->first();

            if ($domain) {
                foreach ($subjects as $subjectName) {
                    $subject = Subject::whereRaw('LOWER(name) = ?', [strtolower($subjectName)])->first();
                    if ($subject) {
                        $subject->domains()->syncWithoutDetaching([$domain->id]);
                    }
                }
            }
        }

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
            // Pick random subjects (for diversity)
            $subjects = Subject::inRandomOrder()->take(rand(1, 2))->get();

            // ✅ Manually assign a random todo_id between 1 and 102
            $todo = Todo::inRandomOrder()->whereBetween('id', [103, 229])->first();

            // Create the GameActivity
            $activity = GameActivity::factory()->create();

            $activity->todos()->attach($todo->id);

            // Attach related subjects
            $activity->subjects()->attach($subjects->pluck('id'));

            // Attach random specializations (1–2)
            $activity->specializations()->attach(
                $specializations->random(rand(1, 2))->pluck('id')->toArray()
            );

            // Create game images
            GameImage::factory()->count(7)->create([
                'game_activity_id' => $activity->id,
            ]);

            return $activity;
        });




        // === Assign lessons per instructor (unique) ===
        $instructors->each(function ($instructor) use ($activities, $curriculums) {
            $instructorCurriculums = $curriculums->where('instructor_id', $instructor->id);

            $instructorCurriculums->each(function ($curriculum) use ($activities, $instructor) {
                $curriculumSubjects = $curriculum->curriculumSubjects;

                // ✅ Eligible students for this curriculum
                $eligibleStudents = $instructor->eligibleStudents($curriculum)->get();

                // ✅ Create lessons for this instructor/curriculum
                $curriculumLessons = Lesson::factory()->count(2)->create();

                $curriculumLessons->each(function ($lesson) use ($eligibleStudents, $curriculumSubjects) {
                    $curriculumSubject = $curriculumSubjects->random(); // fixed per lesson

                    $eligibleStudents->each(function ($student) use ($lesson, $curriculumSubject) {
                        LessonSubjectStudent::firstOrCreate([
                            'curriculum_subject_id' => $curriculumSubject->id,
                            'lesson_id'             => $lesson->id,
                            'student_id'            => $student->id,
                        ]);
                    });
                });

                $curriculumLessons->each(function ($lesson) use ($activities, $eligibleStudents, $curriculumSubjects) {
                    // Attach video
                    Video::factory()->create(['lesson_id' => $lesson->id]);

                    // Filter activities whose Todo belongs to subjects in this curriculum
                    $subjectIds = $curriculumSubjects->pluck('subject_id');
                    $eligibleGameActivities = $activities->filter(function ($activity) use ($subjectIds) {
                        $activitySubjectIds = $activity->subjects->pluck('id');
                        return $activitySubjectIds->intersect($subjectIds)->isNotEmpty();
                    });

                    // Pick a random eligible activity (if any)
                    $gameActivity = $eligibleGameActivities->isNotEmpty()
                        ? $eligibleGameActivities->random()
                        : null;

                    if ($gameActivity) {
                        $gameActivityLesson = GameActivityLesson::create([
                            'lesson_id'        => $lesson->id,
                            'game_activity_id' => $gameActivity->id,
                        ]);

                        // Assign students only if there’s a matching activity
                        $eligibleStudents->each(function ($student) use ($lesson, $curriculumSubjects, $gameActivityLesson) {
                            $curriculumSubject = $curriculumSubjects->random();

                            LessonSubjectStudent::firstOrCreate([
                                'curriculum_subject_id' => $curriculumSubject->id,
                                'lesson_id'             => $lesson->id,
                                'student_id'            => $student->id,
                            ]);

                            StudentActivity::factory()->create([
                                'student_id'           => $student->id,
                                'activity_lesson_id'   => $gameActivityLesson->id,
                                'activity_lesson_type' => GameActivityLesson::class,
                            ]);
                        });
                    }
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

                // Pick a random CurriculumSubject
                $curriculumSubject = $curriculumSubjects->random();

                // 2️⃣ Get the related Subject
                $subject = $curriculumSubject->subject;
                if (!$subject) {
                    continue; // skip if no subject
                }

                // Get a random domain from that subject
                $domain = $subject->domains()->inRandomOrder()->first();
                if (!$domain) {
                    continue; // skip if no domain exists for subject
                }

                // Get todo — first from domain, fallback to subdomain
                $todo = $domain->todos()->inRandomOrder()->first();

                if (!$todo) {
                    $subDomain = $domain->subDomains()->with('todos')->inRandomOrder()->first();
                    if ($subDomain) {
                        $todo = $subDomain->todos()->inRandomOrder()->first();
                    }
                }

                // If still no todo, skip
                if (!$todo) {
                    continue;
                }

                // 6️⃣ Create ClassActivity now that we have a todo
                $activity = ClassActivity::factory()->create([
                    'instructor_id'         => $instructor->id,
                    'curriculum_subject_id' => $curriculumSubject->id,
                    'lesson_id'             => null, // optional
                ]);

                $activity->todos()->attach($todo->id);

                $activities->push($activity);
            }

            // 7️⃣ Assign created activities to random students
            foreach ($activities as $activity) {
                $eligibleStudents = $instructor->eligibleStudents($activity->curriculumSubject->curriculum)->get();
                $students = $eligibleStudents->shuffle()->take(rand(3, 6));

                foreach ($students as $student) {
                    StudentActivity::factory()->create([
                        'student_id'           => $student->id,
                        'activity_lesson_id'   => $activity->id,
                        'activity_lesson_type' => ClassActivity::class,
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
