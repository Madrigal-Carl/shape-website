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
    public $grade_levels = [], $specializations = [], $barangayData = [], $municipalities = [], $barangays = [];
    public $original = [];

    #[On('openModal')]
    public function openModal($id)
    {
        $this->student_id = $id;
        $this->step = 1;
        $this->isOpen = true;

        $student = Student::with(['profile','guardian','addresses','account'])->findOrFail($id);

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

        $permanent = $student->addresses->where('type','permanent')->first();
        $current   = $student->addresses->where('type','current')->first();
        if ($permanent) {
            $this->permanent_municipal = $permanent->municipality;
            $this->permanent_barangay  = $permanent->barangay;
        }
        if ($current) {
            $this->current_municipal = $current->municipality;
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

    public function render()
    {
        $this->barangayData = [
            "Boac" => [
                "Agot","Agumaymayan","Apitong","Balagasan","Balaring","Balimbing","Bangbang","Bantad","Bayanan",
                "Binunga","Boi","Boton","Caganhao","Canat","Catubugan","Cawit","Daig","Duyay","Hinapulan","Ibaba",
                "Isok I","Isok II","Laylay","Libtangin","Lupac","Mahinhin","Malbog","Malindig","Maligaya","Mansiwat",
                "Mercado","Murallon","Pawa","Poras","Pulang Lupa","Puting Buhangin","San Miguel","Tabi","Tabigue",
                "Tampus","Tambunan","Tugos","Tumalum",
            ],
            "Mogpog" => [
                "Bintakay","Bocboc","Butansapa","Candahon","Capayang","Danao","Dulong Bayan","Gitnang Bayan",
                "Hinadharan","Hinanggayon","Ino","Janagdong","Malayak","Mampaitan","Market Site","Nangka I","Nangka II",
                "Silangan","Sumangga","Tabi","Tarug","Villa Mendez",
            ],
            "Gasan" => [
                "Antipolo","Bachao Ibaba","Bachao Ilaya","Bacong-Bacong","Bahi","Banot","Banuyo","Cabugao","Dawis","Ipil",
                "Mangili","Masiga","Mataas na Bayan","Pangi","Pinggan","Tabionan","Tiguion",
            ],
            "Buenavista" => [
                "Bagacay","Bagtingon","Bicas-Bicas","Caigangan","Daykitin","Libas","Malbog","Sihi","Timbo","Tungib-Lipata","Yook",
            ],
            "Torrijos" => [
                "Bangwayin","Bayakbakin","Bolo","Buangan","Cagpo","Dampulan","Kay Duke","Macawayan","Malibago","Malinao",
                "Marlangga","Matuyatuya","Poblacion","Poctoy","Sibuyao","Suha","Talawan","Tigwi",
            ],
            "Santa Cruz" => [
                "Alobo","Angas","Aturan","Baguidbirin","Banahaw","Bangcuangan","Biga","Bolo","Bonliw","Botilao","Buyabod",
                "Dating Bayan","Devilla","Dolores","Haguimit","Ipil","Jolo","Kaganhao","Kalangkang","Kasily","Kilo-kilo",
                "Kinyaman","Lamesa","Lapu-lapu","Lipata","Lusok","Maharlika","Maniwaya","Masaguisi","Matalaba","Mongpong",
                "Pantayin","Pili","Poblacion","Punong","San Antonio","Tagum","Tamayo","Tawiran","Taytay",
            ],
        ];
        $this->municipalities = array_keys($this->barangayData);
        $this->grade_levels = Profile::orderBy('grade_level')->pluck('grade_level')->unique()->values()->toArray();

        $user = Account::with('accountable')->find(Auth::user()->id);
        $this->specializations = $user->accountable->specialization;

        return view('livewire.student-edit-modal');
    }
}
