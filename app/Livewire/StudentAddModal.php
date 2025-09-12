<?php

namespace App\Livewire;

use App\Models\Feed;
use App\Models\Student;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class StudentAddModal extends Component
{
    use WithFileUploads;
    public $step = 0;
    public $grade_levels = [], $specializations;
    public $barangayData = [], $municipalities = [], $permanent_barangays = [], $current_barangays = [];
    public $photo, $lrn, $first_name, $middle_name, $last_name, $birthdate, $sex, $grade_level, $disability, $description;
    public $province = "marinduque";
    public $permanent_barangay, $permanent_municipal, $current_barangay, $current_municipal, $guardian_first_name, $guardian_middle_name, $guardian_last_name, $guardian_email, $guardian_phone;
    public $account_username, $account_password = '';


    public function generatePassword()
    {
        $birthdate = str_replace('-', '', $this->birthdate);
        $lastName = strtolower(trim($this->last_name));
        $this->account_password = "{$birthdate}-{$lastName}";
    }

    public function generateUsername()
    {
        $firstName = strtolower(trim($this->first_name));
        $lastName = strtolower(trim($this->last_name));

        $this->account_username = "{$lastName}{$firstName}";
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
                $this->generatePassword();
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
                    'lrn' => 'required|digits:12',
                    'first_name' => 'required',
                    'middle_name' => 'required',
                    'last_name' => 'required',
                    'birthdate' => 'required|before_or_equal:today',
                    'sex' => 'required',
                    'grade_level' => 'required',
                    'disability' => 'required',
                    'description' => 'nullable|max:255',
                ], [
                    'photo.image'            => 'The photo must be an image file.',
                    'photo.max'              => 'The photo size must not exceed 5MB.',
                    'lrn.required'           => 'The LRN field is required.',
                    'lrn.digits'             => 'The LRN must be exactly 12 digits.',
                    'first_name.required'    => 'The first name is required.',
                    'middle_name.required'   => 'The middle name is required.',
                    'last_name.required'     => 'The last name is required.',
                    'birthdate.required'     => 'The birthdate is required.',
                    'birthdate.before_or_equal' => 'The birthdate must not advance on the present date.',
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

        if ($this->step === 3) {
            // try {
            //     $this->validate([
            //         'account_username' => 'required|min:5|max:18',
            //         'account_password' => 'required|min:5|max:18|regex:/^[a-zA-Z0-9]+$/',
            //     ], [
            //         'account_username.required'    => 'Username is required.',
            //         'account_username.min'      => 'Username must be at least 5 characters.',
            //         'account_username.max'      => 'Username must not be more than 18 characters.',
            //         'account_password.required' => 'Password is required.',
            //         'account_password.min'      => 'Password must be at least 5 characters.',
            //         'account_password.max'      => 'Password must not be more than 18 characters.',
            //         'account_password.regex'    => 'Password must contain only letters and numbers (no special characters).',
            //     ]);
            // } catch (ValidationException $e) {
            //     $message = $e->validator->errors()->first();
            //     $this->dispatch('swal-toast', icon: 'error', title: $message);
            //     return false;
            // }
            return true;
        }
    }

    public function closeModal()
    {
        $this->dispatch('refresh')->to('student-main');
        $this->dispatch('refresh')->to('student-aside');
        $this->reset();
    }

    public function addStudent()
    {
        $this->validateStep();

        $path = null;
        if ($this->photo) {
            $studentName = preg_replace('/\s+/', '', "{$this->last_name}_{$this->first_name}_{$this->middle_name}");
            $extension   = $this->photo->getClientOriginalExtension();
            $customName  = "{$studentName}_Profile.{$extension}";

            $path = $this->photo->storeAs('students', $customName, 'public');
        } else {
            if ($this->sex === 'male') {
                $path = 'default_profiles/default-male-student-pfp.png';
            } else {
                $path = 'default_profiles/default-female-student-pfp.png';
            }
        }

        $student = Student::create([
            'instructor_id' => Auth::user()->accountable->id,
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
            'grade_level'   => $this->grade_level,
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
        $this->permanent_barangay = null;
    }

    public function updatedCurrentMunicipal($value)
    {
        $this->current_barangays = $this->barangayData[$value] ?? [];
        $this->current_barangay = null;
    }

    public function render()
    {
        $this->barangayData = [
            "boac" => [
                "agot",
                "agumaymayan",
                "apitong",
                "balagasan",
                "balaring",
                "balimbing",
                "bangbang",
                "bantad",
                "bayanan",
                "binunga",
                "boi",
                "boton",
                "caganhao",
                "canat",
                "catubugan",
                "cawit",
                "daig",
                "duyay",
                "hinapulan",
                "ibaba",
                "isok i",
                "isok ii",
                "laylay",
                "libtangin",
                "lupac",
                "mahinhin",
                "malbog",
                "malindig",
                "maligaya",
                "mansiwat",
                "mercado",
                "murallon",
                "pawa",
                "poras",
                "pulang lupa",
                "puting buhangin",
                "san miguel",
                "tabi",
                "tabigue",
                "tampus",
                "tambunan",
                "tugos",
                "tumalum",
            ],
            "mogpog" => [
                "bintakay",
                "bocboc",
                "butansapa",
                "candahon",
                "capayang",
                "danao",
                "dulong bayan",
                "gitnang bayan",
                "hinadharan",
                "hinanggayon",
                "ino",
                "janagdong",
                "malayak",
                "mampaitan",
                "market site",
                "nangka i",
                "nangka ii",
                "silangan",
                "sumangga",
                "tabi",
                "tarug",
                "villa mendez",
            ],
            "gasan" => [
                "antipolo",
                "bachao ibaba",
                "bachao ilaya",
                "bacong-bacong",
                "bahi",
                "banot",
                "banuyo",
                "cabugao",
                "dawis",
                "ipil",
                "mangili",
                "masiga",
                "mataas na bayan",
                "pangi",
                "pinggan",
                "tabionan",
                "tiguion",
            ],
            "buenavista" => [
                "bagacay",
                "bagtingon",
                "bicas-bicas",
                "caigangan",
                "daykitin",
                "libas",
                "malbog",
                "sihi",
                "timbo",
                "tungib-lipata",
                "yook",
            ],
            "torrijos" => [
                "bangwayin",
                "bayakbakin",
                "bolo",
                "buangan",
                "cagpo",
                "dampulan",
                "kay duke",
                "macawayan",
                "malibago",
                "malinao",
                "marlangga",
                "matuyatuya",
                "poblacion",
                "poctoy",
                "sibuyao",
                "suha",
                "talawan",
                "tigwi",
            ],
            "santa cruz" => [
                "alobo",
                "angas",
                "aturan",
                "baguidbirin",
                "banahaw",
                "bangcuangan",
                "biga",
                "bolo",
                "bonliw",
                "botilao",
                "buyabod",
                "dating bayan",
                "devilla",
                "dolores",
                "haguimit",
                "ipil",
                "jolo",
                "kaganhao",
                "kalangkang",
                "kasily",
                "kilo-kilo",
                "kinyaman",
                "lamesa",
                "lapu-lapu",
                "lipata",
                "lusok",
                "maharlika",
                "maniwaya",
                "masaguisi",
                "matalaba",
                "mongpong",
                "pantayin",
                "pili",
                "poblacion",
                "punong",
                "san antonio",
                "tagum",
                "tamayo",
                "tawiran",
                "taytay",
            ],
        ];
        $this->municipalities = array_keys($this->barangayData);
        $this->specializations = Auth::user()->accountable->specializations;
        return view('livewire.student-add-modal');
    }
}
