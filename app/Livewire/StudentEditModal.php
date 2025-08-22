<?php

namespace App\Livewire;

use App\Models\Student;
use App\Models\Profile;
use App\Models\Account;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class StudentEditModal extends Component
{
    use WithFileUploads;

    public $step = 0, $isOpen = false, $student_id = null;
    public $photo, $lrn, $first_name, $middle_name, $last_name, $birthdate, $sex, $grade_level, $disability, $description;
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

        $this->photo = $student->path;
        $this->first_name = $student->first_name;
        $this->middle_name = $student->middle_name;
        $this->last_name  = $student->last_name;
        $this->birthdate  = $student->birth_date;
        $this->sex        = $student->sex;

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

    public function nextStep() { $this->step++; }
    public function previousStep() { if ($this->step > 1) $this->step--; }

    public function editStudent()
    {
        $student = Student::with(['profile','guardian','addresses','account'])->findOrFail($this->student_id);

        $changes = collect([
            'lrn'        => [$this->lrn, $this->original['lrn']],
            'first_name' => [$this->first_name, $this->original['first_name']],
            'middle_name'=> [$this->middle_name, $this->original['middle_name']],
            'last_name'  => [$this->last_name, $this->original['last_name']],
            'birthdate'  => [$this->birthdate, $this->original['birthdate']],
            'sex'        => [$this->sex, $this->original['sex']],
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

        if (empty($changes)) {
            $this->dispatch('swal-toast', icon:'info', title:'No changes detected.');
            return;
        }

        $student->update([
            'first_name' => $this->first_name,
            'middle_name'=> $this->middle_name,
            'last_name'  => $this->last_name,
            'birth_date' => $this->birthdate,
            'sex'        => $this->sex,
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
        $this->grade_levels = Profile::orderBy('grade_level')->pluck('grade_level')->unique()->values()->toArray();

        $user = Account::with('accountable')->find(Auth::user()->id);
        $this->specializations = $user->accountable->specialization;

        return view('livewire.student-edit-modal');
    }
}
