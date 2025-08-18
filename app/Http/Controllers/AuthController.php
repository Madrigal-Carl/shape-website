<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function authentication()
    {
        return view('authentication');
    }

    public function instructorPanel()
    {
        return view('instructor.instructor_panel');
    }

    public function adminPanel()
    {
        return view('admin.admin_panel');
    }
}
