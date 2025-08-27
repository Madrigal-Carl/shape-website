<?php

namespace App\Livewire;

use FFMpeg\FFMpeg;
use App\Models\Quiz;
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
use App\Models\LessonSubjectStudent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class LessonAddModal extends Component
{
    use WithFileUploads;
    public $subjects, $grade_levels, $students, $activities, $curriculums, $youtube_link, $selected_student = '';
    public $videos = [];
    public $isOpen = false;
    public $lesson_name, $curriculum = '', $subject = '', $grade_level = '', $description, $quiz_name, $quiz_description;
    public $uploadedVideos = [], $selected_activities = [], $selected_students = [];
    public $questions = [
        [
            'question' => '',
            'point' => 1,
            'options' => [
                ['text' => '', 'is_correct' => false],
                ['text' => '', 'is_correct' => false],
            ],
        ],
    ];

    public function resetFields()
    {
        $this->lesson_name = null;
        $this->subject = '';
        $this->grade_level = '';
        $this->subjects = collect();
        $this->students = collect();
        $this->curriculums = collect();
        $this->curriculum = '';
        $this->selected_student = '';
        $this->selected_students = [];
        $this->description = null;
        $this->videos = [];
        $this->uploadedVideos = [];
        $this->selected_activities = [];
        $this->quiz_name = null;
        $this->quiz_description = null;
        $this->questions = [
            [
                'question' => '',
                'point' => 1,
                'options' => [
                    ['text' => '', 'is_correct' => false],
                    ['text' => '', 'is_correct' => false],
                ],
            ],
        ];
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
        $this->dispatch('openModal')->to('activity-hub');
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

    private function validateQuestions(): array
    {
        $validQuestions = [];

        foreach ($this->questions as $questionData) {
            $questionText = trim($questionData['question']);

            // Skip completely blank rows
            if ($questionText === '') {
                $this->dispatch('swal-toast', icon: 'error', title: "A question cannot be empty.");
                return [];
            }

            // Collect only non-empty options
            $filledOptions = collect($questionData['options'])
                ->filter(fn($opt) => trim($opt['text']) !== '')
                ->values();

            if ($filledOptions->count() < 2) {
                $this->dispatch('swal-toast', icon: 'error', title: "Question '{$questionText}' must have at least 2 options.");
                return [];
            }

            // At least one correct option
            if ($filledOptions->where('is_correct', true)->isEmpty()) {
                $this->dispatch('swal-toast', icon: 'error', title: "Question '{$questionText}' must have at least one correct option.");
                return [];
            }

            $validQuestions[] = [
                'question' => $questionText,
                'point'    => $questionData['point'] ?? 1,
                'options'  => $filledOptions->toArray(),
            ];
        }

        return $validQuestions;
    }

    public function validateLesson(): bool
    {
        try {
            $this->validate([
                'lesson_name'        => 'required|min:5|max:100',
                'grade_level'        => 'required',
                'curriculum'         => 'required',
                'subject'            => 'required',
                'selected_activities'=> 'required',
                'quiz_name'          => 'required|min:3|max:100',
                'questions'          => 'required|min:1',
            ], [
                'lesson_name.required' => 'Lesson name is required.',
                'lesson_name.min'      => 'Lesson name must be at least 5 characters.',
                'lesson_name.max'      => 'Lesson name must not exceed 100 characters.',
                'grade_level.required' => 'Grade & Section is required.',
                'curriculum.required'  => 'Please select a curriculum.',
                'subject.required'     => 'Please select a subject.',
                'selected_activities.required' => 'You must add at least one activity.',
                'quiz_name.required'   => 'Quiz name is required.',
                'quiz_name.min'        => 'Quiz name must be at least 3 characters.',
                'questions.required'   => 'You must add at least one question.',
            ]);
        } catch (ValidationException $e) {
            $message = $e->validator->errors()->first();
            $this->dispatch('swal-toast', icon: 'error', title: $message);
            return false;
        }

        // 2. Videos validation
        if (empty($this->uploadedVideos)) {
            $this->dispatch('swal-toast', icon: 'error', title: 'Please upload at least one video or provide a YouTube link.');
            return false;
        }

        // 3. Questions validation
        $validQuestions = $this->validateQuestions();
        if (empty($validQuestions)) {
            return false;
        }

        return true;
    }

    public function addLesson()
    {
        if (!$this->validateLesson()) {
            return;
        }

        $curriculumSubject = CurriculumSubject::where('curriculum_id', $this->curriculum)
            ->where('subject_id', $this->subject)
            ->first();

        $lesson = Lesson::create([
            'title' => $this->lesson_name,
            'description' => $this->description,
        ]);

        $studentsToAssign = empty($this->selected_students)
            ? $this->students
            : Student::whereIn('id', $this->selected_students)->get();

        foreach ($studentsToAssign as $student) {
            LessonSubjectStudent::create([
                'curriculum_subject_id' => $curriculumSubject->id,
                'lesson_id' => $lesson->id,
                'student_id' => $student->id,
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
                'activity_id'  => $activity->id,
            ]);
        }

        $quiz = Quiz::create([
            'lesson_id' => $lesson->id,
            'title'       => $this->quiz_name,
            'description' => $this->quiz_description,
        ]);

        foreach ($this->questions as $questionData) {
            $question = $quiz->questions()->create([
                'question_text' => $questionData['question'],
                'point'         => $questionData['point'],
            ]);

            foreach ($questionData['options'] as $optionData) {
                if (trim($optionData['text']) === '') continue;
                $question->options()->create([
                    'option_text' => $optionData['text'],
                    'is_correct'  => $optionData['is_correct'],
                ]);
            }
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

    public function addQuestion()
    {
        if (!empty($this->questions)) {
            $lastQuestion = end($this->questions);

            $hasQuestionText = trim($lastQuestion['question']) !== '';

            $filledOptions = collect($lastQuestion['options'])
                ->filter(fn($opt) => trim($opt['text']) !== '')
                ->count();

            $hasCorrectAnswer = collect($lastQuestion['options'])
                ->contains(fn($opt) => $opt['is_correct'] === true);

            if (!$hasQuestionText) {
                return $this->dispatch('swal-toast', icon: 'error', title: 'Fill in the question field first.');
            }

            if ($filledOptions < 2) {
                return $this->dispatch('swal-toast', icon: 'error', title: 'Add at least 2 options.');
            }

            if (!$hasCorrectAnswer) {
                return $this->dispatch('swal-toast', icon: 'error', title: 'Please select a correct answer.');
            }
        }

        $this->questions[] = [
            'question' => '',
            'point' => 1,
            'options' => [
                ['text' => '', 'is_correct' => false],
                ['text' => '', 'is_correct' => false],
            ],
        ];
    }

    public function removeQuestion($index)
    {
        unset($this->questions[$index]);
        $this->questions = array_values($this->questions);
    }

    public function addOption($qIndex)
    {
        $this->questions[$qIndex]['options'][] = ['text' => '', 'is_correct' => false];
    }

    public function removeOption($qIndex, $oIndex)
    {
        unset($this->questions[$qIndex]['options'][$oIndex]);
        $this->questions[$qIndex]['options'] = array_values($this->questions[$qIndex]['options']);
    }

    public function setCorrectAnswer($qIndex, $oIndex)
    {
        foreach ($this->questions[$qIndex]['options'] as $key => $option) {
            $this->questions[$qIndex]['options'][$key]['is_correct'] = ($key === $oIndex);
        }
    }
    public function mount()
    {
        $this->activities = Activity::orderBy('id')->get();
        $this->grade_levels = Curriculum::where('instructor_id', Auth::id())
            ->where('status', 'active')
            ->orderBy('grade_level')
            ->pluck('grade_level')
            ->unique()
            ->values()
            ->toArray();
        $this->students = collect();
        $this->curriculums = collect();
        $this->subjects = collect();
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
        if (!empty($this->selected_students)) {
            $this->selected_students = [];
        }
        $this->subject = '';
        $this->selected_student = '';
        $this->subjects = Subject::whereHas('curriculumSubjects', function ($query) {
            $query->where('curriculum_id', $this->curriculum);
        })->get();
        $this->students = Auth::user()->accountable->students()
            ->where('status', 'active')
            ->whereHas('profile', function ($query) {
                $query->where('grade_level', $this->grade_level);
            })
            ->whereHas('profile', function ($query) {
                $query->whereIn('disability_type', Curriculum::find($this->curriculum)
                    ->specializations()
                    ->pluck('name'));
            })
            ->get();
    }

    public function render()
    {
        return view('livewire.lesson-add-modal');
    }
}
