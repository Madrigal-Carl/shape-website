<div>
    @if ($isOpen)
        <section class="bg-black/30 fixed w-dvw h-dvh p-10 top-0 left-0 z-50 backdrop-blur-xs flex justify-center gap-6">
            <!-- Add lesson container -->
            <form wire:submit='addLesson' class="flex justify-center gap-6">
                <div class="w-180 h-full Addlesson bg-card p-8 rounded-4xl relative">
                    <!-- first form -->
                    <div class="Addlesson w-full h-[100%] flex flex-col gap-8 self-center-safe overflow-y-auto">
                        <div class="flex items-center gap-2">
                            <img src="{{ asset('images/cube.png') }}" alt="" />
                            <h1 class="text-3xl font-bold text-heading-dark">
                                Add Lesson
                            </h1>
                        </div>

                        <div class="flex flex-col gap-3">
                            <h2 class="font-semibold text-xl ">Lesson Information</h2>
                            <div class="flex flex-col gap-2">
                                <input type="text" placeholder="Lesson Name" wire:model.live="lesson_name"
                                    class="px-4 py-2 rounded-lg bg-white placeholder-paragraph outline-none w-full" />

                                <div class="px-4 py-2 rounded-lg bg-white">
                                    <select wire:model.live="grade_level" name="" id=""
                                        class="w-full outline-none text-paragraph">
                                        <option value="" class="text-sm text-black" selected disabled>
                                            Grade & Section
                                        </option>
                                        @foreach ($grade_levels as $grade_level)
                                            <option value="{{ $grade_level }}" class="text-sm text-paragraph">
                                                {{ ucwords($grade_level) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="flex items-center gap-2 w-full">
                                    <div class="px-4 py-2 rounded-lg bg-white w-full">
                                        <select name="" id="" wire:model.live="curriculum"
                                            wire:key="{{ $grade_level }}" class="w-full outline-none text-paragraph">
                                            <option value="" class="text-sm text-black" selected disabled>
                                                Curriculum
                                            </option>
                                            @foreach ($curriculums as $curriculum)
                                                <option value="{{ $curriculum->id }}" class="text-sm text-paragraph">
                                                    {{ ucwords($curriculum->name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 w-full">
                                    <div class="px-4 py-2 rounded-lg bg-white w-full">
                                        <select name="" id="" wire:model.live="subject"
                                            wire:key="{{ $curriculum }}" class="w-full outline-none text-paragraph">
                                            <option value="" class="text-sm text-black" selected disabled>
                                                Subject
                                            </option>
                                            @foreach ($subjects as $subject)
                                                <option value="{{ $subject->id }}" class="text-sm text-paragraph">
                                                    {{ ucwords($subject->name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <textarea name="" id="" maxlength="200" placeholder="Description (Optional)"
                                    wire:model.live="description"
                                    class="px-3 py-2 rounded-lg bg-white placeholder-paragraph resize-none h-24 outline-none"></textarea>
                            </div>
                        </div>

                        <div class="flex flex-col gap-3 h-full">
                            <h2 class="font-semibold text-xl">Specialize Learning <span
                                    class="text-paragraph font-normal text-sm">(optional)</span></h2>
                            {{-- Specilize selected Student --}}
                            <div class=" rounded-lg relative flex flex-col gap-2 h-full">
                                {{-- Header --}}
                                <div class="flex items-center justify-between w-full mb-2">
                                    <p class="text-paragraph">Select Student for specialize learning.</p>
                                    <button type="button" wire:click="clearStudents"
                                        class="flex items-center justify-center gap-1 px-3 py-2 rounded-lg text-paragraph hover:text-white cursor-pointer bg-white hover:bg-blue-button">
                                        <p class="text-sm">Clear All</p>
                                        <span class="material-symbols-rounded">clear_all</span>
                                    </button>
                                </div>

                                {{-- Search --}}
                                <div class="flex items-center gap-2 px-4 py-2 rounded-lg bg-white w-full">
                                    <span class="material-symbols-rounded">person_search</span>
                                    <input type="text" placeholder="Search Student"
                                        wire:model.live="student_search"
                                        class="w-full outline-none text-paragraph placeholder-paragraph" />
                                </div>



                                {{-- Student List --}}
                                <div class="h-full flex flex-col gap-1 bg-white rounded-lg p-2">
                                    <div class="flex flex-col gap-1 h-full overflow-y-scroll pr-2 rounded-lg">
                                        @forelse($this->filteredStudents as $student)
                                            <div
                                                class="flex items-center gap-2 w-full p-2 hover:bg-card rounded-lg cursor-pointer">
                                                <label class="container w-fit">
                                                    <input type="checkbox"
                                                        wire:click="toggleStudent({{ $student->id }})"
                                                        @checked(in_array($student->id, $selected_students))>
                                                    <div class="checkmark"></div>
                                                </label>
                                                <p class="w-full text-paragraph">{{ $student->full_name }}</p>
                                            </div>
                                        @empty
                                            <p class="text-center text-sm text-gray-500 h-full flex justify-center items-center">No students found.</p>
                                        @endforelse
                                    </div>
                                </div>
                            </div>{{-- End of Specilize selected Student --}}
                        </div>
                    </div>
                </div>
                <!-- End Add lesson container -->

                <div class="w-180 h-full Addlesson bg-card p-8 rounded-4xl relative">
                    <div class="Addlesson w-full h-[100%] flex flex-col pb-12 gap-8 self-center-safe overflow-y-auto">


                        <div class="flex flex-col gap-3">
                            <h2 class="font-semibold text-xl">Interactive Video Lessons</h2>

                            <div class="flex flex-col gap-2 bg-white p-4 rounded-xl">
                                {{-- Video Upload --}}
                                <div class="flex flex-col gap-2 w-full">
                                    <div x-data="{ isDropping: false }" @dragover.prevent="isDropping = true"
                                        @dragleave.prevent="isDropping = false"
                                        @drop.prevent="isDropping = false; $refs.videoUpload.files = $event.dataTransfer.files; $refs.videoUpload.dispatchEvent(new Event('change'))"
                                        :class="isDropping ? 'border-blue-500 text-blue-500 bg-blue-50' :
                                            'border-gray-300 text-gray-600'"
                                        class="flex items-center h-48 mb-2 justify-center border-2 border-dashed rounded-lg w-full cursor-pointer transition-colors duration-200 hover:border-blue-500 hover:text-blue-500"
                                        id="dropzone">
                                        <label for="videoUpload" class="cursor-pointer flex flex-col items-center gap-2">
                                            <span class="material-symbols-rounded p-4 bg-blue-button rounded-3xl text-white large-icon">video_camera_back_add</span>
                                            <h1 class="w-60 text-center">Drag and Drop a video here or Click to Upload Video</h1>
                                        </label>
                                        <input type="file" wire:model="videos" multiple class="hidden" id="videoUpload"
                                            x-ref="videoUpload" />
                                    </div>

                                    <div class=" grid grid-cols-5 gap-2">
                                        <div class="col-span-4 flex items-center px-4 py-2 bg-card gap-2 rounded-lg">
                                            <span class="material-symbols-rounded">youtube_activity</span>
                                            <input type="text" placeholder="Paste YouTube Link" wire:model="youtube_link"
                                            class=" rounded-lg placeholder-paragraph outline-none w-full" />
                                        </div>
                                        <button type="button" wire:click="addYoutubeVideo"
                                            class="bg-blue-button text-sm text-white px-3 py-2 rounded-lg w-full col-span-1 hover:bg-blue-700 cursor-pointer">
                                            Add Link
                                        </button>
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
                                                    <img src="{{ $video['thumbnail'] }}"
                                                        class="aspect-video w-max h-fit rounded-lg object-cover video-thumb-{{ $index }}" />
                                                    <button type="button"
                                                        class="absolute rounded-full cursor-pointer hover:scale-120 shadow-xl/40 z-10 playBtn-{{ $index }}"
                                                        onclick="playVideo({{ $index }}, '{{ $video['video'] }}')">
                                                        <span
                                                            class="material-symbols-rounded p-2 rounded-full text-white bg-black/35 backdrop-blur-[3px] shadow-white/70 shadow-inner playBtn">
                                                            play_arrow
                                                        </span>
                                                    </button>
                                                </div>

                                                <div
                                                    class="absolute bottom-0 bg-gradient-to-t from-black/80 via-black/0 to-black/0 w-full h-full rounded-lg">
                                                    <div class="h-full w-full flex items-end justify-between p-3">
                                                        <h1 class="text-white font-medium text-sm ml-1 truncate w-[80%]">
                                                            {{ $video['title'] }}
                                                        </h1>
                                                        <button wire:click="removeVideo({{ $index }})"
                                                            type="button"
                                                            class="cursor-pointer p-0 flex items-center justify-center text-white hover:text-danger hover:scale-120">
                                                            <span class="material-symbols-rounded">delete</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                @if (empty($uploadedVideos))
                                    <div class="bg-card w-full h-48 flex items-center justify-center rounded-lg">
                                        <h1 class="text-paragraph">No Video added</h1>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="flex flex-col gap-3">
                            <h2 class="font-semibold text-xl">Activities</h2>
                            <div class="flex flex-col gap-2 bg-white p-4 rounded-xl">
                                <button wire:click='openActivityHub' type="button"
                                    class="bg-card flex items-center justify-baseline gap-2 py-2 px-4 w-full rounded-xl hover:bg-gray-300 cursor-pointer mb-2">

                                    <div class="flex items-center gap-2 w-full">
                                        <span class="material-symbols-rounded">joystick</span>
                                        <p class="text-paragraph">choose Game/Activity</p>
                                    </div>
                                    <span class="material-symbols-rounded">add</span>
                                </button>
                                <div class="w-full grid grid-cols-2 gap-2 rounded-lg">
                                    @forelse ($selected_activities as $i => $act)
                                        <div wire:key="activity-{{ $i }}"
                                            class="flex w-full justify-between bg-card p-2 rounded-lg">
                                            <div class="flex gap-2">
                                                <img src="{{ asset($act->path) }}" alt=""
                                                    class="h-12 rounded-md aspect-square object-cover" />
                                                <div>
                                                    <h1 class="font-medium text-sm">{{ $act->name }}</h1>
                                                    <p class="text-xs text-paragraph">
                                                        {{ collect($act->specializations ?? [])->pluck('name')->map(fn($cat) => ucfirst(Str::of($cat)->explode(' ')->first()))->implode(', ') }}
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
                                        <div class="bg-card col-span-2 h-48 flex items-center justify-center rounded-lg">
                                            <h1 class="text-paragraph">No Game/Activity added</h1>
                                        </div>
                                    @endforelse

                                </div>
                            </div>
                            <livewire:activity-hub targetComponent="lesson-add-modal" />
                        </div>
                        <div
                            class="flex items-center gap-2 absolute w-full left-0 bottom-0 px-8 pb-8 pt-4 rounded-b-4xl bg-card">
                            <button wire:click='closeModal' type="button"
                                class="bg-white py-1.5 px-3 w-full rounded-xl text-heading-dark font-medium hover:bg-gray-300 cursor-pointer">
                                Cancel
                            </button>
                            <button type="submit"
                                class="bg-blue-button py-1.5 px-3 w-full rounded-xl text-white font-medium cursor-pointer hover:bg-blue-700">
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
    function playVideo(index, videoUrl) {
        const container = document.querySelector(`.video-container-${index}`);
        const thumb = container.querySelector(`.video-thumb-${index}`);
        const playBtn = container.querySelector(`.playBtn-${index}`);

        thumb.style.display = 'none';
        playBtn.style.display = 'none';

        let existingMedia = container.querySelector('video, iframe');
        if (existingMedia) existingMedia.remove();

        let mediaEl;

        if (videoUrl.includes('youtube.com') || videoUrl.includes('youtu.be')) {
            const videoIdMatch = videoUrl.match(/(?:youtube\.com\/(?:watch\?v=|shorts\/)|youtu\.be\/)([^\?&]+)/);
            const videoId = videoIdMatch ? videoIdMatch[1] : null;
            if (!videoId) return;

            mediaEl = document.createElement('iframe');
            mediaEl.src = `https://www.youtube.com/embed/${videoId}?autoplay=1&controls=1`;
            mediaEl.allow = "accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture";
            mediaEl.allowFullscreen = true;

        } else {
            // Normal video file
            mediaEl = document.createElement('video');
            mediaEl.src = videoUrl;
            mediaEl.controls = true;
            mediaEl.autoplay = true;

            mediaEl.addEventListener('click', (e) => {
                e.stopPropagation();
                if (mediaEl.paused) mediaEl.play();
                else mediaEl.pause();
            });
        }

        mediaEl.classList.add('aspect-video', 'w-full', 'rounded-lg', 'object-cover');

        container.querySelector('div').appendChild(mediaEl);

        function handleClickOutside(e) {
            if (!container.contains(e.target)) {
                if (mediaEl.tagName === 'VIDEO') mediaEl.pause();
                mediaEl.remove();
                thumb.style.display = 'block';
                playBtn.style.display = 'flex';
                document.removeEventListener('click', handleClickOutside);
            }
        }

        setTimeout(() => document.addEventListener('click', handleClickOutside), 0);
    }
</script>
