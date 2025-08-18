<?php

namespace App\Livewire;

use App\Models\Account;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class Authentication extends Component
{
    public $username;
    public $password;

    public function login()
    {
        try {
            $this->validate([
                'username'    => 'required|min:5|max:18',
                'password' => 'required|min:5|max:18|regex:/^[a-zA-Z0-9]+$/',
            ], [
                'username.required'    => 'Username is required.',
                'username.min'      => 'Username must be at least 5 characters.',
                'username.max'      => 'Username must not be more than 18 characters.',
                'password.required' => 'Password is required.',
                'password.min'      => 'Password must be at least 5 characters.',
                'password.max'      => 'Password must not be more than 18 characters.',
                'password.regex'    => 'Password must contain only letters and numbers (no special characters).',
            ]);
        } catch (ValidationException $e) {
            $message = $e->validator->errors()->first();
            return $this->dispatch('swal-toast', icon : 'error', title : $message);
        }

        $account = Account::with('accountable')->where('username', $this->username)->first();
        if (!$account || !Hash::check($this->password, $account->password)){
            return $this->dispatch('swal-toast', icon : 'error', title : 'Invalid credentials.');
        }

        request()->session()->regenerate();
        Auth::login($account);

        if ($account->accountable_type === 'App\Models\Instructor' && $account->accountable->status !== 'active') {
            Auth::logout();
            return $this->dispatch('swal-toast', icon : 'error', title : "You cannot login because your account is " . Auth::user()->status . ".");
        }

        if($account->accountable_type === 'App\Models\Student'){
            Auth::logout();
            return $this->dispatch('swal-toast', icon : 'error', title : 'Student accounts cannot log in here.');
        }

        if($account->accountable_type === 'App\Models\Instructor'){
            return redirect()->route('instructor.panel')->with('toast', [
                'icon' => 'success',
                'title' => 'You\'ve successfully logged in.'
            ]);
        }

        return redirect()->route('admin.panel')->with('toast', [
            'icon' => 'success',
            'title' => 'You\'ve successfully logged in.'
        ]);

    }
    public function render()
    {
        return view('livewire.authentication');
    }
}
