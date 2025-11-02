<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Feed;
use App\Models\Award;
use App\Models\Video;
use App\Models\Lesson;
use App\Models\Account;
use App\Models\Student;
use App\Models\GameActivity;
use App\Models\StudentAward;
use Illuminate\Http\Request;
use App\Models\StudentActivity;
use App\Models\GameActivityLesson;
use App\Http\Controllers\Controller;
use App\Http\Resources\AwardResource;
use App\Http\Resources\FeedResource;
use App\Models\LessonSubjectStudent;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\VideoResource;
use App\Http\Resources\LessonResource;
use App\Http\Resources\StudentResource;
use App\Http\Resources\GameActivityResource;
use App\Http\Resources\StudentAwardResource;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\StudentActivityResource;
use App\Http\Resources\GameActivityLessonResource;

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

    public function syncAll(Request $request)
    {
        $schoolYear = now()->schoolYear();
        $currentQuarter = $schoolYear?->currentQuarter();

        try {
            $validated = $request->validate([
                'activities' => 'required|array',
                'student_id' => 'required|integer|exists:students,id',
                'activities.*.activity_lesson_id' => 'required|integer',
                'activities.*.activity_lesson_type' => 'required|string',
                'activities.*.status' => 'required|in:unfinished,finished',
                'activities.*.created_at' => 'nullable|date',
                'activities.*.updated_at' => 'nullable|date',
            ], [
                'activities.required' => 'Activities data is required.',
                'activities.array' => 'Activities must be an array.',
                'student_id.required' => 'Student ID is required.',
                'student_id.integer' => 'Student ID must be an integer.',
                'student_id.exists' => 'The specified student does not exist.',
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

        $studentId = $validated['student_id'];
        $lastSyncTime = $validated['last_sync_time'] ?? null;
        $syncedIds = [];

        foreach ($validated['activities'] as $activityData) {
            $activity = StudentActivity::where('student_id', $studentId)
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

        $lastSyncTime = $request->input('last_sync_time');

        $student = Student::where('id', $studentId)
            ->when($lastSyncTime, function ($q) use ($lastSyncTime) {
                $q->where('updated_at', '>', Carbon::parse($lastSyncTime));
            })
            ->first();
        $studentData = $student ? (new StudentResource($student)) : null;

        $lessonData = null;

        if ($schoolYear && $currentQuarter) {
            // Get all lesson IDs for the student
            $lessonIds = LessonSubjectStudent::where('student_id', $studentId)->pluck('lesson_id');

            // Get lessons in current quarter and optionally filter by last_sync_time
            $lessons = Lesson::whereIn('id', $lessonIds)
                ->where('school_year_id', $schoolYear->id)
                ->when($lastSyncTime, fn($q) => $q->where('updated_at', '>', Carbon::parse($lastSyncTime)))
                ->get()
                ->filter(fn($lesson) => $lesson->isInQuarter($schoolYear, $currentQuarter));
            if ($lessons->isNotEmpty()) {
                $lessonData = LessonResource::collection($lessons);
            }

            $videos = Video::withTrashed()->whereIn('lesson_id', $lessonIds)->when($lastSyncTime, function ($q) use ($lastSyncTime) {
                $q->where('created_at', '>', Carbon::parse($lastSyncTime))
                    ->orWhere('deleted_at', '>', Carbon::parse($lastSyncTime));
            })->get();
            $videoData = $videos->isNotEmpty()
                ? VideoResource::collection($videos)
                : null;

            $gameActivityLessons = GameActivityLesson::withTrashed()
                ->whereIn('lesson_id', $lessonIds)
                ->when($lastSyncTime, function ($q) use ($lastSyncTime) {
                    $q->where('created_at', '>', Carbon::parse($lastSyncTime))
                        ->orWhere('deleted_at', '>', Carbon::parse($lastSyncTime));
                })
                ->get();
            $gameActivityLessonData = $gameActivityLessons->isNotEmpty()
                ? GameActivityLessonResource::collection($gameActivityLessons)
                : null;

            // Game Activities: only for newly created Game Activity Lessons
            $newGameActivityLessons = GameActivityLesson::whereIn('lesson_id', $lessonIds)
                ->when($lastSyncTime, fn($q) => $q->where('created_at', '>', Carbon::parse($lastSyncTime)))
                ->get();
            $gameActivities = collect();
            if ($newGameActivityLessons->isNotEmpty()) {
                $lessonActivityIds = $newGameActivityLessons->pluck('id');
                $gameActivities = GameActivity::whereIn('game_activity_lesson_id', $lessonActivityIds)->get();
            }
            $gameActivityData = $gameActivities->isNotEmpty()
                ? GameActivityResource::collection($gameActivities)
                : null;

            $studentActivities = StudentActivity::withTrashed()->where('student_id', $studentId)
                ->when($lastSyncTime, fn($q) =>
                $q->where('updated_at', '>', Carbon::parse($lastSyncTime))
                    ->orWhere('deleted_at', '>', Carbon::parse($lastSyncTime)))
                ->get();
            $studentActivityData = $studentActivities->isNotEmpty()
                ? StudentActivityResource::collection($studentActivities)
                : null;

            $feeds = Feed::where('notifiable_id', $studentId)
                ->when($lastSyncTime, fn($q) => $q->where('created_at', '>', Carbon::parse($lastSyncTime)))
                ->get();
            $feedData = $feeds->isNotEmpty() ? FeedResource::collection($feeds) : null;

            $studentAwards = StudentAward::withTrashed()
                ->where('student_id', $studentId)
                ->when($lastSyncTime, fn($q) =>
                $q->where('updated_at', '>', Carbon::parse($lastSyncTime))
                    ->orWhere('deleted_at', '>', Carbon::parse($lastSyncTime)))
                ->get();
            $studentAwardData = $studentAwards->isNotEmpty()
                ? StudentAwardResource::collection($studentAwards)
                : null;

            $newAwards = StudentAward::where('student_id', $studentId)
                ->when($lastSyncTime, fn($q) => $q->where('created_at', '>', Carbon::parse($lastSyncTime)))
                ->get();
            $newAwardees = collect();
            if ($newAwards->isNotEmpty()) {
                $newAwardsId = $newAwards->pluck('id');
                $newAwardees = Award::whereIn('student_award_id', $newAwardsId)->get();
            }
            $newAwardData = $newAwardees->isNotEmpty()
                ? AwardResource::collection($newAwardees)
                : null;
        }

        return response()->json([
            'success' => true,
            'message' => 'Sync completed successfully.',
            'synced_ids' => $syncedIds,
            'student' => $studentData,
            'lessons' => $lessonData,
            'videos' => $videoData,
            'game_activity_lessons' => $gameActivityLessonData,
            'game_activities' => $gameActivityData,
            'student_activities' => $studentActivityData,
            'feeds' => $feedData,
            'student_awards' => $studentAwardData,
            'awards' => $newAwardData,
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
