<?php

namespace App\Livewire;

use App\Models\Student;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StudentEditModal extends Component
{
    use WithFileUploads;

    public $step = 0, $isOpen = false, $student_id = null;
    public $photo, $currentPhoto, $lrn, $status = '', $first_name, $middle_name, $last_name, $birthdate, $sex, $grade_level, $disability, $description;
    public $province = "marinduque";
    public $permanent_barangay, $permanent_municipal, $current_barangay, $current_municipal;
    public $guardian_first_name, $guardian_middle_name, $guardian_last_name, $guardian_email, $guardian_phone;
    public $account_username, $account_password;
    public $grade_levels = [], $specializations = [], $barangayData = [], $municipalities = [], $permanent_barangays = [], $current_barangays = [];
    public $original = [];

    #[On('openModal')]
    public function openModal($id)
    {
        $this->student_id = $id;
        $this->step = 1;
        $this->isOpen = true;

        $student = Student::with(['profile','guardian','addresses','account','permanentAddress', 'currentAddress'])->findOrFail($id);

        $this->first_name = $student->first_name;
        $this->middle_name = $student->middle_name;
        $this->last_name  = $student->last_name;
        $this->birthdate  = $student->birth_date;
        $this->sex        = $student->sex;
        $this->status        = $student->status;
        $this->currentPhoto = $student->path;

        $this->lrn         = $student->profile->lrn;
        $this->grade_level = $student->profile->grade_level;
        $this->disability  = $student->profile->disability_type;
        $this->description = $student->profile->support_need;

        $this->guardian_first_name  = $student->guardian->first_name;
        $this->guardian_middle_name = $student->guardian->middle_name;
        $this->guardian_last_name   = $student->guardian->last_name;
        $this->guardian_email       = $student->guardian->email;
        $this->guardian_phone       = $student->guardian->phone_number;

        $permanent = $student->permanentAddress;
        $current = $student->currentAddress;
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

        $this->account_username = $student->account->username;

        $this->original = [
            'lrn'        => $this->lrn,
            'first_name' => $this->first_name,
            'middle_name'=> $this->middle_name,
            'last_name'  => $this->last_name,
            'birthdate'  => $this->birthdate,
            'sex'        => $this->sex,
            'status'        => $this->status,
            'grade_level'=> $this->grade_level,
            'disability' => $this->disability,
            'description'=> $this->description,
            'guardian_first_name' => $this->guardian_first_name,
            'guardian_middle_name'=> $this->guardian_middle_name,
            'guardian_last_name'  => $this->guardian_last_name,
            'guardian_email'      => $this->guardian_email,
            'guardian_phone'      => $this->guardian_phone,
            'permanent_municipal' => $this->permanent_municipal,
            'permanent_barangay'  => $this->permanent_barangay,
            'current_municipal'   => $this->current_municipal,
            'current_barangay'    => $this->current_barangay,
            'account_username'    => $this->account_username,
        ];
    }

    public function closeModal()
    {
        $this->dispatch('refresh')->to('student-main');
        $this->dispatch('refresh')->to('student-aside');
        $this->reset();
        $this->step = 0;
        $this->isOpen = false;
    }

    public function nextStep()
    {
        if ($this->validateEdit()) {
            $this->step++;
        }
    }

    public function previousStep() { if ($this->step > 1) $this->step--; }

    protected function validateEdit()
    {
        try {
            if ($this->step === 1) {
                $this->validate([
                    'photo'       => 'nullable|image|max:5120',
                    'lrn'         => 'required|digits:12',
                    'status'  => 'required',
                    'first_name'  => 'required',
                    'middle_name' => 'required',
                    'last_name'   => 'required',
                    'birthdate'   => 'required|date|before_or_equal:today',
                    'sex'         => 'required',
                    'grade_level' => 'required',
                    'disability'  => 'required',
                    'description' => 'nullable|max:255',
                ], [
                    'photo.image'             => 'The photo must be an image file.',
                    'photo.max'               => 'The photo size must not exceed 5MB.',
                    'lrn.required'            => 'The LRN field is required.',
                    'lrn.digits'              => 'The LRN must be exactly 12 digits.',
                    'status.required'            => 'The status is required.',
                    'first_name.required'     => 'The first name is required.',
                    'middle_name.required'    => 'The middle name is required.',
                    'last_name.required'      => 'The last name is required.',
                    'birthdate.required'      => 'The birthdate is required.',
                    'birthdate.date'          => 'The birthdate must be a valid date.',
                    'birthdate.before_or_equal' => 'The birthdate cannot be in the future.',
                    'sex.required'            => 'Please select a sex.',
                    'grade_level.required'    => 'The grade level is required.',
                    'disability.required'     => 'Please specify the disability.',
                    'description.max'         => 'The description is too long.',
                ]);
            }

            if ($this->step === 2) {
                $this->validate([
                    'permanent_municipal'  => 'required',
                    'permanent_barangay'   => 'required',
                    'current_municipal'    => 'required',
                    'current_barangay'     => 'required',
                    'guardian_first_name'  => 'required|max:35',
                    'guardian_middle_name' => 'nullable|max:35',
                    'guardian_last_name'   => 'required|max:35',
                    'guardian_email'       => 'required|email|unique:guardians,email,' . $this->student_id . ',student_id',
                    'guardian_phone'       => 'nullable|digits:10|unique:guardians,phone_number,' . $this->student_id . ',student_id',
                ], [
                    'permanent_municipal.required' => 'The permanent municipal is required.',
                    'permanent_barangay.required'  => 'The permanent barangay is required.',
                    'current_municipal.required'   => 'The current municipal is required.',
                    'current_barangay.required'    => 'The current barangay is required.',
                    'guardian_first_name.required' => 'The guardian first name is required.',
                    'guardian_first_name.max'      => 'The guardian first name is too long.',
                    'guardian_middle_name.max'     => 'The guardian middle name is too long.',
                    'guardian_last_name.required'  => 'The guardian last name is required.',
                    'guardian_last_name.max'       => 'The guardian last name is too long.',
                    'guardian_email.required'      => 'The guardian email is required.',
                    'guardian_email.email'         => 'The guardian email must be a valid email address.',
                    'guardian_email.unique'        => 'The guardian email already exists.',
                    'guardian_phone.digits'        => 'The guardian phone must be exactly 10 digits.',
                    'guardian_phone.unique'        => 'The guardian phone already exists.',
                ]);
            }

            if ($this->step === 3) {
                $this->validate([
                    'account_username' => 'required|min:5|max:18',
                    'account_password' => 'nullable|min:5|max:18|regex:/^[a-zA-Z0-9]+$/',
                ], [
                    'account_username.required' => 'Username is required.',
                    'account_username.min'      => 'Username must be at least 5 characters.',
                    'account_username.max'      => 'Username must not be more than 18 characters.',
                    'account_password.min'      => 'Password must be at least 5 characters.',
                    'account_password.max'      => 'Password must not be more than 18 characters.',
                    'account_password.regex'    => 'Password must contain only letters and numbers (no special characters).',
                ]);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            $message = $e->validator->errors()->first();
            $this->dispatch('swal-toast', icon: 'error', title: $message);
            return false;
        }

        return true;
    }

    public function editStudent()
    {
        if (!$this->validateEdit()) {
            return;
        }

        $student = Student::with(['profile','guardian','addresses','account'])->findOrFail($this->student_id);

        if ($this->photo instanceof UploadedFile) {
            if ($student->path && Storage::disk('public')->exists($student->path)) {
                Storage::disk('public')->delete($student->path);
            }

            $studentName = preg_replace('/\s+/', '', "{$this->last_name}_{$this->first_name}_{$this->middle_name}");
            $extension   = $this->photo->getClientOriginalExtension();
            $customName  = "{$studentName}_Profile.{$extension}";

            $path = $this->photo->storeAs('students', $customName, 'public');
            $student->path = $path;
        }

        $changes = collect([
            'lrn'        => [$this->lrn, $this->original['lrn']],
            'first_name' => [$this->first_name, $this->original['first_name']],
            'middle_name'=> [$this->middle_name, $this->original['middle_name']],
            'last_name'  => [$this->last_name, $this->original['last_name']],
            'birthdate'  => [$this->birthdate, $this->original['birthdate']],
            'sex'        => [$this->sex, $this->original['sex']],
            'status'        => [$this->sex, $this->original['status']],
            'grade_level'=> [$this->grade_level, $this->original['grade_level']],
            'disability' => [$this->disability, $this->original['disability']],
            'description'=> [$this->description, $this->original['description']],
            'guardian_first_name' => [$this->guardian_first_name, $this->original['guardian_first_name']],
            'guardian_middle_name'=> [$this->guardian_middle_name, $this->original['guardian_middle_name']],
            'guardian_last_name'  => [$this->guardian_last_name, $this->original['guardian_last_name']],
            'guardian_email'      => [$this->guardian_email, $this->original['guardian_email']],
            'guardian_phone'      => [$this->guardian_phone, $this->original['guardian_phone']],
            'permanent_municipal' => [$this->permanent_municipal, $this->original['permanent_municipal']],
            'permanent_barangay'  => [$this->permanent_barangay, $this->original['permanent_barangay']],
            'current_municipal'   => [$this->current_municipal, $this->original['current_municipal']],
            'current_barangay'    => [$this->current_barangay, $this->original['current_barangay']],
            'account_username'    => [$this->account_username, $this->original['account_username']],
        ])
        ->filter(fn($pair) => $pair[0] !== $pair[1])
        ->map(fn($pair) => $pair[0])
        ->toArray();

        $photoChanged = $this->photo instanceof UploadedFile;
        if (!$photoChanged && empty($changes)) {
            $this->dispatch('swal-toast', icon:'info', title:'No changes detected.');
            return;
        }

        $student->update([
            'first_name' => $this->first_name,
            'middle_name'=> $this->middle_name,
            'last_name'  => $this->last_name,
            'birth_date' => $this->birthdate,
            'sex'        => $this->sex,
            'status'        => $this->status,
        ]);

        $student->profile->update([
            'lrn' => $this->lrn,
            'grade_level' => $this->grade_level,
            'disability_type' => $this->disability,
            'support_need' => $this->description,
        ]);

        $student->guardian->update([
            'first_name' => $this->guardian_first_name,
            'middle_name'=> $this->guardian_middle_name,
            'last_name'  => $this->guardian_last_name,
            'email'      => $this->guardian_email,
            'phone_number'=> $this->guardian_phone,
        ]);

        $student->addresses()->where('type','permanent')->update([
            'municipality' => $this->permanent_municipal,
            'barangay'     => $this->permanent_barangay,
        ]);
        $student->addresses()->where('type','current')->update([
            'municipality' => $this->current_municipal,
            'barangay'     => $this->current_barangay,
        ]);

        $student->account->update([
            'username' => $this->account_username,
            'password' => $this->account_password ?: $student->account->password,
        ]);

        $this->dispatch('swal-toast', icon:'success', title:'Student has been updated successfully.');
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
                "agot","agumaymayan","apitong","balagasan","balaring","balimbing","bangbang","bantad","bayanan",
                "binunga","boi","boton","caganhao","canat","catubugan","cawit","daig","duyay","hinapulan","ibaba",
                "isok i","isok ii","laylay","libtangin","lupac","mahinhin","malbog","malindig","maligaya","mansiwat",
                "mercado","murallon","pawa","poras","pulang lupa","puting buhangin","san miguel","tabi","tabigue",
                "tampus","tambunan","tugos","tumalum",
            ],
            "mogpog" => [
                "bintakay","bocboc","butansapa","candahon","capayang","danao","dulong bayan","gitnang bayan",
                "hinadharan","hinanggayon","ino","janagdong","malayak","mampaitan","market site","nangka i","nangka ii",
                "silangan","sumangga","tabi","tarug","villa mendez",
            ],
            "gasan" => [
                "antipolo","bachao ibaba","bachao ilaya","bacong-bacong","bahi","banot","banuyo","cabugao","dawis","ipil",
                "mangili","masiga","mataas na bayan","pangi","pinggan","tabionan","tiguion",
            ],
            "buenavista" => [
                "bagacay","bagtingon","bicas-bicas","caigangan","daykitin","libas","malbog","sihi","timbo","tungib-lipata","yook",
            ],
            "torrijos" => [
                "bangwayin","bayakbakin","bolo","buangan","cagpo","dampulan","kay duke","macawayan","malibago","malinao",
                "marlangga","matuyatuya","poblacion","poctoy","sibuyao","suha","talawan","tigwi",
            ],
            "santa cruz" => [
                "alobo","angas","aturan","baguidbirin","banahaw","bangcuangan","biga","bolo","bonliw","botilao","buyabod",
                "dating bayan","devilla","dolores","haguimit","ipil","jolo","kaganhao","kalangkang","kasily","kilo-kilo",
                "kinyaman","lamesa","lapu-lapu","lipata","lusok","maharlika","maniwaya","masaguisi","matalaba","mongpong",
                "pantayin","pili","poblacion","punong","san antonio","tagum","tamayo","tawiran","taytay",
            ],
        ];
        $this->municipalities = array_keys($this->barangayData);
        $this->grade_levels = Student::with('profile')
            ->get()
            ->pluck('profile.grade_level')
            ->filter()
            ->unique()
            ->sort()
            ->values()
            ->toArray();

        $this->specializations = Auth::user()->accountable->specializations;

        return view('livewire.student-edit-modal');
    }
}
