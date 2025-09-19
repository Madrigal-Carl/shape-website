<div>
    @if ($isOpen)
        <section class="bg-black/30 fixed w-dvw h-dvh p-10 top-0 left-0 z-50 backdrop-blur-xs flex justify-center gap-6">
            <!-- Lessson View Info-->
            <div class="w-200 h-full Addlesson bg-card p-8 rounded-4xl relative flex">
                <div class="Addlesson w-full h-full flex flex-col  gap-4 self-center-safe overflow-y-auto">
                    <div class="w-full flex items-start justify-between">
                        <div class="flex items-center gap-2">
                            <img src="{{ asset('images/lesson-icon.png') }}" class="h-8" alt="" />
                            <h1 class="text-3xl font-bold text-heading-dark">
                                {{ $lesson->title }}
                            </h1>
                        </div>

                        <div class="flex items-center gap-2">
                            <button type="button" wire:click='closeModal'
                                class="bg-white profile-button flex items-center p-2 rounded-full gap-2 text-paragraph cursor-pointer hover:text-white hover:bg-blue-button">
                                <span class="material-symbols-rounded">close</span>
                            </button>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div
                            class="bg-gradient-to-tr h-48 col-span-1 from-blue-button to-[#00EEFF] p-6 text-white rounded-3xl flex flex-col justify-between gap-6">
                            <div class="flex justify-between">
                                <div>
                                    <p class="leading-snug font-normal">No. of Students</p>
                                    <h1 class="text-2xl font-semibold leading-6">Assigned</h1>
                                </div>
                                <span class="material-symbols-rounded icon">people</span>
                            </div>
                            <h1 class="text-5xl font-bold">{{ count($lesson->students) }}</h1>
                        </div>

                        <div class="bg-white p-6 rounded-3xl w-full flex flex-col justify-between col-span-2">
                            <div class="flex items-center w-auto gap-4">
                                <h3 class="text-sm font-semibold w-40">Subject:</h3>
                                <p class="text-sm w-full">
                                    {{ ucwords($lesson->lessonSubjectStudents->first()->subject->name) }}
                                </p>
                            </div>

                            <div class="flex items-center w-auto gap-4">
                                <h3 class="text-sm font-semibold w-40">Curriculum:</h3>
                                <p class="text-sm w-full">
                                    {{ ucwords($lesson->lessonSubjectStudents->first()->curriculum->name) }}</p>
                            </div>

                            <div class="flex items-center w-auto gap-4">
                                <h3 class="text-sm font-semibold w-40">Grade level:</h3>
                                <p class="text-sm w-full">
                                    {{ ucwords($lesson->lessonSubjectStudents->first()->curriculum->grade_level) }}</p>
                            </div>

                            <div class="flex items-center w-auto gap-4">
                                <h3 class="text-sm font-semibold w-40">No. of Videos:</h3>
                                <p class="text-sm w-full">{{ count($lesson->videos) }}</p>
                            </div>

                            <div class="flex items-center w-auto gap-4">
                                <h3 class="text-sm font-semibold w-40">No. of Activity:</h3>
                                <p class="text-sm w-full">{{ count($lesson->activityLessons) }}</p>
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
                            <div class="grid grid-cols-2 gap-2">
                                @foreach ($lesson->videos as $i => $video)
                                    <div class="flex flex-col gap-2 relative group video-container-{{ $i }}">
                                        <div class="flex flex-col items-center justify-center">
                                            {{-- Thumbnail --}}
                                            <img src="{{ $video->thumbnail ? asset($video->thumbnail) : asset('images/default-img-holder.png') }}"
                                                alt=""
                                                class="aspect-video w-full h-fit rounded-lg object-cover video-thumb-{{ $i }}">

                                            {{-- Play button --}}
                                            <button onclick="playVideo({{ $i }}, '{{ $video->url }}')"
                                                class="absolute rounded-full cursor-pointer hover:scale-110 shadow-xl/40 z-10 playBtn-{{ $i }}">
                                                <span
                                                    class="material-symbols-rounded p-2 rounded-full text-white bg-black/35 backdrop-blur-[3px] shadow-white/70 shadow-inner playBtn">play_arrow</span>
                                            </button>
                                        </div>

                                        <div
                                            class="absolute bottom-0 bg-gradient-to-t from-black/80 via-black/0 to-black/0 w-full h-full rounded-lg">
                                            <div class="h-full w-full flex items-end justify-between p-3">
                                                <h1 class="text-white font-medium text-sm ml-1 w-full truncate">
                                                    {{ $video->title }}</h1>
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

                        <div class="w-full grid grid-cols-2 gap-2 items-center justify-center rounded-lg">
                            @foreach ($lesson->activityLessons as $act)
                                @php
                                    $activity = $act->activityLessonable;
                                    $isGame = $activity instanceof \App\Models\GameActivity;
                                    $isClass = $activity instanceof \App\Models\ClassActivity;
                                    $hasImage = $isGame && !empty($activity->path);
                                    $imagePath = $activity->path ?? asset('images/default-img-holder.png');
                                @endphp

                                <div class="flex w-full justify-between bg-white p-2 rounded-lg col-span-1">
                                    <div class="flex gap-2">
                                        <img src="{{ $imagePath }}" alt=""
                                            class="h-12 rounded-md aspect-square object-cover">

                                        <div>
                                            <h1 class="font-medium">{{ $activity->name ?? '' }}</h1>

                                            @if ($isGame && $hasImage)
                                                @if ($activity->specializations && $activity->specializations->isNotEmpty())
                                                    <p class="text-sm text-paragraph truncate w-60">
                                                        {{ $activity->specializations->pluck('name')->map(fn($s) => ucwords($s))->join(', ') }}
                                                    </p>
                                                @endif
                                            @endif
                                            {{-- ClassActivity shows only the name, so nothing else --}}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div><!-- End of Lesson View Info-->
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
