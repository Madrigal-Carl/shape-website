<?php

namespace App\Http\Controllers\Api;

use App\Models\Account;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\StudentResource;
use Illuminate\Validation\ValidationException;

class ApiController extends Controller
{
    public function loginStudent(Request $request)
    {
        try {
            $data = $request->validate([
                'username' => 'required|min:5|max:18',
                'password' => 'required|min:5|max:18|regex:/^[a-zA-Z0-9]+$/',
            ], [
                'username.required' => 'Username is required.',
                'username.min'      => 'Username must be at least 5 characters.',
                'username.max'      => 'Username must not be more than 18 characters.',
                'password.required' => 'Password is required.',
                'password.min'      => 'Password must be at least 5 characters.',
                'password.max'      => 'Password must not be more than 18 characters.',
                'password.regex'    => 'Password must contain only letters and numbers (no special characters).',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->validator->errors()->first(),
            ], 422);
        }

        $account = Account::where('username', $data['username'])->first();

        if (!$account || !Hash::check($data['password'], $account->password)) {
            return response()->json(['success' => false, 'message' => 'Invalid credentials.'], 401);
        }

        if ($account->accountable_type !== 'App\Models\Student') {
            return response()->json(['success' => false, 'message' => 'Only student accounts can login here.'], 403);
        }

        $account->load(['accountable.enrollments']);

        // Only allow students enrolled in the current school year
        $currentSchoolYear = now()->schoolYear()?->id;
        $isEnrolled = $account->accountable->enrollments->contains('school_year_id', $currentSchoolYear);

        if (!$isEnrolled) {
            return response()->json(['success' => false, 'message' => 'Student is not enrolled for the current school year.'], 403);
        }

        $student = $account->accountable;

        $token = $account->createToken('mobile')->plainTextToken;

        return response()->json([
            'success' => true,
            'token' => $token,
            'student' => new StudentResource($student),
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully.'
        ], 200);
    }
}
