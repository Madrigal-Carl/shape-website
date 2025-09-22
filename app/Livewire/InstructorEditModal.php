<?php

namespace App\Livewire;

use App\Models\Feed;
use App\Models\Instructor;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use App\Models\Specialization;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class InstructorEditModal extends Component
{
    use WithFileUploads;

    public $step = 0;

    // Instructor Info
    public $photo, $currentPhoto;
    public $license_number, $first_name, $middle_name, $last_name, $birthdate, $sex = '';
    public $showSpecializations = false;
    public $selectedSpecializations = [];

    // Address
    public $province = 'marinduque';
    public $permanent_municipal = '', $permanent_barangay = '';
    public $current_municipal = '', $current_barangay = '';
    public $barangayData = [], $municipalities = [], $permanent_barangays = [], $current_barangays = [];

    // Account
    public $account_username, $account_password;
    public $account_username_changed = false;
    public $account_password_changed = false;
    public $default_password;

    // For rendering specializations
    public $specializations;

    // For edit
    public $instructor_id;
    public $original = [];

    #[On('openModal')]
    public function openModal($id)
    {
        $this->step = 1;
        $this->instructor_id = $id;

        $instructor = Instructor::with(['specializations', 'addresses', 'account'])->findOrFail($id);

        $this->license_number = $instructor->license_number;
        $this->first_name = $instructor->first_name;
        $this->middle_name = $instructor->middle_name;
        $this->last_name = $instructor->last_name;
        $this->birthdate = $instructor->birth_date;
        $this->currentPhoto = $instructor->path;
        $this->sex = $instructor->sex;

        $this->selectedSpecializations = $instructor->specializations->pluck('id')->toArray();

        // Addresses
        $permanent = $instructor->permanentAddress;
        $current = $instructor->currentAddress;
        if ($permanent) {
            $this->permanent_municipal = $permanent->municipality;
            $this->permanent_barangays = $this->barangayData[$this->permanent_municipal] ?? [];
            $this->permanent_barangay  = $permanent->barangay;
        }
        if ($current) {
            $this->current_municipal = $current->municipality;
            $this->current_barangays = $this->barangayData[$this->current_municipal] ?? [];
            $this->current_barangay  = $current->barangay;
        }

        // Account
        $this->account_username = $instructor->account->username ?? '';
        $this->account_password = '';
        $defaultPassword = str_replace('-', '', $this->birthdate) . '-' . strtolower(trim($this->last_name));
        $this->default_password = $defaultPassword;
        $defaultUsername = strtolower(trim($this->last_name . $this->first_name));
        $this->account_username_changed = $this->account_username !== $defaultUsername;
        $this->account_password_changed = ! Hash::check($this->default_password, $instructor->account->password ?? '');

        // Store original for change detection
        $this->original = [
            'license_number' => $this->license_number,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'birthdate' => $this->birthdate,
            'sex' => $this->sex,
            'currentPhoto' => $this->currentPhoto,
            'selectedSpecializations' => $this->selectedSpecializations,
            'permanent_municipal' => $this->permanent_municipal,
            'permanent_barangay' => $this->permanent_barangay,
            'current_municipal' => $this->current_municipal,
            'current_barangay' => $this->current_barangay,
        ];
    }

    public function mount()
    {
        $this->barangayData = [
            "boac" => ["agot", "agumaymayan", "amoingon", "apitong", "balagasan", "balaring", "balimbing", "balogo", "bamban", "bangbangalon", "bantad", "bayuti", "binunga", "boi", "boton", "buliasnin", "bunganay", "caganhao", "canat", "catubugan", "cawit", "daig", "daypay", "duyay", "hinapulan", "ihatub", "isok i", "isok ii poblacion", "laylay", "lupac", "mahinhin", "tumapon"],
            "buenavista" => ["yook"],
            "gasan" => ["barangay iii (poblacion)"],
            "mogpog" => ["villa mendez"],
            "santa cruz" => ["taytay"],
            "torrijos" => ["tigwi"],
        ];
        $this->municipalities = array_keys($this->barangayData);
        $this->specializations = Specialization::all();
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

        $baseUsername = "{$lastName}{$firstName}";
        $username = $baseUsername;

        $count = 1;
        while (\App\Models\Account::where('username', $username)->where('accountable_id', '!=', $this->instructor_id)->exists()) {
            $username = $baseUsername . $count;
            $count++;
        }

        $this->account_username = $username;
        $this->account_password = "{$birthdate}-{$lastName}";
    }

    public function resetAccount()
    {
        $defaultUsername = strtolower(trim($this->last_name . $this->first_name));
        $defaultPassword = str_replace('-', '', $this->birthdate) . '-' . strtolower(trim($this->last_name));

        $instructor = Instructor::with('account')->findOrFail($this->instructor_id);

        if ($instructor->account) {
            $instructor->account->username = $defaultUsername;
            $instructor->account->password = Hash::make($defaultPassword);
            $instructor->account->save();
        }

        $this->account_username = $defaultUsername;
        $this->default_password = $defaultPassword;
        $this->account_username_changed = false;
        $this->account_password_changed = false;

        $this->dispatch('swal-toast', icon: 'success', title: 'Account has been reset to default!');
    }

    protected function validateStep()
    {
        if ($this->step === 1) {
            try {
                $this->validate([
                    'photo' => 'nullable|image|max:5120',
                    'license_number' => 'required|digits:7|unique:instructors,license_number,' . $this->instructor_id,
                    'first_name' => 'required',
                    'middle_name' => 'required',
                    'last_name' => 'required',
                    'birthdate' => 'required|before_or_equal:-20 years',
                    'sex' => 'required|in:male,female',
                    'selectedSpecializations' => 'required|array|min:1',
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

    public function editInstructor()
    {
        // Validate all steps before saving
        if (!$this->validateStep()) {
            return;
        }

        // Check if anything has changed
        $current = [
            'license_number' => $this->license_number,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'birthdate' => $this->birthdate,
            'sex' => $this->sex,
            'currentPhoto' => $this->currentPhoto,
            'selectedSpecializations' => $this->selectedSpecializations,
            'permanent_municipal' => $this->permanent_municipal,
            'permanent_barangay' => $this->permanent_barangay,
            'current_municipal' => $this->current_municipal,
            'current_barangay' => $this->current_barangay,
        ];

        $hasPhotoChanged = false;
        if ($this->photo) {
            $hasPhotoChanged = true;
        } elseif ($this->currentPhoto !== ($this->original['currentPhoto'] ?? null)) {
            $hasPhotoChanged = true;
        }

        if ($current == $this->original && !$hasPhotoChanged) {
            $this->dispatch('swal-toast', icon: 'info', title: 'No changes have been made.');
            $this->closeModal();
            return;
        }

        $instructor = Instructor::findOrFail($this->instructor_id);

        // Photo upload
        if ($this->photo) {
            $instructorName = preg_replace('/\s+/', '', "{$this->last_name}_{$this->first_name}_{$this->middle_name}");
            $extension   = $this->photo->getClientOriginalExtension();
            $customName  = "{$instructorName}_Profile.{$extension}";
            $path = $this->photo->storeAs('instructors', $customName, 'public');
            $instructor->path = $path;
            $this->currentPhoto = $path;
        }

        // Update instructor info
        $instructor->license_number = $this->license_number;
        $instructor->first_name = $this->first_name;
        $instructor->middle_name = $this->middle_name;
        $instructor->last_name = $this->last_name;
        $instructor->birth_date = $this->birthdate;
        $instructor->sex = $this->sex;
        $instructor->save();

        // Update specializations
        $instructor->specializations()->sync($this->selectedSpecializations);

        // Update addresses
        $instructor->addresses()->updateOrCreate(
            ['type' => 'permanent'],
            [
                'province' => $this->province,
                'municipality' => $this->permanent_municipal,
                'barangay' => $this->permanent_barangay,
                'type' => 'permanent',
            ]
        );
        $instructor->addresses()->updateOrCreate(
            ['type' => 'current'],
            [
                'province' => $this->province,
                'municipality' => $this->current_municipal,
                'barangay' => $this->current_barangay,
                'type' => 'current',
            ]
        );

        Feed::create([
            'group' => 'instructor',
            'title' => 'Instructor Updated',
            'message' => "'{$instructor->full_name}' has been updated.",
        ]);

        $this->dispatch('swal-toast', icon: 'success', title: 'Instructor updated successfully!');
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
        return view('livewire.instructor-edit-modal');
    }
}
