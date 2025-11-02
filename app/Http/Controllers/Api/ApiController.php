<?php

namespace App\Http\Controllers\Api;

use App\Models\Account;
use Illuminate\Http\Request;
use App\Models\StudentActivity;
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
            'data' => new StudentResource($student),
        ], 200);
    }

    public function syncActivity(Request $request)
    {
        try {
            $validated = $request->validate([
                'activities' => 'required|array',
                'activities.*.student_id' => 'required|integer|exists:students,id',
                'activities.*.activity_lesson_id' => 'required|integer',
                'activities.*.activity_lesson_type' => 'required|string',
                'activities.*.status' => 'required|in:unfinished,finished',
                'activities.*.created_at' => 'nullable|date',
                'activities.*.updated_at' => 'nullable|date',
            ], [
                'activities.required' => 'Activities data is required.',
                'activities.array' => 'Activities must be an array.',
                'activities.*.student_id.required' => 'Student ID is required.',
                'activities.*.student_id.integer' => 'Student ID must be an integer.',
                'activities.*.student_id.exists' => 'The specified student does not exist.',
                'activities.*.activity_lesson_id.required' => 'Activity lesson ID is required.',
                'activities.*.activity_lesson_id.integer' => 'Activity lesson ID must be an integer.',
                'activities.*.activity_lesson_type.required' => 'Activity lesson type is required.',
                'activities.*.activity_lesson_type.string' => 'Activity lesson type must be a string.',
                'activities.*.status.required' => 'Status is required.',
                'activities.*.status.in' => 'Status must be either unfinished or finished.',
                'activities.*.created_at.date' => 'Created at must be a valid date.',
                'activities.*.updated_at.date' => 'Updated at must be a valid date.',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->validator->errors()->first(),
            ], 422);
        }

        $syncedIds = [];

        foreach ($validated['activities'] as $activityData) {
            $activity = StudentActivity::where('student_id', $activityData['student_id'])
                ->where('activity_lesson_id', $activityData['activity_lesson_id'])
                ->where('activity_lesson_type', $activityData['activity_lesson_type'])
                ->first();

            if ($activity) {
                $activity->update([
                    'status' => $activityData['status'],
                    'created_at' => $activityData['created_at'] ?? $activity->created_at,
                    'updated_at' => $activityData['updated_at'] ?? $activity->updated_at,
                ]);

                $syncedIds[] = $activity->id;
            }
        }

        return response()->json([
            'success' => true,
            'message' => count($syncedIds)
                ? 'Existing activities updated successfully.'
                : 'No matching activities were found to update.',
            'synced_ids' => $syncedIds,
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
