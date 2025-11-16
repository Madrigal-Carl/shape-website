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
        // $first_quarter_start = Carbon::now()->startOfDay();
        // $first_quarter_end   = $first_quarter_start->copy()->addDays(6);

        // $second_quarter_start = $first_quarter_end->copy()->addDay();
        // $second_quarter_end   = $second_quarter_start->copy()->addDays(6);

        // $third_quarter_start  = $second_quarter_end->copy()->addDay();
        // $third_quarter_end    = $third_quarter_start->copy()->addDays(6);

        // $fourth_quarter_start = $third_quarter_end->copy()->addDay();
        // $fourth_quarter_end   = $fourth_quarter_start->copy()->addDays(6);

        // SchoolYear::create([
        //     'name' => $first_quarter_start->format('Y') . "-" . $fourth_quarter_end->format('Y'),
        //     'first_quarter_start'  => $first_quarter_start,
        //     'first_quarter_end'    => $first_quarter_end,
        //     'second_quarter_start' => $second_quarter_start,
        //     'second_quarter_end'   => $second_quarter_end,
        //     'third_quarter_start'  => $third_quarter_start,
        //     'third_quarter_end'    => $third_quarter_end,
        //     'fourth_quarter_start' => $fourth_quarter_start,
        //     'fourth_quarter_end'   => $fourth_quarter_end,
        // ]);

        // === Grade Levels ===
        $levels = [
            'kindergarten 1',
            'kindergarten 2',
            'kindergarten 3',
            'grade 1',
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
        // $instructorTest = Instructor::factory()->create();

        // Account::factory()->instructor($instructorTest)->create([
        //     'username' => 'instructor',
        //     'password' => 'instructor',
        // ]);
        // Address::factory()->instructor()->create([
        //     'owner_id' => $instructorTest->id,
        //     'owner_type' => Instructor::class,
        //     'type' => 'permanent',
        // ]);
        // Address::factory()->instructor()->create([
        //     'owner_id' => $instructorTest->id,
        //     'owner_type' => Instructor::class,
        //     'type' => 'current',
        // ]);

        // $gradeLevels = GradeLevel::inRandomOrder()->take(rand(1, 3))->pluck('id');
        // $instructorTest->gradeLevels()->attach($gradeLevels);

        // $instructorTest->specializations()->attach(
        //     $specializations->random()->pluck('id')->toArray()
        // );


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

        $games = [
            [
                'name' => 'Count Quest',
                'path' => 'images/game-icons/count-quest-icon.png',
                'description' => 'Count Quest is a math-focused learning game designed for students with autism and cognitive disabilities. It helps learners identify numbers up to 5 and later up to 20 through simple activities, visual guides, and interactive counting tasks. The game uses bright visuals and step-by-step exercises to build basic numeracy skills in a fun and supportive way.',
                'todos' => [101, 102],
                'subjects' => [10],
                'specializations' => [1],
                'images' => [
                    'images/game-icons/count-quest-icon.png',
                    'images/game-previews/count-quest/1.png',
                    'images/game-previews/count-quest/2.png',
                    'images/game-previews/count-quest/3.png',
                    'images/game-previews/count-quest/4.png',
                    'images/game-previews/count-quest/5.png',
                ],
            ],
            [
                'name' => 'Finger Addition',
                'path' => 'images/game-icons/finger-addition-icon.png',
                'description' => 'Finger Addition is a math learning game designed for students with speech and hearing disabilities. It guides learners in solving two- and three-digit addition, including addition with regrouping. Using visual counters, finger-based cues, and step-by-step examples, the game makes numeracy easier to understand and encourages accurate computation in a fun, interactive way.',
                'todos' => [145, 146, 147],
                'subjects' => [1, 4],
                'specializations' => [2, 3],
                'images' => [
                    'images/game-icons/finger-addition-icon.png',
                    'images/game-previews/finger-addition/1.png',
                    'images/game-previews/finger-addition/2.png',
                    'images/game-previews/finger-addition/3.png',
                    'images/game-previews/finger-addition/4.png',
                    'images/game-previews/finger-addition/5.png',
                    'images/game-previews/finger-addition/6.png',
                    'images/game-previews/finger-addition/7.png',
                ],
            ],
            [
                'name' => 'Fruit Subtraction',
                'path' => 'images/game-icons/fruit-subtraction-icon.png',
                'description' => 'Fruit Subtraction is a numeracy game designed for learners with cognitive disabilities and autism. Using colorful fruit visuals, the game teaches students to identify numbers up to 5 and up to 20 through simple subtraction and counting activities. Its clear steps and engaging visuals help make early math skills easier and more enjoyable to learn.',
                'todos' => [148, 149, 150, 151],
                'subjects' => [1],
                'specializations' => [2, 3],
                'images' => [
                    'images/game-icons/fruit-subtraction-icon.png',
                    'images/game-previews/fruit-subtraction/1.png',
                    'images/game-previews/fruit-subtraction/2.png',
                    'images/game-previews/fruit-subtraction/3.png',
                    'images/game-previews/fruit-subtraction/4.png',
                    'images/game-previews/fruit-subtraction/5.png',
                ],
            ],
            [
                'name' => 'Objectify',
                'path' => 'images/game-icons/objectify-icon.png',
                'description' => 'Objectify is a science-based learning game designed for students with autism. The game helps learners identify colors and recognize shapes through interactive activities with clear visuals and simple instructions. Its engaging design makes learning basic science concepts fun and accessible.',
                'todos' => [92, 93],
                'subjects' => [2, 8],
                'specializations' => [1],
                'images' => [
                    'images/game-icons/objectify-icon.png',
                    'images/game-previews/objectify/1.png',
                    'images/game-previews/objectify/2.png',
                    'images/game-previews/objectify/3.png',
                    'images/game-previews/objectify/4.png',
                    'images/game-previews/objectify/5.png',
                    'images/game-previews/objectify/6.png',
                ],
            ],
            [
                'name' => 'Fruit Addition',
                'path' => 'images/game-icons/fruit-addition-icon.png',
                'description' => 'Fruit Addition is a numeracy game designed for learners with cognitive disabilities and autism. Using colorful fruit visuals, the game helps students identify numbers up to 5 and up to 20 through simple counting and matching activities. Its clear instructions and engaging design make early number learning fun and accessible.',
                'todos' => [101, 102],
                'subjects' => [10],
                'specializations' => [1],
                'images' => [
                    'images/game-icons/fruit-addition-icon.png',
                    'images/game-previews/fruit-addition/1.png',
                    'images/game-previews/fruit-addition/2.png',
                    'images/game-previews/fruit-addition/3.png',
                    'images/game-previews/fruit-addition/4.png',
                    'images/game-previews/fruit-addition/5.png',
                ],
            ],
            [
                'name' => 'Finger Subtraction',
                'path' => 'images/game-icons/finger-subtraction-icon.png',
                'description' => 'Finger Subtraction is a numeracy game designed for students with speech and hearing disabilities. It helps learners practice subtracting whole numbers, as well as two-digit and three-digit subtraction with regrouping. Through visual finger cues and simple step-by-step activities, the game makes subtraction easier to understand and supports accurate problem-solving in a fun, accessible way.',
                'todos' => [148, 149, 150, 151],
                'subjects' => [1, 4],
                'specializations' => [2, 3],
                'images' => [
                    'images/game-icons/finger-subtraction-icon.png',
                    'images/game-previews/finger-subtraction/1.png',
                    'images/game-previews/finger-subtraction/2.png',
                    'images/game-previews/finger-subtraction/3.png',
                    'images/game-previews/finger-subtraction/4.png',
                    'images/game-previews/finger-subtraction/5.png',
                ],
            ],
            [
                'name' => 'Sign Quest',
                'path' => 'images/game-icons/sign-quest-icon.png',
                'description' => 'Sign Quest is an educational game designed for learners with speech and hearing disabilities. The game helps students finger-spell letters of the alphabet using clear visuals and interactive activities. It makes learning Science, Language, and Literacy skills engaging and accessible.',
                'todos' => [126],
                'subjects' => [2, 4],
                'specializations' => [2, 3],
                'images' => [
                    'images/game-icons/sign-quest-icon.png',
                    'images/game-previews/sign-quest/1.png',
                    'images/game-previews/sign-quest/2.png',
                    'images/game-previews/sign-quest/3.png',
                    'images/game-previews/sign-quest/4.png',
                    'images/game-previews/sign-quest/5.png',
                ],
            ],
            [
                'name' => 'Cast Spell',
                'path' => 'images/game-icons/cast-spell-icon.png',
                'description' => 'Cast Spell is an educational game for learners with speech and hearing disabilities, focusing on Science and Filipino Sign Language (FSL). The game helps students identify letters and commonly confused words, follow simple directions, recognize the alphabet, and finger-spell letters. Using clear visuals and interactive activities, Spell Cast makes learning spelling and sign language engaging and accessible.',
                'todos' => [125, 126],
                'subjects' => [4],
                'specializations' => [2, 3],
                'images' => [
                    'images/game-icons/cast-spell-icon.png',
                    'images/game-previews/cast-a-spell/1.png',
                    'images/game-previews/cast-a-spell/2.png',
                    'images/game-previews/cast-a-spell/3.png',
                    'images/game-previews/cast-a-spell/4.png',
                    'images/game-previews/cast-a-spell/5.png',
                    'images/game-previews/cast-a-spell/6.png',
                ],
            ],
            [
                'name' => 'Number Quest',
                'path' => 'images/game-icons/number-quest-icon.png',
                'description' => 'Number Quest is a math learning game designed for students with speech, hearing, and autism. For speech and hearing learners, it teaches sets and numerals, skip counting, and place value of whole numbers. For autism learners, it helps identify numbers up to 5 and count numbers up to 20. With interactive visuals and simple activities, the game makes numeracy skills engaging and easy to learn.',
                'todos' => [144, 138, 137, 101, 102],
                'subjects' => [1, 10],
                'specializations' => [1, 2, 3],
                'images' => [
                    'images/game-icons/number-quest-icon.png',
                    'images/game-previews/number-quest/1.png',
                    'images/game-previews/number-quest/2.png',
                    'images/game-previews/number-quest/3.png',
                    'images/game-previews/number-quest/4.png',
                    'images/game-previews/number-quest/5.png',
                    'images/game-previews/number-quest/6.png',
                ],
            ],
            [
                'name' => 'Care for yourself',
                'path' => 'images/game-icons/care-for-yourself-icon.png',
                'description' => 'Care for Yourself is a daily living skills game designed for learners with hearing, speech, and autism. The game helps students eat independently, take care of personal needs, brush their teeth, chew and swallow different foods, and express their needs verbally or non-verbally. Through clear instructions and interactive activities, it encourages self-care and healthy daily routines in a fun and engaging way.',
                'todos' => [23, 24, 17, 1, 2],
                'subjects' => [3, 9],
                'specializations' => [1],
                'images' => [
                    'images/game-icons/care-for-yourself-icon.png',
                    'images/game-previews/care-for-yourself/1.png',
                    'images/game-previews/care-for-yourself/2.png',
                    'images/game-previews/care-for-yourself/3.png',
                    'images/game-previews/care-for-yourself/4.png',
                    'images/game-previews/care-for-yourself/5.png',
                ],
            ],
            [
                'name' => 'Sort Safari',
                'path' => 'images/game-icons/sort-safari-icon.png',
                'description' => 'Sort Safari is a science and numeracy game designed for learners with autism. The game helps students sort objects by size and shape and identify the size of objects through interactive and visual activities. Its colorful design and simple instructions make learning classification and measurement fun and engaging.',
                'todos' => [92, 93, 96, 97, 98, 99, 100],
                'subjects' => [2],
                'specializations' => [1],
                'images' => [
                    'images/game-icons/sort-safari-icon.png',
                    'images/game-previews/sort-safari/1.png',
                    'images/game-previews/sort-safari/2.png',
                    'images/game-previews/sort-safari/3.png',
                    'images/game-previews/sort-safari/4.png',
                    'images/game-previews/sort-safari/5.png',
                    'images/game-previews/sort-safari/6.png',
                    'images/game-previews/sort-safari/7.png',
                    'images/game-previews/sort-safari/8.png',
                    'images/game-previews/sort-safari/9.png',
                    'images/game-previews/sort-safari/10.png',
                ],
            ],
            [
                'name' => 'Fairly Multiplication',
                'path' => 'images/game-icons/the-fairly-multiflication.png',
                'description' => 'The Fairly Multiplication is a math learning game designed for students with speech and hearing disabilities. The game helps learners multiply numbers ranging from single-digit to three-digit numbers, including multiplication with regrouping. Using visual cues and step-by-step guidance, the game makes learning multiplication engaging, interactive, and easy to understand.',
                'todos' => [153, 154, 155, 156, 157, 158, 159, 160],
                'subjects' => [1],
                'specializations' => [2, 3],
                'images' => [
                    'images/game-icons/the-fairly-multiflication.png',
                    'images/game-previews/the-fairy-multiflication/1.png',
                    'images/game-previews/the-fairy-multiflication/2.png',
                    'images/game-previews/the-fairy-multiflication/3.png',
                    'images/game-previews/the-fairy-multiflication/4.png',
                ],
            ],
            [
                'name' => 'Animal Trace',
                'path' => 'images/game-icons/animal-trace.png',
                'description' => 'Animal Trace is a language and literacy game designed for learners with autism. The game helps students identify shapes, trace lines and shapes, and practice writing letters, numbers, and their own name. With fun animal-themed visuals and guided tracing activities, Animal Trace makes learning writing skills engaging and accessible.',
                'todos' => [63, 64, 65, 67, 125],
                'subjects' => [8, 11],
                'specializations' => [1],
                'images' => [
                    'images/game-icons/animal-trace.png',
                    'images/game-previews/animal-trace/1.png',
                    'images/game-previews/animal-trace/2.png',
                    'images/game-previews/animal-trace/3.png',
                    'images/game-previews/animal-trace/4.png',
                    'images/game-previews/animal-trace/5.png',
                ],
            ],
            [
                'name' => 'Shape Trace',
                'path' => 'images/game-icons/shape-trace.png',
                'description' => 'Shape Trace is a language and literacy game designed for learners with autism. The game helps students trace lines and shapes and identify different shapes through fun and interactive activities. Its simple instructions and engaging visuals make learning foundational writing and shape recognition skills enjoyable.',
                'todos' => [63, 65, 66, 67],
                'subjects' => [8, 11],
                'specializations' => [1],
                'images' => [
                    'images/game-icons/shape-trace.png',
                    'images/game-previews/shape-trace/1.png',
                    'images/game-previews/shape-trace/2.png',
                    'images/game-previews/shape-trace/3.png',
                    'images/game-previews/shape-trace/4.png',
                    'images/game-previews/shape-trace/5.png',
                ],
            ],
            [
                'name' => 'Count to 100',
                'path' => 'images/game-icons/count-to-100.png',
                'description' => 'Count to 100 is a numeracy game designed for learners with speech, hearing, and autism. For speech and hearing learners, it teaches sets and numerals, skip counting, and place value of whole numbers. For autism learners, it helps identify numbers up to 5 and count numbers up to 20. With interactive visuals and simple activities, the game makes learning numbers fun and accessible.',
                'todos' => [137, 144, 138],
                'subjects' => [1],
                'specializations' => [2, 3],
                'images' => [
                    'images/game-icons/count-to-100.png',
                    'images/game-previews/count-to-100/1.png',
                    'images/game-previews/count-to-100/2.png',
                    'images/game-previews/count-to-100/3.png',
                    'images/game-previews/count-to-100/4.png',
                    'images/game-previews/count-to-100/5.png',
                    'images/game-previews/count-to-100/6.png',
                ],
            ],
            [
                'name' => 'Match Mania',
                'path' => 'images/game-icons/match-mania-icon.png',
                'description' => 'Match Mania is a fun learning game designed for students with autism, focusing on Science and Language Literacy skills. The game helps learners match items to their state of matter (solid, liquid, gas) and match words to animals using clear visuals and easy matching activities. Its simple instructions and colorful design make learning engaging and accessible.',
                'todos' => [56, 57],
                'subjects' => [2, 8],
                'specializations' => [1],
                'images' => [
                    'images/game-icons/match-mania-icon.png',
                    'images/game-previews/match-mania/1.png',
                    'images/game-previews/match-mania/2.png',
                    'images/game-previews/match-mania/3.png',
                    'images/game-previews/match-mania/4.png',
                    'images/game-previews/match-mania/5.png',
                ],
            ],
            [
                'name' => 'Emotion Test',
                'path' => 'images/game-iconsemotion-test.png',
                'description' => 'Emotion Test is a social-emotional learning game designed for learners with autism, speech, and hearing disabilities. The game helps students use courteous expressions appropriately and recognize and express emotions in different situations. Through interactive activities and visual cues, it makes learning social skills engaging and accessible.',
                'todos' => [34],
                'subjects' => [12],
                'specializations' => [1],
                'images' => [
                    'images/game-icons/emotion-test.png',
                    'images/game-previews/emotion-test/1.png',
                    'images/game-previews/emotion-test/2.png',
                    'images/game-previews/emotion-test/3.png',
                    'images/game-previews/emotion-test/4.png',
                    'images/game-previews/emotion-test/5.png',
                    'images/game-previews/emotion-test/6.png',
                ],
            ],
            [
                'name' => 'Tracing Time',
                'path' => 'images/game-icons/tracing-time.png',
                'description' => 'Tracing Time (Name) is a language and literacy game designed for learners with autism. The game helps students trace lines and shapes and practice writing letters, numbers, and their own name correctly. With guided tracing activities and clear visuals, it makes learning writing skills fun and accessible.',
                'todos' => [63, 64, 65, 67, 125],
                'subjects' => [7, 8, 11],
                'specializations' => [1],
                'images' => [
                    'images/game-icons/tracing-time.png',
                    'images/game-previews/trace-time/1.png',
                    'images/game-previews/trace-time/2.png',
                    'images/game-previews/trace-time/3.png',
                    'images/game-previews/trace-time/4.png',
                    'images/game-previews/trace-time/5.png',
                ],
            ],
            [
                'name' => 'Balloon Pop',
                'path' => 'images/game-icons/balloon-pop.png',
                'description' => 'Balloon Pop is an educational game designed to develop English, Language, and Literacy skills. The game helps learners identify letters of the alphabet, visualize objects and pictures from memory, and discriminate similarities and differences between pictures and objects. With colorful visuals and fun popping activities, it makes learning engaging and interactive..',
                'todos' => [59, 56, 125],
                'subjects' => [7],
                'specializations' => [1],
                'images' => [
                    'images/game-icons/balloon-pop.png',
                    'images/game-previews/balloon-pop/1.png',
                    'images/game-previews/balloon-pop/2.png',
                    'images/game-previews/balloon-pop/3.png',
                    'images/game-previews/balloon-pop/4.png',
                    'images/game-previews/balloon-pop/5.png',
                    'images/game-previews/balloon-pop/6.png',
                ],
            ],
        ];

        foreach ($games as $data) {
            // Create the game activity
            $activity = GameActivity::create([
                'name' => $data['name'],
                'path' => $data['path'],
                'description' => $data['description'],
            ]);

            // Attach Todos
            if (!empty($data['todos'])) {
                $activity->todos()->attach($data['todos']);
            }

            // Attach Subjects
            if (!empty($data['subjects'])) {
                $activity->subjects()->attach($data['subjects']);
            }

            // Attach Specializations
            if (!empty($data['specializations'])) {
                $activity->specializations()->attach($data['specializations']);
            }

            // Create Game Images
            foreach ($data['images'] as $imagePath) {
                GameImage::create([
                    'path' => $imagePath,
                    'game_activity_id' => $activity->id,
                ]);
            }
        }

        // // === Curriculums for each instructor ===
        // $curriculums = $instructors->map(function ($instructor) {
        //     $gradeLevelIds = $instructor->gradeLevels->pluck('id')->toArray();

        //     return Curriculum::factory()->count(12)->make()->map(function ($curriculum) use ($instructor, $gradeLevelIds) {
        //         $curriculum->instructor_id = $instructor->id;
        //         $curriculum->grade_level_id = $gradeLevelIds[array_rand($gradeLevelIds)];
        //         $curriculum->save();

        //         return $curriculum;
        //     });
        // })->flatten();



        // $subjectIds = Subject::pluck('id')->toArray();
        // $curriculums->each(function ($curriculum) use ($subjectIds, $specializations) {
        //     $randomSubjects = collect($subjectIds)->shuffle()->take(rand(5, 8))->toArray();
        //     foreach ($randomSubjects as $subjectId) {
        //         CurriculumSubject::firstOrCreate([
        //             'curriculum_id' => $curriculum->id,
        //             'subject_id' => $subjectId
        //         ]);
        //     }
        //     $curriculum->specializations()->attach(
        //         $specializations->random(rand(1, 2))->pluck('id')->toArray()
        //     );
        // });

        // // === Students (20 per instructor) ===
        // $instructors = Instructor::take(3)->get();
        // $students = collect();

        // foreach ($instructors as $instructor) {
        //     $students = $students->merge(
        //         Student::factory()->count(20)->create()
        //     );
        // }

        // $students->each(function ($student) use ($instructors) {
        //     $instructor = $instructors->random();
        //     $gradeLevelId = $instructor->gradeLevels->random()->id;

        //     Account::factory()->student($student)->create([
        //         'username' => strtolower($student->first_name . $student->id),
        //         'password' => 'password123',
        //     ]);
        //     Guardian::factory()->create(['student_id' => $student->id]);
        //     Enrollment::factory()->create([
        //         'instructor_id' => $instructor->id,
        //         'student_id'    => $student->id,
        //         'grade_level_id' => $gradeLevelId,
        //     ]);
        //     Address::factory()->student()->create([
        //         'owner_id' => $student->id,
        //         'owner_type' => Student::class,
        //         'type' => 'permanent',
        //     ]);
        //     Address::factory()->student()->create([
        //         'owner_id' => $student->id,
        //         'owner_type' => Student::class,
        //         'type' => 'current',
        //     ]);
        // });

        // // === Awards for students ===
        // $allAwards = Award::all();
        // $students->each(function ($student) use ($allAwards) {
        //     $randomAwards = $allAwards->random(rand(0, 3));
        //     foreach ($randomAwards as $award) {
        //         StudentAward::firstOrCreate([
        //             'student_id' => $student->id,
        //             'award_id'   => $award->id,
        //         ]);
        //     }
        // });


        // // === Activities ===
        // $activities = collect(range(1, 30))->map(function () use ($specializations) {
        //     // Pick random subjects (for diversity)
        //     $subjects = Subject::inRandomOrder()->take(rand(1, 2))->get();

        //     // ✅ Manually assign a random todo_id between 1 and 102
        //     $todo = Todo::inRandomOrder()->whereBetween('id', [103, 229])->first();

        //     // Create the GameActivity
        //     $activity = GameActivity::factory()->create();

        //     $activity->todos()->attach($todo->id);

        //     // Attach related subjects
        //     $activity->subjects()->attach($subjects->pluck('id'));

        //     // Attach random specializations (1–2)
        //     $activity->specializations()->attach(
        //         $specializations->random(rand(1, 2))->pluck('id')->toArray()
        //     );

        //     // Create game images
        //     GameImage::factory()
        //         ->count(rand(4, 6))
        //         ->create([
        //             'game_activity_id' => $activity->id,
        //         ]);

        //     return $activity;
        // });




        // // === Assign lessons per instructor (unique) ===
        // $instructors->each(function ($instructor) use ($activities, $curriculums) {
        //     $instructorCurriculums = $curriculums->where('instructor_id', $instructor->id);

        //     $instructorCurriculums->each(function ($curriculum) use ($activities, $instructor) {
        //         $curriculumSubjects = $curriculum->curriculumSubjects;

        //         // ✅ Eligible students for this curriculum
        //         $eligibleStudents = $instructor->eligibleStudents($curriculum)->get();

        //         // ✅ Create lessons for this instructor/curriculum
        //         $curriculumLessons = Lesson::factory()->count(2)->create();

        //         $curriculumLessons->each(function ($lesson) use ($eligibleStudents, $curriculumSubjects) {
        //             $curriculumSubject = $curriculumSubjects->random(); // fixed per lesson

        //             $eligibleStudents->each(function ($student) use ($lesson, $curriculumSubject) {
        //                 LessonSubjectStudent::firstOrCreate([
        //                     'curriculum_subject_id' => $curriculumSubject->id,
        //                     'lesson_id'             => $lesson->id,
        //                     'student_id'            => $student->id,
        //                 ]);
        //             });
        //         });

        //         $curriculumLessons->each(function ($lesson) use ($activities, $eligibleStudents, $curriculumSubjects) {
        //             // Attach video
        //             Video::factory()->create(['lesson_id' => $lesson->id]);

        //             // Filter activities whose Todo belongs to subjects in this curriculum
        //             $subjectIds = $curriculumSubjects->pluck('subject_id');
        //             $eligibleGameActivities = $activities->filter(function ($activity) use ($subjectIds) {
        //                 $activitySubjectIds = $activity->subjects->pluck('id');
        //                 return $activitySubjectIds->intersect($subjectIds)->isNotEmpty();
        //             });

        //             // Pick a random eligible activity (if any)
        //             $gameActivity = $eligibleGameActivities->isNotEmpty()
        //                 ? $eligibleGameActivities->random()
        //                 : null;

        //             if ($gameActivity) {
        //                 $gameActivityLesson = GameActivityLesson::create([
        //                     'lesson_id'        => $lesson->id,
        //                     'game_activity_id' => $gameActivity->id,
        //                 ]);

        //                 // Assign students only if there’s a matching activity
        //                 $eligibleStudents->each(function ($student) use ($lesson, $curriculumSubjects, $gameActivityLesson) {
        //                     $curriculumSubject = $curriculumSubjects->random();

        //                     LessonSubjectStudent::firstOrCreate([
        //                         'curriculum_subject_id' => $curriculumSubject->id,
        //                         'lesson_id'             => $lesson->id,
        //                         'student_id'            => $student->id,
        //                     ]);

        //                     StudentActivity::factory()->create([
        //                         'student_id'           => $student->id,
        //                         'activity_lesson_id'   => $gameActivityLesson->id,
        //                         'activity_lesson_type' => GameActivityLesson::class,
        //                     ]);
        //                 });
        //             }
        //         });
        //     });
        // });


        // // === Class Activity ===
        // $instructors = Instructor::all();

        // foreach ($instructors as $instructor) {
        //     $curriculumSubjects = CurriculumSubject::whereHas('curriculum', function ($q) use ($instructor) {
        //         $q->where('instructor_id', $instructor->id);
        //     })->with('subject.domains.subDomains.todos', 'subject.domains.todos')->get();

        //     $activities = collect();

        //     for ($i = 0; $i < 10; $i++) {
        //         if ($curriculumSubjects->isEmpty()) {
        //             continue;
        //         }

        //         // Pick a random CurriculumSubject
        //         $curriculumSubject = $curriculumSubjects->random();

        //         // 2️⃣ Get the related Subject
        //         $subject = $curriculumSubject->subject;
        //         if (!$subject) {
        //             continue; // skip if no subject
        //         }

        //         // Get a random domain from that subject
        //         $domain = $subject->domains()->inRandomOrder()->first();
        //         if (!$domain) {
        //             continue; // skip if no domain exists for subject
        //         }

        //         // Get todo — first from domain, fallback to subdomain
        //         $todo = $domain->todos()->inRandomOrder()->first();

        //         if (!$todo) {
        //             $subDomain = $domain->subDomains()->with('todos')->inRandomOrder()->first();
        //             if ($subDomain) {
        //                 $todo = $subDomain->todos()->inRandomOrder()->first();
        //             }
        //         }

        //         // If still no todo, skip
        //         if (!$todo) {
        //             continue;
        //         }

        //         // 6️⃣ Create ClassActivity now that we have a todo
        //         $activity = ClassActivity::factory()->create([
        //             'instructor_id'         => $instructor->id,
        //             'curriculum_subject_id' => $curriculumSubject->id,
        //             'lesson_id'             => null, // optional
        //         ]);

        //         $activity->todos()->attach($todo->id);

        //         $activities->push($activity);
        //     }

        //     // 7️⃣ Assign created activities to random students
        //     foreach ($activities as $activity) {
        //         $eligibleStudents = $instructor->eligibleStudents($activity->curriculumSubject->curriculum)->get();
        //         $students = $eligibleStudents->shuffle()->take(rand(3, 6));

        //         foreach ($students as $student) {
        //             StudentActivity::factory()->create([
        //                 'student_id'           => $student->id,
        //                 'activity_lesson_id'   => $activity->id,
        //                 'activity_lesson_type' => ClassActivity::class,
        //             ]);
        //         }
        //     }
        // }


        // // === Feeds ===
        // $students->each(function ($student) {
        //     Feed::factory()->create(['notifiable_id' => $student->id, 'group' => 'student']);
        // });
        // Feed::factory()->count(30)->create();
    }
}
