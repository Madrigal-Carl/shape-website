<?php

namespace App\Livewire;

use FFMpeg\FFMpeg;
use App\Models\Feed;
use App\Models\Lesson;
use App\Models\Student;
use App\Models\Subject;
use Livewire\Component;
use App\Models\Curriculum;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use App\Models\GameActivity;
use App\Models\ClassActivity;
use Livewire\WithFileUploads;
use App\Models\ActivityLesson;
use FFMpeg\Coordinate\TimeCode;
use App\Models\CurriculumSubject;
use App\Models\LessonSubjectStudent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class LessonAddModal extends Component
{
    use WithFileUploads;
    public $subjects, $grade_levels, $students, $activities, $curriculums, $youtube_link;
    public $videos = [];
    public $f2fActivities = [];
    public $selected_f2f_activities = [];
    public $isOpen = false;
    public $lesson_name, $curriculum = '', $subject = '', $grade_level = '', $description;
    public $uploadedVideos = [], $selected_activities = [];
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

    public function resetFields()
    {
        $this->lesson_name = null;
        $this->subject = '';
        $this->grade_level = '';
        $this->subjects = collect();
        $this->students = collect();
        $this->curriculums = collect();
        $this->curriculum = '';
        $this->description = null;
        $this->videos = [];
        $this->uploadedVideos = [];
        $this->selected_activities = [];
        $this->f2fActivities = [];
        $this->selected_f2f_activities = [];
    }


    #[On('openModal')]
    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->resetFields();
        $this->dispatch('refresh')->to('lesson-main');
        $this->isOpen = false;
    }

    public function openActivityHub()
    {
        $this->dispatch('openModal', curriculumId: $this->curriculum, subjectId: $this->subject)->to('game-activity-hub');
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

    public function validateLesson(): bool
    {
        try {
            $this->validate([
                'lesson_name' => 'required|min:5|max:100',
                'grade_level' => 'required',
                'curriculum'  => 'required',
                'subject'     => 'required',
            ], [
                'lesson_name.required' => 'Lesson name is required.',
                'lesson_name.min'      => 'Lesson name must be at least 5 characters.',
                'lesson_name.max'      => 'Lesson name must not exceed 100 characters.',
                'grade_level.required' => 'Grade & Section is required.',
                'curriculum.required'  => 'Please select a curriculum.',
                'subject.required'     => 'Please select a subject.',
            ]);
        } catch (ValidationException $e) {
            $message = $e->validator->errors()->first();
            $this->dispatch('swal-toast', icon: 'error', title: $message);
            return false;
        }

        if ($this->students->isEmpty()) {
            $this->dispatch('swal-toast', icon: 'error', title: 'You must have at least one student to assign this lesson.');
            return false;
        }

        if (empty($this->selected_activities) && empty($this->selected_f2f_activities)) {
            $this->dispatch('swal-toast', icon: 'error', title: 'You must add at least one Game or Class activity.');
            return false;
        }

        if (empty($this->uploadedVideos)) {
            $this->dispatch('swal-toast', icon: 'error', title: 'Please upload at least one video or provide a YouTube link.');
            return false;
        }

        return true;
    }


    public function addLesson()
    {
        if (!$this->validateLesson()) {
            return;
        }

        $schoolYear = now()->schoolYear();
        if (!$schoolYear || $schoolYear->hasEnded()) {
            return $this->dispatch('swal-toast', icon: 'error', title: 'You cannot add a lesson. The current school year has already ended.');
        }

        $curriculumSubject = CurriculumSubject::where('curriculum_id', $this->curriculum)
            ->where('subject_id', $this->subject)
            ->first();

        $lesson = Lesson::create([
            'title' => $this->lesson_name,
            'description' => $this->description,
        ]);

        foreach ($this->students as $student) {
            LessonSubjectStudent::create([
                'curriculum_subject_id' => $curriculumSubject->id,
                'lesson_id' => $lesson->id,
                'student_id' => $student->id,
            ]);

            Feed::create([
                'notifiable_id' => $student->id,
                'group' => 'student',
                'title' => 'New Lesson Created',
                'message' => "A new lesson named '{$this->lesson_name}' has been to {$student->fullname}.",
            ]);
        }

        foreach ($this->uploadedVideos as $videoData) {
            $lesson->videos()->create([
                'url' => $videoData['video'],
                'title' => $videoData['title'],
                'thumbnail' => $videoData['thumbnail'],
            ]);
        }

        foreach ($this->selected_activities as $activity) {
            $lesson->activityLessons()->create([
                'activity_lessonable_id' => $activity->id,
                'activity_lessonable_type' => GameActivity::class,
            ]);
        }

        if (!empty($this->selected_f2f_activities)) {
            ActivityLesson::whereIn('activity_lessonable_id', $this->selected_f2f_activities)
                ->where('activity_lessonable_type', ClassActivity::class)
                ->update(['lesson_id' => $lesson->id]);
        }

        $this->dispatch('swal-toast', icon: 'success', title: 'Lesson added successfully!');
        return $this->closeModal();
    }

    #[On('addActivity')]
    public function addSelectedActivity($activity)
    {
        if (!collect($this->selected_activities)->pluck('id')->contains($activity['id'])) {
            $this->selected_activities[] = (object) $activity;
        }
    }

    public function removeActivity($index)
    {
        unset($this->selected_activities[$index]);
        $this->selected_activities = array_values($this->selected_activities);
    }

    public function updatedGradeLevel()
    {
        $this->curriculums = Curriculum::where('instructor_id', Auth::user()->accountable->id)->where('grade_level_id', $this->grade_level)->where('status', 'active')->get();
        $this->curriculum = '';
        $this->subject = '';
        $this->f2fActivities = [];
        $this->selected_f2f_activities = [];
        $this->subjects = collect();
        $this->students = collect();
    }

    public function updatedCurriculum()
    {
        $this->subject = '';
        $this->f2fActivities = [];
        $this->selected_f2f_activities = [];
        $this->subjects = Subject::whereHas('curriculumSubjects', function ($query) {
            $query->where('curriculum_id', $this->curriculum);
        })->get();
        $this->students = Auth::user()->accountable->students()
            ->where('status', 'active')
            ->whereHas('enrollments', function ($query) {
                $query->where('grade_level_id', $this->grade_level)
                    ->where('school_year_id', now()->schoolYear()->id);
            })
            ->whereIn(
                'disability_type',
                Curriculum::find($this->curriculum)
                    ->specializations()
                    ->pluck('name')
            )
            ->get();
    }

    public function updatedSubject()
    {
        if ($this->curriculum && $this->subject) {
            $curriculumSubject = CurriculumSubject::where('curriculum_id', $this->curriculum)
                ->where('subject_id', $this->subject)
                ->first();

            if ($curriculumSubject) {
                $this->f2fActivities = ClassActivity::where('curriculum_subject_id', $curriculumSubject->id)
                    ->where('instructor_id', Auth::user()->accountable->id)
                    ->get();
            } else {
                $this->f2fActivities = collect();
            }
        }
    }

    public function toggleF2fActivity($activityId)
    {
        if (in_array($activityId, $this->selected_f2f_activities)) {
            $this->selected_f2f_activities = array_values(
                array_diff($this->selected_f2f_activities, [$activityId])
            );
        } else {
            $this->selected_f2f_activities[] = $activityId;
        }
    }

    public function clearF2fActivities()
    {
        $this->selected_f2f_activities = [];
    }

    public function mount()
    {
        $this->activities = GameActivity::orderBy('id')->get();
        $this->grade_levels = Auth::user()->accountable->gradeLevels->sortBy('id')->values();

        $this->students = collect();
        $this->curriculums = collect();
        $this->subjects = collect();
    }

    public function render()
    {
        return view('livewire.lesson-add-modal');
    }
}
