<?php

namespace App\Livewire;

use FFMpeg\FFMpeg;
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
use FFMpeg\Coordinate\TimeCode;
use App\Models\CurriculumSubject;
use App\Models\GameActivityLesson;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class LessonEditModal extends Component
{
    use WithFileUploads;
    public $subjects, $grade_levels, $students, $activities, $curriculums, $youtube_link, $curriculum_id, $subject_id;
    public $videos = [];
    public $f2fActivities = [];
    public $selected_f2f_activities = [];
    public $lesson_id = null;
    public $isOpen = false;
    public $lesson_name, $grade_level = '', $description, $lesson;
    public $uploadedVideos = [], $selected_activities = [];
    public $original = [];
    public $student_search = '', $activity_search = '';

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

    #[On('openModal')]
    public function openModal($id)
    {
        $this->lesson_id = $id;
        $this->isOpen = true;

        $this->lesson = Lesson::with('students', 'videos', 'lessonSubjectStudents.curriculumSubject.curriculum', 'lessonSubjectStudents.curriculumSubject.subject')->find($id);
        $this->lesson_name = $this->lesson->title;
        $this->grade_level = $this->lesson->lessonSubjectStudents->first()->curriculumSubject->curriculum->grade_level_id;
        $this->curriculum_id = $this->lesson->lessonSubjectStudents->first()->curriculumSubject->curriculum->id;
        $this->subject_id = $this->lesson->lessonSubjectStudents->first()->curriculumSubject->subject->id;
        $this->description = $this->lesson->description;

        $this->students = $this->lesson->students;

        $this->uploadedVideos = $this->lesson->videos->map(function ($video) {
            return [
                'video'     => $video->url,
                'thumbnail' => $video->thumbnail,
                'title'     => $video->title,
            ];
        })->toArray();

        $this->selected_activities = $this->lesson->gameActivityLessons()
            ->with('gameActivity')
            ->get()
            ->map(function ($gal) {
                $activity = $gal->gameActivity;
                return (object) [
                    'id' => $activity->id,
                    'name' => $activity->name,
                    'path' => $activity->path,
                    'specializations' => collect($activity->specializations ?? [])->pluck('name')->toArray(),
                ];
            })
            ->toArray();

        $this->selected_f2f_activities = $this->lesson->classActivities()
            ->pluck('id')
            ->toArray();

        if ($this->curriculum_id && $this->subject_id) {
            $curriculumSubject = CurriculumSubject::where('curriculum_id', $this->curriculum_id)
                ->where('subject_id', $this->subject_id)
                ->first();

            if ($curriculumSubject) {
                $this->f2fActivities = ClassActivity::where('curriculum_subject_id', $curriculumSubject->id)
                    ->where('instructor_id', Auth::user()->accountable->id)
                    ->where(function ($query) {
                        $query->whereNull('lesson_id')
                            ->orWhereIn('id', $this->selected_f2f_activities);
                    })
                    ->when($this->activity_search, function ($query) {
                        $query->where(function ($q) {
                            $q->where('name', 'like', '%' . $this->activity_search . '%');
                        });
                    })
                    ->orderBy('created_at', 'desc')
                    ->get();
            }
        }

        $this->original = [
            'lesson_name'   => $this->lesson_name,
            'description'   => $this->description,
            'grade_level'   => $this->grade_level,
            'curriculum'    => $this->curriculum_id,
            'subject'       => $this->subject_id,
            'students'      => $this->students,
            'videos'        => $this->uploadedVideos,
            'activities'    => $this->selected_activities,
            'f2f_activities' => $this->selected_f2f_activities,
        ];
    }

    public function closeModal()
    {
        $this->dispatch('refresh')->to('lesson-main');
        $this->isOpen = false;
    }

    public function openActivityHub()
    {
        $this->dispatch('openModal', curriculumId: $this->curriculum_id, subjectId: $this->subject_id)->to('game-activity-hub');
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
                    'video' => $videoPath,
                    'thumbnail' => 'thumbnails/' . $thumbnailName,
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

            // ✅ Delete the last YouTube thumbnail if it exists
            if (!empty($this->uploadedVideos)) {
                $lastVideo = end($this->uploadedVideos);
                $lastThumbnail = $lastVideo['thumbnail'] ?? null;

                // Ensure it's a YouTube link (not uploaded video) and not empty
                if ($lastThumbnail && str_contains($lastVideo['video'], 'youtube.com') || str_contains($lastVideo['video'], 'youtu.be')) {
                    Storage::disk('public')->delete($lastThumbnail);
                }
            }

            // Download and save YouTube thumbnail locally
            $thumbnailUrl = "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg";
            $thumbnailContents = file_get_contents($thumbnailUrl);

            if ($thumbnailContents === false) {
                return $this->dispatch('swal-toast', icon: 'error', title: 'Could not download YouTube thumbnail.');
            }

            // Save thumbnail file
            $thumbnailName = Str::random(10) . '.jpg';
            $thumbnailPath = 'thumbnails/' . $thumbnailName;

            Storage::disk('public')->put($thumbnailPath, $thumbnailContents);

            // Add video entry
            $this->uploadedVideos[] = [
                'video' => $url,
                'thumbnail' => $thumbnailPath,
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
            ], [
                'lesson_name.required' => 'Lesson name is required.',
                'lesson_name.min'      => 'Lesson name must be at least 5 characters.',
                'lesson_name.max'      => 'Lesson name must not exceed 100 characters.',
                'grade_level.required' => 'Grade & Section is required.',
                'curriculum_id.required' => 'Please select a curriculum.',
                'subject_id.required'  => 'Please select a subject.',
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

    public function editLesson()
    {
        if (!$this->validateLesson()) {
            return;
        }

        $current = [
            'lesson_name'   => $this->lesson_name,
            'description'   => $this->description,
            'grade_level'   => $this->grade_level,
            'curriculum'    => $this->curriculum_id,
            'subject'       => $this->subject_id,
            'students'      => $this->students,
            'videos'        => $this->uploadedVideos,
            'activities'    => $this->selected_activities,
            'f2f_activities' => $this->selected_f2f_activities,
        ];

        if ($current == $this->original) {
            $this->closeModal();
            $this->dispatch('swal-toast', icon: 'info', title: 'No changes have been made.');
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

        foreach ($this->students as $student) {
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
        $lesson->gameActivityLessons()->each(function ($gameActivityLesson) {
            $gameActivityLesson->studentActivities()->delete();
        });
        $lesson->gameActivityLessons()->delete();
        foreach ($this->selected_activities as $activity) {
            $existing = $lesson->gameActivityLessons()
                ->withTrashed()
                ->where('game_activity_id', $activity->id)
                ->first();

            if ($existing) {
                $existing->restore();
                $gameActivityLesson = $existing;
            } else {
                $gameActivityLesson = $lesson->gameActivityLessons()->create([
                    'game_activity_id' => $activity->id,
                ]);
            }

            foreach ($this->students as $student) {
                $existingStudentActivity = $gameActivityLesson->studentActivities()
                    ->withTrashed()
                    ->where('student_id', $student->id)
                    ->first();

                if ($existingStudentActivity) {
                    $existingStudentActivity->restore();
                } else {
                    $gameActivityLesson->studentActivities()->create([
                        'student_id' => $student->id,
                    ]);
                }
            }
        }

        $lesson->classActivities()->update(['lesson_id' => null]);
        ClassActivity::whereIn('id', $this->selected_f2f_activities)
            ->update(['lesson_id' => $lesson->id]);

        $this->dispatch('swal-toast', icon: 'success', title: 'Lesson updated successfully!');
        $this->closeModal();
    }

    public function updatedGradeLevel()
    {
        $this->curriculums = Curriculum::where('instructor_id', Auth::user()->accountable->id)->where('grade_level_id', $this->grade_level)->where('status', 'active')->get();
        $this->curriculum_id = '';
        $this->subject_id = '';
        $this->f2fActivities = [];
        $this->selected_f2f_activities = [];
        $this->subjects = collect();
        $this->students = collect();
    }

    public function updatedCurriculumId()
    {
        $this->subject_id = '';
        $this->f2fActivities = [];
        $this->selected_f2f_activities = [];
        $this->subjects = Subject::whereHas('curriculumSubjects', function ($query) {
            $query->where('curriculum_id', $this->curriculum_id);
        })->get();
        $this->students = $this->lesson->students;
    }

    public function updatedActivitySearch()
    {
        if ($this->curriculum_id && $this->subject_id) {
            $curriculumSubject = CurriculumSubject::where('curriculum_id', $this->curriculum_id)
                ->where('subject_id', $this->subject_id)
                ->first();

            if ($curriculumSubject) {
                $this->f2fActivities = ClassActivity::where('curriculum_subject_id', $curriculumSubject->id)
                    ->where('instructor_id', Auth::user()->accountable->id)
                    ->where(function ($query) {
                        $query->whereNull('lesson_id')
                            ->orWhereIn('id', $this->selected_f2f_activities);
                    })
                    ->when($this->activity_search, function ($query) {
                        $query->where(function ($q) {
                            $q->where('name', 'like', '%' . $this->activity_search . '%');
                        });
                    })
                    ->orderBy('created_at', 'desc')
                    ->get();
            } else {
                $this->f2fActivities = collect();
            }
        }
    }

    public function updatedSubjectId()
    {
        if ($this->curriculum_id && $this->subject_id) {
            $curriculumSubject = CurriculumSubject::where('curriculum_id', $this->curriculum_id)
                ->where('subject_id', $this->subject_id)
                ->first();

            if ($curriculumSubject) {
                $this->f2fActivities = ClassActivity::where('curriculum_subject_id', $curriculumSubject->id)
                    ->where('instructor_id', Auth::user()->accountable->id)
                    ->where(function ($query) {
                        $query->whereNull('lesson_id')
                            ->orWhereIn('id', $this->selected_f2f_activities);
                    })
                    ->when($this->activity_search, function ($query) {
                        $query->where(function ($q) {
                            $q->where('name', 'like', '%' . $this->activity_search . '%');
                        });
                    })
                    ->orderBy('created_at', 'desc')
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

    public function render()
    {
        $this->activities = GameActivity::orderBy('id')->get();
        $this->grade_levels = Auth::user()->accountable->gradeLevels->sortBy('id')->values();
        $this->curriculums = Curriculum::where('instructor_id', Auth::user()->accountable->id)->where('grade_level_id', $this->grade_level)->where('status', 'active')->get();
        $this->subjects = Subject::whereHas('curriculumSubjects', function ($query) {
            $query->where('curriculum_id', $this->curriculum_id);
        })->get();
        return view('livewire.lesson-edit-modal');
    }
}
