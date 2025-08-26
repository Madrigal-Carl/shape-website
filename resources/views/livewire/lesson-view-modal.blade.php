<div>
    @if ($isOpen)
        <section class="bg-black/30 fixed w-dvw h-dvh p-10 top-0 left-0 z-50 backdrop-blur-xs flex justify-center gap-6">
            <!-- Lessson View Info-->
            <div class="w-150 h-full Addlesson bg-white py-8 rounded-4xl relative flex">
                <div
                    class="Addlesson w-full h-full flex flex-col pr-8 pl-8 pb-18 gap-8 self-center-safe overflow-y-auto">
                    <div class="flex items-center gap-4">
                        <img src="src/images/cube.png" alt="">
                        <h1 class=" text-2xl font-semibold text-heading-dark">{{ $lesson->title }}</h1>
                    </div>


                    <div class="flex w-full gap-4">
                        <div
                            class="bg-gradient-to-tr from-blue-button to-[#00EEFF] shadow-blue-button shadow-2xl/45 p-6 text-white rounded-3xl flex flex-col justify-between gap-6">
                            <div class="flex justify-between w-45">
                                <div>
                                    <p class="text-xs leading-snug font-normal">No. of Students</p>
                                    <h1 class="text-lg font-semibold leading-6">Assigned</h1>
                                </div>
                                <span class="material-symbols-rounded icon">people</span>
                            </div>
                            <h1 class="text-4xl font-semibold">{{ count($lesson->students) }}</h1>
                        </div>

                        <div class="border-1 border-gray-300 p-6 rounded-3xl w-full flex flex-col gap-2">
                            <div class="flex items-center w-auto">
                                <h3 class="text-sm font-semibold w-30">Subject:</h3>
                                <p class="text-sm">{{ $lesson->lessonSubjectStudents->first()->subject->name }}</p>
                            </div>

                            <div class="flex items-center w-auto">
                                <h3 class="text-sm font-semibold w-30">Curriculum:</h3>
                                <p class="text-sm">{{ $lesson->lessonSubjectStudents->first()->curriculum->name }}</p>
                            </div>

                            <div class="flex items-center w-auto">
                                <h3 class="text-sm font-semibold w-30">No. of Videos:</h3>
                                <p class="text-sm">{{ count($lesson->videos) }}</p>
                            </div>

                            <div class="flex items-center w-auto">
                                <h3 class="text-sm font-semibold w-30">No. of Activity:</h3>
                                <p class="text-sm">{{ count($lesson->activityLessons) }}</p>
                            </div>

                            <div class="flex items-center w-auto">
                                <h3 class="text-sm font-semibold w-30">No. of Quizzes:</h3>
                                <p class="text-sm">1</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-2">
                        <h1 class="text-lg font-medium">Description</h1>
                        <p class="text-sm text-paragraph text-justify">{{ $lesson->description }}</p>
                    </div>

                    <div class="flex flex-col gap-3">
                        <h2 class="font-medium text-lg">Interactive Video Lessons</h2>
                        <div class="flex flex-col gap-2">
                            <!-- Video Container -->
                            <div class="flex grid-cols-2 gap-2">
                                @foreach ($lesson->videos as $video)
                                    <div class="flex flex-col gap-2 relative group">
                                        <div class="flex flex-col items-center justify-center">
                                            {{-- Thumbnail --}}
                                            <img src="{{ $video->thumbnail }}" alt=""
                                                class="aspect-video w-full h-fit rounded-lg object-cover">

                                            {{-- Play button --}}
                                            <button onclick="playFullscreen('{{ asset($video->url) }}')"
                                                class="absolute rounded-full cursor-pointer hover:scale-110 shadow-xl/40 z-10">
                                                <span
                                                    class="material-symbols-rounded p-2 rounded-full playBtn text-white bg-white/20 backdrop-blur-[3px] shadow-white shadow-inner">play_arrow</span>
                                            </button>
                                        </div>

                                        <div
                                            class="absolute bottom-0 bg-gradient-to-t from-black/80 via-black/0 to-black/0 w-full h-full rounded-lg">
                                            <div class="h-full w-full flex items-end justify-between p-3">
                                                <h1 class="text-white font-medium text-sm ml-1">{{ $video->title }}</h1>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>


                    <!-- Games -->
                    <div class="flex flex-col gap-3">
                        <h2 class="font-medium text-lg">Games & Activities</h2>

                        <!-- Game container -->
                        <div class="w-full grid grid-cols-2 gap-2 items-center justify-center rounded-lg">
                            @foreach ($lesson->activityLessons as $act)
                                <div class="flex w-full justify-between bg-card p-2 rounded-lg">
                                    <div class="flex gap-2">
                                        <img src="{{ $act->activity->path }}" alt=""
                                            class="h-12 rounded-md aspect-square object-cover">
                                        <div>
                                            <h1 class="font-medium">{{ $act->activity->name }}</h1>
                                            <p class="text-sm text-paragraph">
                                                {{ $act->activity->specializations->pluck('name')->map(fn($s) => ucwords($s))->join(', ') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>

                    <div class="flex flex-col gap-3">
                        <h2 class="font-medium text-lg">Quizzes</h2>

                        <div class="bg-card w-full h-30 hidden items-center justify-center rounded-lg">
                            <h1 class="text-paragraph">No Quiz added</h1>
                        </div>

                        <div class="w-full grid grid-cols-2 gap-2 items-center justify-center rounded-lg">
                            <div class="flex w-full justify-between bg-card p-2 rounded-lg">
                                <div class="flex gap-2">
                                    <img src="src/images/game-icons/hayday.jpeg" alt=""
                                        class="h-12 rounded-md aspect-square object-cover">
                                    <div>
                                        <h1 class="font-medium">{{ $lesson->quiz->title }}</h1>
                                    </div>
                                </div>
                            </div>
                        </div><!--End of Quiz container -->
                    </div>

                    <div
                        class="flex items-center gap-2 absolute w-full left-0 bottom-0 px-5 pb-5 pt-10  rounded-b-4xl bg-gradient-to-t from-white via-white to-white/50">
                        <button type="button" wire:click='closeModal'
                            class=" bg-gray-100 py-1.5 px-3 w-full rounded-xl text-heading-dark font-medium">Cancel</button>
                    </div>
                </div>
            </div><!-- End of Lesson View Info-->
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
