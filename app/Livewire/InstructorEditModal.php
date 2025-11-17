<?php

namespace App\Livewire;

use App\Models\Account;
use Livewire\Component;
use App\Models\GradeLevel;
use App\Models\Instructor;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use App\Models\Specialization;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Intervention\Image\Drivers\Gd\Driver;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

class InstructorEditModal extends Component
{
    use WithFileUploads;

    public $step = 0;

    // Instructor Info
    public $photo, $currentPhoto;
    public $license_number, $status = '', $first_name, $middle_name, $last_name, $birthdate, $sex = '';
    public $showSpecializations = false, $copyPermanentToCurrent = false;
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
    public $account_username_changed = false;
    public $account_password_changed = false;
    public $default_password;

    public $specializations, $gradeLevels;

    // For edit
    public $instructor_id;
    public $original = [];

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
        $this->status = $instructor->status;

        $this->selectedSpecializations = $instructor->specializations->pluck('id')->toArray();
        $this->selectedGradeLevels = $instructor->gradeLevels->pluck('id')->toArray();

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
        $lastName  = strtolower(str_replace(' ', '', trim($this->last_name)));
        $firstName = strtolower(str_replace(' ', '', trim($this->first_name)));
        $baseUsername = "{$lastName}{$firstName}";
        $this->account_username_changed = !preg_match("/^" . preg_quote($baseUsername, '/') . "\d*$/", $this->account_username);
        $this->account_password_changed = ! Hash::check($this->default_password, $instructor->account->password ?? '');

        // Store original for change detection
        $this->original = [
            'username' => $this->account_username,
            'license_number' => $this->license_number,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'birthdate' => $this->birthdate,
            'sex' => $this->sex,
            'currentPhoto' => $this->currentPhoto,
            'status' => $this->status,
            'selectedSpecializations' => $this->selectedSpecializations,
            'selectedGradeLevels' => $this->selectedGradeLevels,
            'permanent_municipal' => $this->permanent_municipal,
            'permanent_barangay' => $this->permanent_barangay,
            'current_municipal' => $this->current_municipal,
            'current_barangay' => $this->current_barangay,
        ];
    }

    public function nextStep()
    {
        if ($this->validateStep()) {
            $this->step++;
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

    public function resetAccount()
    {
        $instructor = Instructor::with('account')->findOrFail($this->instructor_id);

        $birthdate = str_replace('-', '', $instructor->birth_date);
        $lastName  = strtolower(str_replace(' ', '', trim($this->last_name)));
        $firstName = strtolower(str_replace(' ', '', trim($this->first_name)));

        $baseUsername = "{$lastName}{$firstName}";
        $username = $baseUsername;

        $counter = 1;
        while (Account::where('username', $username)->where('id', '!=', $instructor->account->id)->exists()) {
            $username = $baseUsername . $counter;
            $counter++;
        }

        $this->account_username = $username;
        $this->account_password = "{$birthdate}-{$lastName}";

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
                    'status'  => 'required',
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
                    'status.required'            => 'The status is required.',
                    'first_name.required'    => 'The first name is required.',
                    'middle_name.required'   => 'The middle name is required.',
                    'last_name.required'     => 'The last name is required.',
                    'birthdate.required'     => 'The birthdate is required.',
                    'birthdate.before_or_equal' => 'The teacher must be at least 20 years old.',
                    'sex.required'           => 'Please select a sex.',
                    'selectedSpecializations.required' => 'Please select at least one specialization.',
                    'selectedSpecializations.min' => 'Please select at least one specialization.',
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

    public function editInstructor()
    {
        // Validate all steps before saving
        if (!$this->validateStep()) {
            return;
        }

        // Check if anything has changed
        $current = [
            'username' => $this->account_username,
            'license_number' => $this->license_number,
            'status' => $this->status,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'birthdate' => $this->birthdate,
            'sex' => $this->sex,
            'currentPhoto' => $this->currentPhoto,
            'selectedSpecializations' => $this->selectedSpecializations,
            'selectedGradeLevels' => $this->selectedGradeLevels,
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
            if (
                $instructor->path &&
                Storage::disk('public')->exists($instructor->path) &&
                !str_starts_with($instructor->path, 'default_profiles/')
            ) {
                Storage::disk('public')->delete($instructor->path);
            }

            $instructorName = preg_replace('/\s+/', '', "{$this->last_name}_{$this->first_name}_{$this->middle_name}");
            $timestamp = time();
            $customName = "{$instructorName}_Profile_{$timestamp}.jpg"; // Always save as JPEG
            $manager = new ImageManager(new Driver());

            $image = $manager->read($this->photo->getRealPath())
                ->scaleDown(width: 800)
                ->toJpeg(quality: 90);

            $path = "instructors/{$customName}";
            $savePath = storage_path("app/public/{$path}");
            $image->save($savePath);

            $optimizer = OptimizerChainFactory::create();
            $optimizer->optimize($savePath);

            $instructor->path = $path;
            $this->currentPhoto = $path;
        }


        // Update instructor info
        $instructor->license_number = $this->license_number;
        $instructor->status = $this->status;
        $instructor->first_name = $this->first_name;
        $instructor->middle_name = $this->middle_name;
        $instructor->last_name = $this->last_name;
        $instructor->birth_date = $this->birthdate;
        $instructor->sex = $this->sex;
        $instructor->save();

        $instructor->specializations()->sync($this->selectedSpecializations);
        $instructor->gradeLevels()->sync($this->selectedGradeLevels);

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

        $instructor->account->update(
            [
                'username' => $this->account_username,
                'password' => $this->account_password ?: $instructor->account->password,
            ]
        );

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
        $this->gradeLevels = GradeLevel::all();
        return view('livewire.instructor-edit-modal');
    }
}
