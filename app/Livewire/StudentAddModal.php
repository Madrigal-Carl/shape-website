<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Feed;
use App\Models\Account;
use App\Models\Student;
use Livewire\Component;
use App\Models\SchoolYear;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;


class StudentAddModal extends Component
{
    use WithFileUploads;
    public $step = 0;
    public $grade_levels, $specializations;
    public $barangayData = [], $municipalities = [], $permanent_barangays = [], $current_barangays = [], $copyPermanentToCurrent = false;
    public $photo, $lrn, $first_name, $middle_name, $last_name, $birthdate, $sex, $grade_level = '', $disability = '', $description;
    public $province = "marinduque";
    public $permanent_barangay = '', $permanent_municipal = '', $current_barangay = '', $current_municipal = '', $guardian_first_name, $guardian_middle_name, $guardian_last_name, $guardian_email, $guardian_phone;
    public $account_username, $account_password = '';


    public function updatedCopyPermanentToCurrent()
    {
        if ($this->copyPermanentToCurrent) {
            $this->current_municipal = $this->permanent_municipal;
            $this->current_barangay = $this->permanent_barangay;
            $this->current_barangays = $this->permanent_barangays;
        } else {
            // Optional: clear current address when unchecked
            $this->current_municipal = "";
            $this->current_barangay = "";
            $this->current_barangays = [];
        }
    }

    public function generateAccount()
    {
        $birthdate = str_replace('-', '', $this->birthdate);
        $lastName  = strtolower(trim($this->last_name));
        $firstName = strtolower(trim($this->first_name));

        $this->account_username = "{$lastName}{$firstName}";
        $this->account_password = "{$birthdate}-{$lastName}";
    }



    #[On('openModal')]
    public function openModal()
    {
        $this->step = 1;
    }

    public function nextStep()
    {
        if ($this->validateStep()) {
            $this->step++;
            if ($this->step === 2) {
                $this->generateAccount();
            }
        }
    }

    public function previousStep()
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    protected function validateStep()
    {
        if ($this->step === 1) {
            try {
                $this->validate([
                    'photo' => 'nullable|image|max:5120',
                    'lrn' => 'required|digits:12|unique:students,lrn',
                    'first_name' => 'required',
                    'middle_name' => 'required',
                    'last_name' => 'required',
                    'birthdate' => 'required|before_or_equal:-5 years',
                    'sex' => 'required',
                    'grade_level' => 'required',
                    'disability' => 'required',
                    'description' => 'nullable|max:255',
                ], [
                    'photo.image'            => 'The photo must be an image file.',
                    'photo.max'              => 'The photo size must not exceed 5MB.',
                    'lrn.required'           => 'The LRN field is required.',
                    'lrn.digits'             => 'The LRN must be exactly 12 digits.',
                    'lrn.unique'      => 'The LRN already existed.',
                    'first_name.required'    => 'The first name is required.',
                    'middle_name.required'   => 'The middle name is required.',
                    'last_name.required'     => 'The last name is required.',
                    'birthdate.required'     => 'The birthdate is required.',
                    'birthdate.before_or_equal' => 'The student must be at least 5 years old.',
                    'sex.required'           => 'Please select a sex.',
                    'grade_level.required'   => 'The grade level is required.',
                    'disability.required'    => 'Please specify the disability.',
                    'description.max'   => 'The description is too long.',
                ]);
            } catch (ValidationException $e) {
                $message = $e->validator->errors()->first();
                $this->dispatch('swal-toast', icon: 'error', title: $message);
                return false;
            }
            return true;
        }

        if ($this->step === 2) {
            try {
                $this->validate([
                    'permanent_municipal'  => 'required',
                    'permanent_barangay'   => 'required',
                    'current_municipal'    => 'required',
                    'current_barangay'     => 'required',
                    'guardian_first_name'  => 'required|max:35',
                    'guardian_middle_name' => 'nullable|max:35',
                    'guardian_last_name'   => 'required|max:35',
                    'guardian_email'       => 'required|email|unique:guardians,email',
                    'guardian_phone'       => 'nullable|digits:10|unique:guardians,phone_number',
                ], [
                    'permanent_municipal.required' => 'The permanent municipal is required.',
                    'permanent_barangay.required'  => 'The permanent barangay is required.',
                    'current_municipal.required'   => 'The current municipal is required.',
                    'current_barangay.required'    => 'The current barangay is required.',
                    'guardian_first_name.required' => 'The guardian first name is required.',
                    'guardian_first_name.max' => 'The guardian first name is too long.',
                    'guardian_middle_name.required' => 'The guardian middle name is required.',
                    'guardian_middle_name.max'     => 'The guardian middle name is too long.',
                    'guardian_last_name.required'  => 'The guardian last name is required.',
                    'guardian_last_name.max'     => 'The guardian last name is too long.',
                    'guardian_email.required'      => 'The guardian email is required.',
                    'guardian_email.email'         => 'The guardian email must be a valid email address.',
                    'guardian_email.unique'      => 'The guardian email already existed.',
                    'guardian_phone.digits'        => 'The guardian phone must be exactly 10 digits.',
                    'guardian_phone.unique'      => 'The guardian phone already existed.',
                ]);
            } catch (ValidationException $e) {
                $message = $e->validator->errors()->first();
                $this->dispatch('swal-toast', icon: 'error', title: $message);
                return false;
            }
            return true;
        }
    }

    public function closeModal()
    {
        $this->dispatch('refresh')->to('student-main');
        $this->dispatch('refresh')->to('student-aside');
        $this->reset();
    }

    public function canRegisterStudent()
    {
        $today = Carbon::today();

        $latestSY = SchoolYear::latest('first_quarter_start')->first();

        if (!$latestSY) {
            return false;
        }

        $syStart  = Carbon::parse($latestSY->first_quarter_start);
        $syEnd    = Carbon::parse($latestSY->fourth_quarter_end);
        $firstQEnd = Carbon::parse($latestSY->first_quarter_end);

        if ($today->greaterThan($syEnd)) {
            return true;
        }

        if ($today->between($syStart, $firstQEnd)) {
            return true;
        }

        return false;
    }

    public function addStudent()
    {
        $this->validateStep();

        if (!$this->canRegisterStudent()) {
            return $this->dispatch('swal-toast', icon: 'error', title: 'Enrollment period is closed.');
        }

        $path = null;
        if ($this->photo) {
            $studentName = preg_replace('/\s+/', '', "{$this->last_name}_{$this->first_name}_{$this->middle_name}");
            $extension   = $this->photo->getClientOriginalExtension();
            $customName  = "{$studentName}_Profile.{$extension}";

            $manager = new ImageManager(new Driver());
            $image = $manager->read($this->photo->getRealPath())
                ->scaleDown(width: 800)
                ->toJpeg(quality: 90);

            $path = "students/{$customName}";
            $image->save(storage_path('app/public/' . $path));
            ImageOptimizer::optimize(storage_path('app/public/' . $path));
        } else {
            if ($this->sex === 'male') {
                $path = 'default_profiles/default-male-student-pfp.png';
            } else {
                $path = 'default_profiles/default-female-student-pfp.png';
            }
        }

        $student = Student::create([
            'path'          => $path,
            'first_name'    => $this->first_name,
            'middle_name'   => $this->middle_name,
            'last_name'     => $this->last_name,
            'sex'           => $this->sex,
            'birth_date'    => $this->birthdate,
            'status'        => 'active',
            'disability_type' => $this->disability,
            'support_need'  => $this->description,
            'lrn'           => $this->lrn,
        ]);

        $student->enrollments()->create([
            'instructor_id' => Auth::user()->accountable->id,
            'grade_level_id'   => $this->grade_level,
        ]);

        $student->guardian()->create([
            'first_name'   => $this->guardian_first_name,
            'middle_name'  => $this->guardian_middle_name,
            'last_name'    => $this->guardian_last_name,
            'email'        => $this->guardian_email,
            'phone_number' => $this->guardian_phone,
        ]);

        $student->addresses()->create([
            'province' => $this->province,
            'municipality' => $this->permanent_municipal,
            'barangay' => $this->permanent_barangay,
            'type' => 'permanent',
        ]);

        $student->addresses()->create([
            'province' => $this->province,
            'municipality' => $this->current_municipal,
            'barangay' => $this->current_barangay,
            'type' => 'current',
        ]);

        $student->account()->create([
            'username'        => $this->account_username,
            'password'        => $this->account_password,
            'accountable_id'   => $student->id,
            'accountable_type' => Student::class,
        ]);

        Feed::create([
            'group' => 'student',
            'title' => 'New Student Registered',
            'message' => "'{$student->fullname}' has been registered as a student.",
        ]);

        $this->dispatch('swal-toast', icon: 'success', title: 'Student has been registered successfully.');
        return $this->closeModal();
    }

    public function updatedPermanentMunicipal($value)
    {
        $this->permanent_barangays = $this->barangayData[$value] ?? [];
        $this->permanent_barangay = '';
    }

    public function updatedCurrentMunicipal($value)
    {
        $this->current_barangays = $this->barangayData[$value] ?? [];
        $this->current_barangay = '';
    }

    public function render()
    {
        $this->barangayData = [
            "boac" => [
                "agot",
                "agumaymayan",
                "amoingon",
                "apitong",
                "balagasan",
                "balaring",
                "balimbing",
                "balogo",
                "bamban",
                "bangbangalon",
                "bantad",
                "bayuti",
                "binunga",
                "boi",
                "boton",
                "buliasnin",
                "bunganay",
                "caganhao",
                "canat",
                "catubugan",
                "cawit",
                "daig",
                "daypay",
                "duyay",
                "hinapulan",
                "ihatub",
                "isok i",
                "isok ii poblacion",
                "laylay",
                "lupac",
                "mahinhin",
                "mainit",
                "malbog",
                "maligaya",
                "malusak",
                "mamsiwat",
                "mataas na bayan",
                "maybo",
                "mercado",
                "murallon",
                "pawa",
                "pili",
                "poctoy",
                "poras",
                "puting buhangin",
                "puyog",
                "sabong",
                "san miguel",
                "santol",
                "sawi",
                "tabi",
                "tabigue",
                "tagwak",
                "tambunan",
                "tampus",
                "tanza",
                "tugos",
                "tumagabok",
                "tumapon",
            ],

            "buenavista" => [
                "bagacay",
                "bagtingon",
                "barangay i (poblacion)",
                "barangay ii (poblacion)",
                "barangay iii (poblacion)",
                "barangay iv (poblacion)",
                "bicas-bicas",
                "caigangan",
                "daykitin",
                "libas",
                "malbog",
                "sihi",
                "timbo (sanggulong)",
                "tungib-lipata",
                "yook",
            ],

            "gasan" => [
                "antipolo",
                "bachao ibaba",
                "bachao ilaya",
                "bacong-bacong",
                "bahi",
                "bangbang",
                "banot",
                "banuyo",
                "bognuyan",
                "cabugao",
                "dawis",
                "dili",
                "libtangin",
                "mahunig",
                "mangiliol",
                "masiga",
                "matandang gasan",
                "pangi",
                "pinggan",
                "tabionan",
                "tapuyan",
                "tiguion",
                "barangay i (poblacion)",
                "barangay ii (poblacion)",
                "barangay iii (poblacion)",
            ],

            "mogpog" => [
                "anapog-sibucao",
                "arago",
                "balanacan",
                "banto",
                "bintakay",
                "bocboc",
                "butansapa",
                "candahon",
                "capayang",
                "danao",
                "dulong bayan (poblacion)",
                "gitnang bayan (poblacion)",
                "guisian",
                "hinadharan",
                "hinanggayon",
                "ino",
                "janagdong",
                "lamesa",
                "malusak",
                "malayak",
                "mampaitan",
                "market site",
                "nangka i",
                "nangka ii",
                "pili",
                "puting buhangin",
                "sayao",
                "silangan",
                "sumangga",
                "tarug",
                "villa mendez",
            ],

            "santa cruz" => [
                "alobo",
                "angas",
                "aturan",
                "bagong silang poblacion (2nd zone)",
                "baguidbirin",
                "baliis",
                "balogo",
                "banahaw poblacion (3rd zone)",
                "bangcuangan",
                "banogbog",
                "biga",
                "botilao",
                "buyabod",
                "dating bayan",
                "devilla",
                "dolores",
                "haguimit",
                "hupi",
                "ipil",
                "jolo",
                "kaganhao",
                "kalangkang",
                "kamandugan",
                "kasily",
                "kilo-kilo",
                "kinyaman",
                "labor / labo",
                "lamesa",
                "landy (perez)",
                "lapu-lapu poblacion (5th zone)",
                "libjo",
                "lipa",
                "lusok",
                "maharlika poblacion (1st zone)",
                "makulapnit",
                "maniwaya",
                "manlibunan",
                "masaguisi",
                "masalukot",
                "matalaba",
                "mongpong",
                "morales",
                "napo (malabon)",
                "pag-asa poblacion (4th zone)",
                "pantayin",
                "polo",
                "pulong-parang",
                "punong",
                "san antonio",
                "san isidro",
                "tagum",
                "tamayo",
                "tambangan",
                "tawiran",
                "taytay",
            ],

            "torrijos" => [
                "bangwayin",
                "bayakbakin",
                "bolo",
                "bonliw",
                "buangan",
                "cabuyo",
                "cagpo",
                "dampulan",
                "kay duke",
                "makawayan",
                "malibago",
                "malinao",
                "maranlig",
                "marlangga",
                "matuyatuya",
                "nangka",
                "pakaskasan",
                "payanas",
                "poblacion",
                "poctoy",
                "sibuyao",
                "suha",
                "talawan",
                "tigwi",
            ],

        ];
        $this->municipalities = array_keys($this->barangayData);
        $this->specializations = Auth::user()->accountable->specializations;
        $this->grade_levels = Auth::user()->accountable->gradeLevels->sortBy('id')->values();
        return view('livewire.student-add-modal');
    }
}
