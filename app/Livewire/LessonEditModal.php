<?php

namespace App\Livewire;

use FFMpeg\FFMpeg;
use App\Models\Lesson;
use App\Models\Student;
use App\Models\Subject;
use Livewire\Component;
use App\Models\Activity;
use App\Models\Curriculum;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use FFMpeg\Coordinate\TimeCode;
use App\Models\CurriculumSubject;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class LessonEditModal extends Component
{
    use WithFileUploads;
    public $subjects, $grade_levels, $students, $activities, $curriculums, $youtube_link, $selected_student = '', $curriculum_id, $subject_id;
    public $videos = [];
    public $lesson_id = null;
    public $isOpen = false;
    public $lesson_name, $curriculum = '', $subject = '', $grade_level = '', $description;
    public $uploadedVideos = [], $selected_activities = [], $selected_students = [];
    public $original = [];
    public $student_search = '';

    public function getFilteredStudentsProperty()
    {
        return $this->students
            ->when($this->student_search, function ($q) {
                return $q->filter(function ($student) {
                    return str_contains(
                        strtolower($student->full_name),
                        strtolower($this->student_search)
                    );
                });
            });
    }

    public function toggleStudent($studentId)
    {
        if (in_array($studentId, $this->selected_students)) {
            $this->selected_students = array_values(
                array_diff($this->selected_students, [$studentId])
            );
        } else {
            $this->selected_students[] = $studentId;
        }
    }

    public function clearStudents()
    {
        $this->selected_students = [];
    }


    #[On('openModal')]
    public function openModal($id)
    {
        $this->lesson_id = $id;
        $this->isOpen = true;

        $lesson = Lesson::with('students', 'videos', 'activityLessons.activity.specializations', 'lessonSubjectStudents.curriculumSubject.curriculum', 'lessonSubjectStudents.curriculumSubject.subject')->find($id);
        $this->lesson_name = $lesson->title;
        $this->grade_level = $lesson->lessonSubjectStudents->first()->curriculumSubject->curriculum->grade_level;
        $this->curriculum = $lesson->lessonSubjectStudents->first()->curriculumSubject->curriculum->name;
        $this->curriculum_id = $lesson->lessonSubjectStudents->first()->curriculumSubject->curriculum->id;
        $this->subject = $lesson->lessonSubjectStudents->first()->curriculumSubject->subject->name;
        $this->subject_id = $lesson->lessonSubjectStudents->first()->curriculumSubject->subject->id;
        $this->selected_students = $lesson->students->pluck('id')->toArray();
        $this->description = $lesson->description;

        $this->students = Auth::user()->accountable->students()
        ->where('status', 'active')
        ->whereHas('enrollments', function ($query) {
            $query->where('grade_level', $this->grade_level)
                ->where('school_year', now()->schoolYear());
        })
        ->whereIn(
            'disability_type',
            Curriculum::find($this->curriculum_id)
                ->specializations()
                ->pluck('name')
        )
        ->get();

        $this->uploadedVideos = $lesson->videos->map(function ($video) {
            return [
                'video'     => $video->url,
                'thumbnail' => $video->thumbnail,
                'title'     => $video->title,
            ];
        })->toArray();

        $this->selected_activities = $lesson->activityLessons->map(function ($al) {
            return (object) [
                'id'              => $al->activity->id,
                'name'            => $al->activity->name,
                'path'            => $al->activity->path,
                'specializations' => collect($al->activity->specializations ?? [])->pluck('name')->toArray(),
            ];
        })->toArray();

        $this->original = [
            'lesson_name'   => $this->lesson_name,
            'description'   => $this->description,
            'grade_level'   => $this->grade_level,
            'curriculum'    => $this->curriculum,
            'subject'       => $this->subject,
            'students'      => $this->selected_students,
            'videos'        => $this->uploadedVideos,
            'activities'    => $this->selected_activities,
        ];
    }

    public function closeModal()
    {
        $this->dispatch('refresh')->to('lesson-main');
        $this->isOpen = false;
    }

    public function openActivityHub()
    {
        $this->dispatch('openModal')->to('activity-hub');
    }

    #[On('addActivity')]
    public function addSelectedActivity($activity)
    {
        // Check if activity is already added
        if (!collect($this->selected_activities)->pluck('id')->contains($activity['id'])) {
            $this->selected_activities[] = (object) [
                'id' => $activity['id'],
                'name' => $activity['name'],
                'path' => $activity['path'],
                'specializations' => collect($activity['specializations'] ?? [])->pluck('name')->toArray(),
            ];
        }
    }

    public function removeActivity($index)
    {
        unset($this->selected_activities[$index]);
        $this->selected_activities = array_values($this->selected_activities);
    }

    public function updatedSelectedStudent($value)
    {
        if ($value && !in_array($value, $this->selected_students)) {
            $this->selected_students[] = $value;
        }
    }

    public function removeStudent($index)
    {
        unset($this->selected_students[$index]);
        $this->selected_students = array_values($this->selected_students);
    }

    public function updatedVideos()
    {
        foreach ($this->videos as $video) {
            if (str_starts_with($video->getMimeType(), 'video/')) {

                $videoName = Str::random(10) . '.' . $video->getClientOriginalExtension();
                $videoPath = $video->storeAs('videos', $videoName, 'public');

                Storage::makeDirectory('public/thumbnails');

                $thumbnailName = Str::random(10) . '.jpg';
                $thumbnailPath = storage_path('app/public/thumbnails/' . $thumbnailName);

                $ffmpeg = FFMpeg::create();
                $videoFFMpeg = $ffmpeg->open(storage_path('app/public/' . $videoPath));
                $frame = $videoFFMpeg->frame(TimeCode::fromSeconds(2));
                $frame->save($thumbnailPath);

                $this->uploadedVideos[] = [
                    'video' => 'storage/' . $videoPath,
                    'thumbnail' => 'storage/thumbnails/' . $thumbnailName,
                    'title' => pathinfo($video->getClientOriginalName(), PATHINFO_FILENAME)
                ];
            } else {
                $this->dispatch('swal-toast', icon: 'error', title: 'File should be a video.');
            }
        }
        $this->videos = [];
    }

    public function addYoutubeVideo()
    {
        $url = trim($this->youtube_link);

        if (empty($url)) {
            return $this->dispatch('swal-toast', icon: 'error', title: 'Please enter a YouTube link.');
        }

        if (!filter_var($url, FILTER_VALIDATE_URL) || (!str_contains($url, 'youtube.com') && !str_contains($url, 'youtu.be'))) {
            return $this->dispatch('swal-toast', icon: 'error', title: 'Invalid YouTube link.');
        }

        try {
            $videoId = $this->getYoutubeId($url);

            if (!$videoId) {
                return $this->dispatch('swal-toast', icon: 'error', title: 'Cannot extract YouTube video ID.');
            }

            $oembedUrl = "https://www.youtube.com/oembed?url={$url}&format=json";
            $data = json_decode(file_get_contents($oembedUrl), true);

            $this->uploadedVideos[] = [
                'video' => $url,
                'thumbnail' => "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg",
                'title' => $data['title'] ?? 'YouTube Video',
            ];

            $this->youtube_link = '';
        } catch (\Exception $e) {
            $this->dispatch('swal-toast', icon: 'error', title: 'Could not fetch video info.');
        }
    }

    private function getYoutubeId($url)
    {
        preg_match(
            '/(?:youtube\.com\/(?:watch\?v=|shorts\/)|youtu\.be\/)([^\?&]+)/',
            $url,
            $matches
        );

        return $matches[1] ?? null;
    }

    public function removeVideo($index)
    {
        unset($this->uploadedVideos[$index]);
        $this->uploadedVideos = array_values($this->uploadedVideos);
    }

    private function validateLesson()
    {
        try {
            $this->validate([
                'lesson_name'        => 'required|min:5|max:100',
                'grade_level'        => 'required',
                'curriculum_id'      => 'required',
                'subject_id'         => 'required',
                'selected_activities'=> 'required',
            ], [
                'lesson_name.required' => 'Lesson name is required.',
                'lesson_name.min'      => 'Lesson name must be at least 5 characters.',
                'lesson_name.max'      => 'Lesson name must not exceed 100 characters.',
                'grade_level.required' => 'Grade & Section is required.',
                'curriculum_id.required' => 'Please select a curriculum.',
                'subject_id.required'  => 'Please select a subject.',
                'selected_activities.required' => 'You must add at least one activity.',
            ]);
        } catch (ValidationException $e) {
            $message = $e->validator->errors()->first();
            $this->dispatch('swal-toast', icon: 'error', title: $message);
            return false;
        }

        if (empty($this->uploadedVideos)) {
            $this->dispatch('swal-toast', icon: 'error', title: 'Please upload at least one video or provide a YouTube link.');
            return false;
        }

        return true;
    }

    public function editLesson()
    {
        if (!$this->validateLesson()) {
            return;
        }

        $current = [
            'lesson_name'   => $this->lesson_name,
            'description'   => $this->description,
            'grade_level'   => $this->grade_level,
            'curriculum'    => $this->curriculum,
            'subject'       => $this->subject,
            'students'      => $this->selected_students,
            'videos'        => $this->uploadedVideos,
            'activities'    => $this->selected_activities,
        ];

        if ($current == $this->original) {
            $this->dispatch('swal-toast', icon: 'info', title: 'No changes detected.');
            return;
        }

        $lesson = Lesson::findOrFail($this->lesson_id);
        $lesson->update([
            'title'       => $this->lesson_name,
            'description' => $this->description,
        ]);

        // Update students
        $lesson->lessonSubjectStudents()->delete();
        $curriculumSubject = CurriculumSubject::where('subject_id', $this->subject_id)
            ->where('curriculum_id', $this->curriculum_id)
            ->first();
        $studentsToAssign = empty($this->selected_students)
            ? $this->students
            : Student::whereIn('id', $this->selected_students)->get();

        foreach ($studentsToAssign as $student) {
            $lesson->lessonSubjectStudents()->create([
                'student_id' => $student->id,
                'curriculum_subject_id' => $curriculumSubject->id,
                'lesson_id'  => $lesson->id,
            ]);
        }

        // Update videos
        $lesson->videos()->delete();
        foreach ($this->uploadedVideos as $videoData) {
            $lesson->videos()->create([
                'url'       => $videoData['video'],
                'title'     => $videoData['title'],
                'thumbnail' => $videoData['thumbnail'],
            ]);
        }

        // Update activities
        $lesson->activityLessons()->delete();
        foreach ($this->selected_activities as $activity) {
            $lesson->activityLessons()->create([
                'activity_id' => $activity->id,
            ]);
        }

        $this->dispatch('swal-toast', icon: 'success', title: 'Lesson updated successfully!');
        $this->closeModal();
    }

    public function updatedGradeLevel()
    {
        $this->curriculums = Curriculum::where('instructor_id', Auth::id())->where('grade_level', $this->grade_level)->where('status', 'active')->get();
        if (!empty($this->selected_students)) {
            $this->selected_students = [];
        }
        $this->curriculum = '';
        $this->subject = '';
        $this->selected_student = '';
        $this->subjects = collect();
        $this->students = collect();
    }

    public function updatedCurriculum()
    {
        if ($this->curriculum != '') {
            if (!empty($this->selected_students)) {
                $this->selected_students = [];
            }
            $this->subject = '';
            $this->selected_student = '';
            $this->subjects = Subject::whereHas('curriculumSubjects', function ($query) {
                $query->where('curriculum_id', $this->curriculum_id);
            })->get();
            $this->students = Auth::user()->accountable->students()
            ->where('status', 'active')
            ->whereHas('enrollments', function ($query) {
                $query->where('grade_level', $this->grade_level)
                    ->where('school_year', now()->schoolYear());
            })
            ->whereIn(
                'disability_type',
                Curriculum::find($this->curriculum)
                    ->specializations()
                    ->pluck('name')
            )
            ->get();
        }
    }

    public function render()
    {
        $this->activities = Activity::orderBy('id')->get();
        $this->grade_levels = Curriculum::where('instructor_id', Auth::id())
            ->where('status', 'active')
            ->orderBy('grade_level')
            ->pluck('grade_level')
            ->unique()
            ->values()
            ->toArray();
        $this->curriculums = Curriculum::where('instructor_id', Auth::id())->where('grade_level', $this->grade_level)->where('status', 'active')->get();
        $this->subjects = Subject::whereHas('curriculumSubjects', function ($query) {
            $query->where('curriculum_id', $this->curriculum_id);
        })->get();
        return view('livewire.lesson-edit-modal');
    }
}
