<div>
    @if ($isOpen)
        <section class="bg-black/30 fixed w-dvw h-dvh p-10 top-0 left-0 z-50 backdrop-blur-xs flex justify-center gap-6">
            <!-- Add lesson container -->
            <form wire:submit='editLesson' class="flex justify-center gap-6">
                <div class="w-180 h-full Addlesson bg-white p-8 rounded-4xl relative">
                    <!-- first form -->
                    <div class="Addlesson w-full h-[100%] flex flex-col gap-8 self-center-safe overflow-y-auto">
                        <div class="flex items-center gap-2">
                            <img src="{{ asset('images/cube.png') }}" alt="" />
                            <h1 class="text-2xl font-semibold text-heading-dark">
                                Edit Lesson
                            </h1>
                        </div>

                        <div class="flex flex-col gap-3">
                            <h2 class="font-medium text-lg">Lesson Information</h2>
                            <div class="flex flex-col gap-2">
                                <input type="text" placeholder="Lesson Name" wire:model.live="lesson_name"
                                    class="px-3 py-1 rounded-lg bg-card placeholder-paragraph outline-none w-full" />

                                <div class="px-2 py-1 rounded-lg bg-card">
                                    <select wire:model.live="grade_level" name="" id=""
                                        class="w-full outline-none text-paragraph">
                                        <option value="" class="text-sm text-black" disabled>
                                            Grade Level
                                        </option>
                                        @foreach ($grade_levels as $grade_lvl)
                                            @if ($grade_level === $grade_lvl)
                                                <option value="{{ $grade_level }}" class="text-sm text-black" selected>
                                                    {{ ucwords($grade_level) }}
                                                </option>
                                            @else
                                                <option value="{{ $grade_lvl }}" class="text-sm text-paragraph">
                                                    {{ ucwords($grade_lvl) }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="flex items-center gap-2 w-full">
                                    <div class="px-2 py-1 rounded-lg bg-card w-full">
                                        <select name="" id="" wire:model.live="curriculum"
                                            wire:key="{{ $grade_level }}" class="w-full outline-none text-paragraph">
                                            <option value="" class="text-sm text-black" disabled>
                                                Curriculum
                                            </option>
                                            @foreach ($curriculums as $cur)
                                                @if ($curriculum === $cur->name)
                                                    <option value="{{ $curriculum_id }}" class="text-sm text-black"
                                                        selected>
                                                        {{ ucwords($curriculum) }}
                                                    </option>
                                                @else
                                                    <option value="{{ $cur->id }}" class="text-sm text-paragraph">
                                                        {{ ucwords($cur->name) }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 w-full">
                                    <div class="px-2 py-1 rounded-lg bg-card w-full">
                                        <select name="" id="" wire:model.live="subject"
                                            wire:key="{{ $curriculum }}" class="w-full outline-none text-paragraph">
                                            <option value="" class="text-sm text-black" disabled>
                                                Grade & Section
                                            </option>
                                            @foreach ($subjects as $subj)
                                                @if ($subject === $subj)
                                                    <option value="{{ $subject_id }}" class="text-sm text-black"
                                                        selected>
                                                        {{ ucwords($subject) }}
                                                    </option>
                                                @else
                                                    <option value="{{ $subj->id }}" class="text-sm text-paragraph">
                                                        {{ ucwords($subj->name) }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="px-2 py-1 rounded-lg bg-card">
                                    <select name="" id="" wire:model.live="selected_student"
                                        wire:key="{{ $curriculum }}" class="w-full outline-none text-paragraph">
                                        <option value="" class="text-sm text-black" selected disabled>
                                            Select Student (Optional)
                                        </option>
                                        @foreach ($students as $student)
                                            <option value="{{ $student->id }}" class="text-sm text-paragraph">
                                                {{ ucwords($student->last_name) }},
                                                {{ ucwords($student->first_name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($selected_students as $i => $stud)
                                        @php
                                            $student = $students->firstWhere('id', $stud);
                                        @endphp
                                        <div class="flex items-center gap-2 px-3 py-1 bg-card rounded-full w-fit">
                                            {{-- SHOULD BE STUDENT NAME --}}
                                            <p class="text-sm">{{ $student->last_name }}</p>
                                            <button wire:click="removeStudent({{ $i }})" type="button"
                                                class="text-red-500 hover:text-red-700">✕</button>
                                        </div>
                                    @endforeach
                                </div>

                                <textarea name="" id="" maxlength="200" placeholder="Description (Optional)"
                                    wire:model.live="description"
                                    class="px-3 py-2 rounded-lg bg-card placeholder-paragraph resize-none h-24 outline-none"></textarea>
                            </div>
                        </div>

                        <div class="flex flex-col gap-3">
                            <h2 class="font-medium text-lg">Interactive Video Lessons</h2>
                            <div class="flex flex-col gap-2">
                                <div class="flex items-center h-24 justify-center gap-2 px-6 py-3 border-1 border-dashed border-gray-300 rounded-lg w-full hover:text-blue-button hover:border-blue-button"
                                    id="dropzone">
                                    <label for="videoUpload" class="cursor-pointer flex items-center gap-2">
                                        <h1>Drop or Click to Upload Video</h1>
                                        <span class="material-symbols-rounded">add_photo_alternate</span>
                                    </label>
                                    <input type="file" wire:model="videos" multiple class="hidden"
                                        id="videoUpload" />
                                </div>

                                <div wire:loading wire:target="videos" x-data="{ progress: 0 }"
                                    x-on:livewire-upload-progress.window="progress = $event.detail.progress"
                                    x-on:livewire-upload-start.window="progress = 0"
                                    x-on:livewire-upload-finish.window="progress = 0"
                                    x-on:livewire-upload-error.window="progress = 0"
                                    class="w-full mt-3 flex-col items-center">

                                    <div class="bg-gray-200 rounded-full h-2 overflow-hidden">
                                        <div class="bg-blue-500 h-2 transition-all duration-300"
                                            :style="'width: ' + progress + '%'"></div>
                                    </div>

                                    <p class="text-sm text-blue-600 text-center">
                                        Uploading... <span x-text="progress"></span>%
                                    </p>
                                </div>



                                <div class="w-full grid grid-cols-2 gap-2">
                                    @foreach ($uploadedVideos as $index => $video)
                                        <div class="flex flex-col gap-2 relative video-container-{{ $index }}">
                                            <div class="w-full flex flex-col items-center justify-center shrink-0">
                                                {{-- Thumbnail --}}
                                                <img src="{{ $video['thumbnail'] }}"
                                                    class="aspect-video w-max h-fit rounded-lg object-cover video-thumb-{{ $index }}" />

                                                {{-- Play Button --}}
                                                <button type="button"
                                                    class="absolute rounded-full cursor-pointer hover:scale-110 shadow-xl/40 z-10 playBtn-{{ $index }}"
                                                    onclick="playFullscreen('{{ $video['video'] }}')">
                                                    <span
                                                        class="material-symbols-rounded p-2 rounded-full text-white bg-black/35 backdrop-blur-[3px] shadow-white/70 shadow-inner">
                                                        play_arrow
                                                    </span>
                                                </button>
                                            </div>

                                            {{-- Overlay with title + delete --}}
                                            <div
                                                class="absolute bottom-0 bg-gradient-to-t from-black/80 via-black/0 to-black/0 w-full h-full rounded-lg">
                                                <div class="h-full w-full flex items-end justify-between p-3">
                                                    <h1 class="text-white font-medium text-sm ml-1 truncate w-[80%]">
                                                        {{ $video['title'] }}
                                                    </h1>
                                                    <button wire:click="removeVideo({{ $index }})"
                                                        type="button"
                                                        class="cursor-pointer p-0 flex items-center justify-center text-white hover:text-danger hover:scale-110">
                                                        <span class="material-symbols-rounded">delete</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>

                            </div>
                            <div class="grid grid-cols-3 gap-2">
                                <input type="text" placeholder="Paste YouTube Link" wire:model="youtube_link"
                                    class="px-3 py-1 rounded-lg bg-card placeholder-paragraph outline-none w-full col-span-2" />
                                <button type="button" wire:click="addYoutubeVideo"
                                    class="bg-blue-button text-white px-3 py-1 rounded-lg w-full col-span-1">
                                    Add YouTube Video
                                </button>
                            </div>
                            @if (empty($uploadedVideos))
                                <div class="bg-card w-full h-30 flex items-center justify-center rounded-lg">
                                    <h1 class="text-paragraph">No Video added</h1>
                                </div>
                            @endif
                        </div>

                        <div class="flex flex-col gap-3">
                            <h2 class="font-medium text-lg">Activities</h2>


                            <div class="w-full grid grid-cols-1 gap-2 items-center justify-center rounded-lg">
                                <button wire:click='openActivityHub' type="button"
                                    class="bg-blue-button py-1.5 px-3 w-full rounded-xl text-white font-medium">
                                    Add Activity
                                </button>
                                <livewire:activity-hub targetComponent="lesson-edit-modal" />
                                @forelse ($selected_activities as $i => $act)
                                    <div wire:key="activity-{{ $i }}"
                                        class="flex w-full justify-between bg-card p-2 rounded-lg">
                                        <div class="flex gap-2">
                                            <img src="{{ asset($act->path) }}" alt=""
                                                class="h-12 rounded-md aspect-square object-cover" />
                                            <div>
                                                <h1 class="font-medium text-sm">{{ $act->name }}</h1>
                                                <p>
                                                    {{ collect($act->specializations ?? [])->map(fn($cat) => ucfirst(Str::of($cat)->explode(' ')->first()))->implode(', ') }}
                                                </p>

                                            </div>
                                        </div>

                                        <button type="button" wire:click="removeActivity({{ $i }})"
                                            type="button"
                                            class="flex items-center w-fit h-fit justify-center cursor-pointer hover:scale-120">
                                            <span class="material-symbols-rounded remove-icon">close</span>
                                        </button>
                                    </div>
                                @empty
                                    <div class="bg-card col-span-2 h-30 flex items-center justify-center rounded-lg">
                                        <h1 class="text-paragraph">No Activity added</h1>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Add lesson container -->

                <!-- Create Quiz Container -->
                <div class="w-180 h-full Addlesson bg-white p-8 rounded-4xl relative">
                    <div class="Addlesson w-full h-[100%] flex flex-col pb-18 gap-8 self-center-safe overflow-y-auto">
                        <div class="flex items-center gap-2">
                            <img src="{{ asset('images/quizzes.png') }}" alt="" />
                            <h1 class="text-2xl font-semibold text-heading-dark">
                                Edit Quiz
                            </h1>
                        </div>

                        <!-- Question Container-->
                        <div class="flex flex-col gap-4">
                            <div class="flex flex-col border-1 border-gray-300 py-4 px-5 rounded-2xl">
                                <input type="text" name="" id="" placeholder="Quiz Name"
                                    wire:model.live="quiz_name"
                                    class="text-xl outline-none placeholder-heading-dark" />
                                <textarea name="" id="" maxlength="200" placeholder="Description (Optional)"
                                    wire:model.live="quiz_description" class="placeholder-paragraph text-paragraph resize-none h-15 outline-none"></textarea>
                            </div>
                            @foreach ($questions as $qIndex => $question)
                                <div class="flex flex-col border-1 border-gray-300 p-5 rounded-2xl gap-4">

                                    <!-- Question Input -->
                                    <input type="text" placeholder="Question"
                                        wire:model="questions.{{ $qIndex }}.question"
                                        class="border-b-2 border-gray-400 px-3 py-1 bg-card placeholder-paragraph outline-none w-full" />

                                    <!-- Option Container -->
                                    <div class="flex flex-col">

                                        @foreach ($question['options'] as $oIndex => $option)
                                            <!-- Option Holder -->
                                            <div
                                                class="flex items-center justify-between w-full p-2 rounded-lg
                                                    {{ $option['is_correct'] ? 'bg-[#CFF2D9]' : '' }}">

                                                <div class="flex items-center gap-4 w-full">

                                                    <!-- Circle (only this is clickable to set answer) -->
                                                    <div wire:click="setCorrectAnswer({{ $qIndex }}, {{ $oIndex }})"
                                                        class="w-5 h-5 border-1 rounded-full p-0.5 flex items-center justify-center cursor-pointer
                                                            {{ $option['is_correct'] ? 'border-[#11BC3F]' : 'border-gray-400' }}">

                                                        @if ($option['is_correct'])
                                                            <span
                                                                class="w-full h-full rounded-full bg-[#11BC3F]"></span>
                                                        @endif
                                                    </div>

                                                    <!-- Option text -->
                                                    <input type="text"
                                                        wire:model="questions.{{ $qIndex }}.options.{{ $oIndex }}.text"
                                                        placeholder="Option {{ $oIndex + 1 }}"
                                                        class="placeholder-paragraph text-sm outline-none
                                                            {{ $option['is_correct'] ? 'text-[#11BC3F] font-medium' : '' }}" />
                                                </div>

                                                <!-- Right side icon -->
                                                @if ($option['is_correct'])
                                                    <span class="material-symbols-rounded text-[#11BC3F]">check</span>
                                                @else
                                                    <span
                                                        wire:click="removeOption({{ $qIndex }}, {{ $oIndex }})"
                                                        class="material-symbols-rounded text-paragraph cursor-pointer hover:text-danger">
                                                        close
                                                    </span>
                                                @endif
                                            </div>
                                            <!-- End of Option Holder -->
                                        @endforeach



                                        <!-- Add option -->
                                        <div class="flex items-center justify-between w-full p-2 rounded-lg">
                                            <div class="flex items-center gap-4">
                                                <div
                                                    class="w-5 h-5 border-1 border-gray-400 rounded-full p-0.5 flex items-center justify-center">
                                                </div>
                                                <button type="button" wire:click="addOption({{ $qIndex }})"
                                                    class="text-blue-button outline-none text-sm cursor-pointer">
                                                    Add Option
                                                </button>
                                            </div>
                                        </div>
                                        <!-- End of Add option -->

                                        <div class="flex items-center justify-between pt-6">
                                            <button type="button"
                                                class="w-fit h-fit flex items-center justify-center gap-2 cursor-pointer">
                                                <span
                                                    class="material-symbols-rounded text-blue-button">assignment_turned_in</span>
                                                <h1 class="text-blue-button">Answer Key</h1>
                                                <p class="pl-3 text-paragraph text-sm">
                                                    (<span>
                                                        {{ collect($question['options'])->firstWhere('is_correct', true)['text'] ?? 'None' }}
                                                    </span>)
                                                </p>
                                            </button>
                                            <div class="flex items-center gap-6">
                                                <div class="w-fit flex items-center gap-2">
                                                    <input type="number"
                                                        wire:model.live="questions.{{ $qIndex }}.point"
                                                        class="w-9 outline-none pl-1 border-b-1 border-gray-400"
                                                        min="1" step="1" name="" value="1"
                                                        id="" />
                                                    <p>points</p>
                                                </div>
                                                <button wire:click="removeQuestion({{ $qIndex }})"
                                                    type="button"
                                                    class="w-fit h-fit cursor-pointer p-0 flex items-center justify-center text-paragraph hover:text-danger hover:scale-120">
                                                    <span class="material-symbols-rounded">delete</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End of Option Container -->
                                </div>
                            @endforeach
                            <!--End Question Holder -->
                            <button wire:click="addQuestion" type="button"
                                class="flex w-fit items-center justify-center border-1 border-gray-300 py-2 px-3 rounded-2xl gap-2 self-center text-paragraph text-sm hover:border-blue-button hover:text-white hover:bg-blue-button hover:scale-110 cursor-pointer">
                                <span class="material-symbols-rounded">add_circle</span>
                                <p>Add Question</p>
                            </button>
                        </div>
                        <!-- End of Option Container -->

                        <div
                            class="flex items-center gap-2 absolute w-full left-0 bottom-0 px-5 pb-5 pt-10 rounded-b-4xl bg-gradient-to-t from-white via-white to-white/50">
                            <button wire:click='closeModal' type="button"
                                class="bg-gray-100 py-1.5 px-3 w-full rounded-xl text-heading-dark font-medium cursor-pointer hover:scale-102">
                                Cancel
                            </button>
                            <button type="submit"
                                class="bg-blue-button py-1.5 px-3 w-full rounded-xl text-white font-medium cursor-pointer hover:scale-102">
                                Save
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            <div wire:loading wire:target="addLesson"
                class="bg-black/10 fixed top-0 left-0 w-dvw h-dvh z-50 flex justify-center items-center backdrop-blur-sm">
                <svg aria-hidden="true"
                    class="w-12 h-12 text-gray-200 animate-spin fill-blue-600 absolute top-1/2 left-[49%]"
                    viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                        fill="currentColor" />
                    <path
                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                        fill="currentFill" />
                </svg>
                <span class="sr-only">Loading...</span>
            </div>
        </section>
    @endif
</div>


<script>
    function playFullscreen(path) {
        // Create video dynamically
        let video = document.createElement("video");
        video.src = path;
        video.controls = true;
        video.autoplay = true;
        video.style.width = "100%";
        video.style.height = "100%";
        video.style.background = "#000";

        // Append to body
        document.body.appendChild(video);

        // Go fullscreen
        if (video.requestFullscreen) {
            video.requestFullscreen();
        } else if (video.webkitRequestFullscreen) {
            video.webkitRequestFullscreen();
        } else if (video.msRequestFullscreen) {
            video.msRequestFullscreen();
        }

        // Cleanup on exit
        video.onfullscreenchange = () => {
            if (!document.fullscreenElement) {
                video.pause();
                video.remove();
            }
        };
    }
</script>
