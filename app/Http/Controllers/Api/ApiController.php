<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Feed;
use App\Models\Award;
use App\Models\Video;
use App\Models\Lesson;
use App\Models\Account;
use App\Models\Student;
use App\Models\Enrollment;
use App\Models\GameActivity;
use App\Models\StudentAward;
use Illuminate\Http\Request;
use App\Models\StudentActivity;
use App\Models\GameActivityLesson;
use App\Http\Controllers\Controller;
use App\Http\Resources\FeedResource;
use App\Models\LessonSubjectStudent;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\AwardResource;
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

    public function updateActivities(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|integer|exists:students,id',
            'activities' => 'required|array',
            'activities.*.activity_lesson_id' => 'required|integer',
            'activities.*.activity_lesson_type' => 'required|string',
            'activities.*.status' => 'required|in:unfinished,finished',
            'activities.*.created_at' => 'nullable|date',
            'activities.*.updated_at' => 'nullable|date',
        ]);

        $studentId = $validated['student_id'];
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

        return response()->json([
            'success' => true,
            'message' => 'Activities updated successfully.',
            'synced_ids' => $syncedIds,
        ]);
    }

    public function fetchStudentData(Request $request)
    {
        $schoolYear = now()->schoolYear();
        $currentQuarter = $schoolYear?->currentQuarter();
        $studentId = $request->input('student_id');
        $lastSyncTime = $request->input('last_sync_time');

        $currentEnrollment = null;
        if ($schoolYear) {
            $currentEnrollment = Enrollment::where('student_id', $studentId)
                ->where('school_year_id', $schoolYear->id)
                ->latest()
                ->first();
        }

        $status = $currentEnrollment?->status;


        $student = Student::where('id', $studentId)
            ->when($lastSyncTime, fn($q) => $q->where('updated_at', '>', Carbon::parse($lastSyncTime)->timezone('Asia/Manila')))
            ->first();

        $studentData = null;

        if ($student) {
            $studentData = [
                'id' => $student->id,
                'lrn' => $student->lrn,
                'path' => $student->path ? asset('storage/' . $student->path) : null,
                'first_name' => $student->first_name,
                'middle_name' => $student->middle_name,
                'last_name' => $student->last_name,
                'fullname' => $student->full_name,
                'sex' => $student->sex,
                'birth_date' => $student->birth_date instanceof Carbon
                    ? $student->birth_date->toDateString()
                    : $student->birth_date,
                'disability_type' => $student->disability_type,
                'support_need' => $student->support_need,
                'status' => $status,
                'created_at' => $student->created_at?->toDateTimeString(),
                'updated_at' => $student->updated_at?->toDateTimeString(),
            ];
        }

        // Lessons
        $lessonData = null;
        $videosData = null;
        $gameActivityLessonData = null;
        $gameActivityData = null;
        $studentActivityData = null;
        $feedsData = null;
        $studentAwardData = null;
        $newAwardData = null;

        if ($schoolYear && $currentQuarter) {
            $lessonIds = LessonSubjectStudent::where('student_id', $studentId)->pluck('lesson_id');

            // Lessons
            $lessons = Lesson::whereIn('id', $lessonIds)
                ->where('school_year_id', $schoolYear->id)
                ->when($lastSyncTime, fn($q) => $q->where('updated_at', '>', Carbon::parse($lastSyncTime)))
                ->get()
                ->filter(fn($lesson) => $lesson->isInQuarter($schoolYear, $currentQuarter));
            if ($lessons->isNotEmpty()) {
                $lessonData = LessonResource::collection($lessons);
            }

            // Videos
            $videos = Video::withTrashed()->whereIn('lesson_id', $lessonIds)
                ->when(
                    $lastSyncTime,
                    fn($q) =>
                    $q->where('created_at', '>', Carbon::parse($lastSyncTime))
                        ->orWhere('deleted_at', '>', Carbon::parse($lastSyncTime))
                )->get();
            if ($videos->isNotEmpty()) $videosData = VideoResource::collection($videos);

            // Game Activity Lessons
            $gal = GameActivityLesson::withTrashed()->whereIn('lesson_id', $lessonIds)
                ->when(
                    $lastSyncTime,
                    fn($q) =>
                    $q->where('created_at', '>', Carbon::parse($lastSyncTime))
                        ->orWhere('deleted_at', '>', Carbon::parse($lastSyncTime))
                )->get();
            if ($gal->isNotEmpty()) $gameActivityLessonData = GameActivityLessonResource::collection($gal);

            // Game Activities
            $newGALIds = $gal->pluck('id');
            $gameActivities = GameActivity::whereIn('game_activity_lesson_id', $newGALIds)->get();
            if ($gameActivities->isNotEmpty()) $gameActivityData = GameActivityResource::collection($gameActivities);

            // Student Activities
            $studentActivities = StudentActivity::withTrashed()->where('student_id', $studentId)
                ->when(
                    $lastSyncTime,
                    fn($q) =>
                    $q->where('updated_at', '>', Carbon::parse($lastSyncTime))
                        ->orWhere('deleted_at', '>', Carbon::parse($lastSyncTime))
                )->get();
            if ($studentActivities->isNotEmpty()) $studentActivityData = StudentActivityResource::collection($studentActivities);

            // Feeds
            $feedsQuery = Feed::where('notifiable_id', $studentId);
            if ($lastSyncTime) {
                $feedsQuery->where('created_at', '>', Carbon::parse($lastSyncTime));
            }
            $feeds = $feedsQuery->get();
            if ($feeds->isNotEmpty()) $feedsData = FeedResource::collection($feeds);

            // Student Awards
            $studentAwards = StudentAward::withTrashed()->where('student_id', $studentId)
                ->when(
                    $lastSyncTime,
                    fn($q) =>
                    $q->where('updated_at', '>', Carbon::parse($lastSyncTime))
                        ->orWhere('deleted_at', '>', Carbon::parse($lastSyncTime))
                )->get();
            if ($studentAwards->isNotEmpty()) $studentAwardData = StudentAwardResource::collection($studentAwards);

            // New Awards
            $newAwards = StudentAward::where('student_id', $studentId)
                ->when($lastSyncTime, fn($q) => $q->where('created_at', '>', Carbon::parse($lastSyncTime)))
                ->get();
            if ($newAwards->isNotEmpty()) {
                $newAwardees = Award::whereIn('student_award_id', $newAwards->pluck('id'))->get();
                if ($newAwardees->isNotEmpty()) $newAwardData = AwardResource::collection($newAwardees);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Data fetched successfully.',
            'student' => $studentData,
            'lessons' => $lessonData,
            'videos' => $videosData,
            'game_activity_lessons' => $gameActivityLessonData,
            'game_activities' => $gameActivityData,
            'student_activities' => $studentActivityData,
            'feeds' => $feedsData,
            'student_awards' => $studentAwardData,
            'awards' => $newAwardData,
        ]);
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
