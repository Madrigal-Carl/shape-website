<?php

namespace App\Livewire;

use App\Models\Feed;
use App\Models\Account;
use Livewire\Component;
use App\Models\GradeLevel;
use App\Models\Instructor;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use App\Models\Specialization;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Spatie\ImageOptimizer\OptimizerChainFactory;


class InstructorAddModal extends Component
{
    use WithFileUploads;

    public $step = 0;

    // Instructor Info
    public $photo;
    public $license_number, $first_name, $middle_name, $last_name, $birthdate, $sex = '';
    public $showSpecializations = false;
    public $showGradeLevels = false;
    public $selectedSpecializations = [];
    public $selectedGradeLevels = [];

    // Address
    public $province = 'marinduque';
    public $permanent_municipal = '', $permanent_barangay = '';
    public $current_municipal = '', $current_barangay = '';
    public $barangayData = [], $municipalities = [], $permanent_barangays = [], $current_barangays = [];

    // Account
    public $account_username, $account_password;

    public $specializations, $gradeLevels;

    #[On('openModal')]
    public function openModal()
    {
        $this->step = 1;
    }

    public function nextStep()
    {
        if ($this->validateStep()) {
            $this->step++;
            if ($this->step === 3) {
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

    public function closeModal()
    {
        $this->reset();
        $this->step = 0;
        $this->dispatch('refresh')->to('instructor-main');
        $this->dispatch('refresh')->to('instructor-aside');
    }

    public function clearSpecializations()
    {
        $this->selectedSpecializations = [];
    }

    public function clearGradeLevels()
    {
        $this->selectedGradeLevels = [];
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

    public function generateAccount()
    {
        $birthdate = str_replace('-', '', $this->birthdate);
        $lastName  = strtolower(trim($this->last_name));
        $firstName = strtolower(trim($this->first_name));

        $this->account_username = "{$lastName}{$firstName}";
        $this->account_password = "{$birthdate}-{$lastName}";
    }

    protected function validateStep()
    {
        if ($this->step === 1) {
            try {
                $this->validate([
                    'photo' => 'nullable|image|max:5120',
                    'license_number' => 'required|unique:instructors,license_number|digits:7',
                    'first_name' => 'required',
                    'middle_name' => 'required',
                    'last_name' => 'required',
                    'birthdate' => 'required|before_or_equal:-20 years',
                    'sex' => 'required|in:male,female',
                    'selectedSpecializations' => 'required|array|min:1',
                    'selectedGradeLevels' => 'required|array|min:1',
                ], [
                    'photo.image'            => 'The photo must be an image file.',
                    'photo.max'              => 'The photo size must not exceed 5MB.',
                    'license_number.required' => 'The license number is required.',
                    'license_number.unique'   => 'The license number already exists.',
                    'first_name.required'    => 'The first name is required.',
                    'middle_name.required'   => 'The middle name is required.',
                    'last_name.required'     => 'The last name is required.',
                    'birthdate.required'     => 'The birthdate is required.',
                    'birthdate.before_or_equal' => 'The teacher must be at least 20 years old.',
                    'sex.required'           => 'Please select a sex.',
                    'selectedSpecializations.required' => 'Please select at least one specialization.',
                    'selectedSpecializations.min' => 'Please select at least one specialization.',
                    'selectedGradeLevels.required' => 'Please select at least one grade level.',
                    'selectedGradeLevels.min' => 'Please select at least one grade level.',
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
                ], [
                    'permanent_municipal.required' => 'The permanent municipal is required.',
                    'permanent_barangay.required'  => 'The permanent barangay is required.',
                    'current_municipal.required'   => 'The current municipal is required.',
                    'current_barangay.required'    => 'The current barangay is required.',
                ]);
            } catch (ValidationException $e) {
                $message = $e->validator->errors()->first();
                $this->dispatch('swal-toast', icon: 'error', title: $message);
                return false;
            }
            return true;
        }

        return true;
    }

    public function addInstructor()
    {
        // Validate all steps before saving
        if (!$this->validateStep()) {
            return;
        }

        // Photo upload
        $path = null;

        if ($this->photo) {
            $instructorName = preg_replace('/\s+/', '', "{$this->last_name}_{$this->first_name}_{$this->middle_name}");
            $extension = strtolower($this->photo->getClientOriginalExtension());
            $customName = "{$instructorName}_Profile.{$extension}";
            $manager = new ImageManager(new Driver());

            $image = $manager->read($this->photo->getRealPath())
                ->scaleDown(width: 800)
                ->toJpeg(quality: 90);
            $path = "instructors/{$customName}";

            $savePath = storage_path("app/public/{$path}");
            $image->save($savePath);

            $optimizer = OptimizerChainFactory::create();
            $optimizer->optimize($savePath);
        } else {
            // 🧍 Default profile by gender
            $path = $this->sex === 'male'
                ? 'default_profiles/default-male-teacher-pfp.png'
                : 'default_profiles/default-female-teacher-pfp.png';
        }

        // Create Instructor
        $instructor = Instructor::create([
            'license_number' => $this->license_number,
            'path'           => $path,
            'first_name'     => $this->first_name,
            'middle_name'    => $this->middle_name,
            'last_name'      => $this->last_name,
            'sex'            => $this->sex,
            'birth_date'     => $this->birthdate,
            'status'         => 'active',
        ]);

        // Attach Specializations
        $instructor->specializations()->sync($this->selectedSpecializations);

        // Attach Grade Levels
        $instructor->gradeLevels()->sync($this->selectedGradeLevels);

        // Addresses
        $instructor->addresses()->create([
            'province'     => $this->province,
            'municipality' => $this->permanent_municipal,
            'barangay'     => $this->permanent_barangay,
            'type'         => 'permanent',
        ]);
        $instructor->addresses()->create([
            'province'     => $this->province,
            'municipality' => $this->current_municipal,
            'barangay'     => $this->current_barangay,
            'type'         => 'current',
        ]);

        // Account
        $account = $instructor->account()->create([
            'username'        => $this->account_username,
            'password'        => Hash::make($this->account_password),
            'accountable_id'   => $instructor->id,
            'accountable_type' => Instructor::class,
        ]);

        Feed::create([
            'group' => 'instructor',
            'title' => 'New Instructor Registered',
            'message' => "'{$instructor->fullname}' has been registered as a instructor.",
        ]);

        $this->dispatch('swal-toast', icon: 'success', title: 'Instructor has been registered successfully.');
        $this->closeModal();
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
        $this->specializations = Specialization::all();
        $this->gradeLevels = GradeLevel::all();
        return view('livewire.instructor-add-modal');
    }
}
