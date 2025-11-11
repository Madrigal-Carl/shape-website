<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Illuminate\Validation\ValidationException;

class Profile extends Component
{
    use WithFileUploads;

    public $photo;
    public $user;

    // Personal
    public $first_name;
    public $middle_name;
    public $last_name;
    public $isEditing = false;
    public $original_name = [];

    // Address
    public $province = 'Marinduque';
    public $permanent_municipality;
    public $permanent_barangay;
    public $current_municipality;
    public $current_barangay;
    public $isEditingAddress = false;
    public $original_address = [];

    // Options
    public $municipalities = [];
    public $barangayData = [];
    public $permanent_barangays = [];
    public $current_barangays = [];

    // Account
    public $username;
    public $password;
    public $old_password;
    public $password_confirmation;
    public $isEditingAccount = false;
    public $isDefaultAccount = false;
    public $default_password;

    public function mount()
    {
        $this->user = Auth::user();

        // Names
        $this->first_name  = $this->user->accountable->first_name;
        $this->middle_name = $this->user->accountable->middle_name;
        $this->last_name   = $this->user->accountable->last_name;
        $this->original_name = [
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
        ];

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

        // Addresses
        if ($this->user->accountable instanceof \App\Models\Admin) {
            $permanent = '';
            $current = '';
        } else {
            $permanent = $this->user->accountable->permanentAddress;
            $current   = $this->user->accountable->currentAddress;
        }

        if ($permanent) {
            $this->permanent_municipality = $permanent->municipality;
            $this->permanent_barangays    = $this->barangayData[$this->permanent_municipality] ?? [];
            $this->permanent_barangay     = $permanent->barangay;
        }

        if ($current) {
            $this->current_municipality = $current->municipality;
            $this->current_barangays    = $this->barangayData[$this->current_municipality] ?? [];
            $this->current_barangay     = $current->barangay;
        }
        $this->original_address = [
            'permanent_municipality' => $this->permanent_municipality,
            'permanent_barangay' => $this->permanent_barangay,
            'current_municipality' => $this->current_municipality,
            'current_barangay' => $this->current_barangay,
        ];

        // Account check
        $birthdate = str_replace('-', '', $this->user->accountable->birth_date ?? '');
        $lastName  = strtolower(trim($this->last_name));
        $firstName = strtolower(trim($this->first_name));

        $expected_username = "{$lastName}{$firstName}";
        $expected_password = "{$birthdate}-{$lastName}";

        if ($this->user->username === $expected_username && Hash::check($expected_password, $this->user->password)) {
            $this->isDefaultAccount = true;
            $this->default_password = $expected_password;
        }
        // Account
        $this->username = $this->user->username;
    }

    public function savePhoto()
    {
        try {
            $this->validate([
                'photo' => 'image|max:5120',
            ], [
                'photo.image'            => 'The photo must be an image file.',
                'photo.max'              => 'The photo size must not exceed 5MB.',
            ]);
        } catch (ValidationException $e) {
            $message = $e->validator->errors()->first();
            return $this->dispatch('swal-toast', icon: 'error', title: $message);
        }

        $oldPath = $this->user->accountable->path;

        if (
            $oldPath &&
            Storage::disk('public')->exists($oldPath) &&
            !str_starts_with($oldPath, 'default_profiles/')
        ) {
            Storage::disk('public')->delete($oldPath);
        }

        // Generate custom filename based on instructor's name
        $instructorName = preg_replace(
            '/\s+/',
            '',
            "{$this->user->accountable->last_name}_{$this->user->accountable->first_name}_{$this->user->accountable->middle_name}"
        );
        $extension  = $this->photo->getClientOriginalExtension();
        $customName = "{$instructorName}_Profile.{$extension}";
        $path       = "instructors/{$customName}";

        // --- Compress and resize image before saving ---
        $manager = new ImageManager(new Driver());
        $image = $manager->read($this->photo->getRealPath())
            ->scaleDown(width: 800) // resize width (keep aspect ratio)
            ->toJpeg(quality: 85); // compress quality (adjust as needed)

        // Save to storage/app/public/instructors/
        $savePath = storage_path('app/public/' . $path);
        $image->save($savePath);

        // Optional: further optimize the file
        $optimizer = OptimizerChainFactory::create();
        $optimizer->optimize($savePath);

        $this->user->accountable->update([
            'path' => $path,
        ]);

        $this->user->refresh();

        $this->photo = null;

        $this->dispatch('refresh')->to('side-bar');
        $this->dispatch('swal-toast', icon: 'success', title: 'Profile photo updated successfully!');
    }

    // ---------------- FULL NAME ----------------
    public function toggleEdit()
    {
        $this->isEditing = !$this->isEditing;

        if (!$this->isEditing) {
            $this->first_name  = $this->user->accountable->first_name;
            $this->middle_name = $this->user->accountable->middle_name;
            $this->last_name   = $this->user->accountable->last_name;
        }
    }

    public function save()
    {
        try {
            $this->validate([
                'first_name'  => 'required',
                'middle_name' => 'required',
                'last_name'   => 'required',
            ], [
                'first_name.required'    => 'The first name is required.',
                'middle_name.required'   => 'The middle name is required.',
                'last_name.required'     => 'The last name is required.',
            ]);
        } catch (ValidationException $e) {
            $message = $e->validator->errors()->first();
            return $this->dispatch('swal-toast', icon: 'error', title: $message);
        }

        $current = [
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
        ];

        if ($current == $this->original_name) {
            $this->isEditing = false;
            $this->dispatch('swal-toast', icon: 'info', title: 'No changes have been made.');
            return;
        }

        $this->user->accountable->update($current);

        $this->user->refresh();
        $this->isEditing = false;
        $this->dispatch('refresh')->to('side-bar');
        $this->dispatch('swal-toast', icon: 'success', title: 'Name updated successfully!');
    }

    // ---------------- ADDRESS ----------------
    public function toggleEditAddress()
    {
        $this->isEditingAddress = !$this->isEditingAddress;

        if (! $this->isEditingAddress) {
            $permanent = $this->user->accountable->permanentAddress;
            $current   = $this->user->accountable->currentAddress;

            if ($permanent) {
                $this->permanent_municipality = $permanent->municipality;
                $this->permanent_barangays    = $this->barangayData[$this->permanent_municipality] ?? [];
                $this->permanent_barangay     = $permanent->barangay;
            }

            if ($current) {
                $this->current_municipality = $current->municipality;
                $this->current_barangays    = $this->barangayData[$this->current_municipality] ?? [];
                $this->current_barangay     = $current->barangay;
            }
        }
    }

    public function updatedPermanentMunicipality($value)
    {
        $this->permanent_barangays = $this->barangayData[$value] ?? [];
        $this->permanent_barangay = '';
    }

    public function updatedCurrentMunicipality($value)
    {
        $this->current_barangays = $this->barangayData[$value] ?? [];
        $this->current_barangay = '';
    }

    public function saveAddress()
    {
        try {
            $this->validate([
                'permanent_municipality' => 'required',
                'permanent_barangay' => 'required',
                'current_municipality' => 'required',
                'current_barangay' => 'required',
            ], [
                'permanent_municipal.required' => 'The permanent municipal is required.',
                'permanent_barangay.required'  => 'The permanent barangay is required.',
                'current_municipal.required'   => 'The current municipal is required.',
                'current_barangay.required'    => 'The current barangay is required.',
            ]);
        } catch (ValidationException $e) {
            $message = $e->validator->errors()->first();
            return $this->dispatch('swal-toast', icon: 'error', title: $message);
        }

        $current = [
            'permanent_municipality' => $this->permanent_municipality,
            'permanent_barangay' => $this->permanent_barangay,
            'current_municipality' => $this->current_municipality,
            'current_barangay' => $this->current_barangay,
        ];

        if ($current == $this->original_address) {
            $this->isEditingAddress = false;
            $this->dispatch('swal-toast', icon: 'info', title: 'No changes have been made.');
            return;
        }

        $this->user->accountable->permanentAddress()->update(
            [
                'province' => $this->province,
                'municipality' => $this->permanent_municipality,
                'barangay' => $this->permanent_barangay,
            ]
        );

        $this->user->accountable->currentAddress()->update(
            [
                'province' => $this->province,
                'municipality' => $this->current_municipality,
                'barangay' => $this->current_barangay,
            ]
        );

        $this->user->refresh();
        $this->isEditingAddress = false;
        $this->dispatch('swal-toast', icon: 'success', title: 'Address updated successfully!');
    }

    // ---------------- ACCOUNT ----------------
    public function toggleEditAccount()
    {
        $this->isEditingAccount = !$this->isEditingAccount;

        if (!$this->isEditingAccount) {
            $this->username = $this->user->username;
            $this->password = '';
            $this->password_confirmation = '';
        }
    }

    public function saveAccount()
    {
        try {
            $this->validate([
                'username' => 'required|max:255|unique:accounts,username,' . $this->user->id,
                'old_password' => 'nullable|min:5',
                'password' => 'nullable|min:5|confirmed',
            ], [
                'username.required' => 'The username is required.',
                'username.unique'   => 'This username is already taken.',
                'username.max'      => 'The username may not be greater than 255 characters.',
                // 'old_password.required' => 'The old password is required.',
                'old_password.min'      => 'The old password must be at least 5 characters.',
                'password.min'       => 'The new password must be at least 5 characters.',
                'password.confirmed' => 'The password confirmation does not match.',
            ]);
        } catch (ValidationException $e) {
            $message = $e->validator->errors()->first();
            return $this->dispatch('swal-toast', icon: 'error', title: $message);
        }

        $usernameUnchanged = $this->username === $this->user->username;
        $passwordUnchanged = empty($this->password);

        if ($usernameUnchanged && $passwordUnchanged) {
            $this->isEditingAccount = false;
            $this->dispatch('swal-toast', icon: 'info', title: 'No changes have been made.');
            return;
        }

        if (!Hash::check($this->old_password, $this->user->password)) {
            $this->dispatch('swal-toast', icon: 'error', title: 'The old password is incorrect.');
            return;
        }

        $this->user->update([
            'username' => $this->username,
            'password' => $this->password ? Hash::make($this->password) : $this->user->password,
        ]);

        $this->user->refresh();
        $this->isEditingAccount = false;
        $this->reset(['old_password', 'password', 'password_confirmation']);
        $this->dispatch('swal-toast', icon: 'success', title: 'Account updated successfully!');
    }

    public function render()
    {
        return view('livewire.profile');
    }
}
