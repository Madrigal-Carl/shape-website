<div>
    @if ($isOpen)
        <div class="bg-black/30 fixed w-dvw h-dvh top-0 left-0 z-50 backdrop-blur-xs flex justify-center items-center">
            <div class="bg-card p-8 rounded-3xl w-200 flex flex-col gap-8">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('images/book.png') }}" alt="" />
                    <h1 class="text-2xl font-semibold text-heading-dark">
                        {{ ucwords($curriculum->name) }}
                    </h1>
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <div
                        class="bg-gradient-to-tr h-48 col-span-1 from-blue-button to-[#00EEFF] shadow-blue-button shadow-2xl/45 p-6 text-white rounded-3xl flex flex-col justify-between gap-6 ">
                        <div class="flex justify-between w-40">
                            <div>
                                <p class="text-xs leading-snug font-normal">Total</p>
                                <h1 class="text-lg font-semibold leading-6">Subjects</h1>
                            </div>
                            <span class="material-symbols-rounded icon">subject</span>
                        </div>
                        <h1 class="text-5xl font-bold">{{ count($curriculum->curriculumSubjects) }}</h1>
                    </div>

                    <div
                        class=" bg-white p-6 rounded-3xl w-full flex flex-col justify-between shadow-2xl/10 col-span-2">
                        <div class="flex items-center w-auto gap-4">
                            <h3 class="text-sm font-semibold w-40">Status:</h3>
                            <div class=" w-full">
                                <p class="w-fit outline-none text-[#0D5F07] px-2 py-1 rounded-lg bg-[#D2FBD0] text-sm">
                                    {{ ucfirst($curriculum->status) }}</p>
                            </div>
                        </div>

                        <div class="flex items-center w-auto gap-4">
                            <h3 class="text-sm font-semibold w-40">Grade level:</h3>
                            <p class="text-sm w-full">1</p>
                        </div>

                        <div class="flex items-center w-auto gap-4">
                            <h3 class="text-sm font-semibold w-40">Id:</h3>
                            <p class="text-sm w-full">{{ $curriculum->id }}</p>
                        </div>

                        <div class="flex items-center w-auto gap-4">
                            <h3 class="text-sm font-semibold w-40">Specialize:</h3>
                            <p class="text-sm w-full">
                                {{ collect($curriculum->specializations)->map(fn($s) => ucfirst(explode(' ', $s->name)[0]))->implode(', ') }}
                            </p>
                        </div>

                        <div class="flex items-center w-auto gap-4">
                            <h3 class="text-sm font-semibold w-40">Grade Level:</h3>
                            <p class="text-sm w-full">{{ ucwords($curriculum->grade_level) }}</p>
                        </div>

                    </div>
                </div>

                @if (!empty($curriculum->description))
                    <div class="flex flex-col gap-2">
                        <h1 class="text-lg font-medium">Description</h1>
                        <p class="text-sm text-paragraph text-justify">
                            {{ $curriculum->description }}
                        </p>
                    </div>
                @endif

                <div class="flex flex-col gap-2">
                    <h1 class="text-lg font-medium">Subjects</h1>
                    <div class="grid grid-cols-3 gap-4">
                        @foreach ($curriculum->curriculumSubjects as $curriculumSubject)
                            <div
                                class="flex flex-col h-30 gap-6 bg-white rounded-3xl p-4 col-span-1 justify-between shadow-2xl/10">
                                <div class="flex items-start justify-between gap-4 leading-4.5 w-full">
                                    <h2 class="text-base font-semibold">{{ ucfirst($curriculumSubject->subject->name) }}
                                    </h2>
                                    <img src="{{ asset('images/subject_icons/' . $curriculumSubject->subject->icon) }}"
                                        alt="" class="h-6">
                                </div>

                                <div>
                                    <p class="text-sm text-paragraph">
                                        {{ count($curriculumSubject->lessons) ?? 0 }}
                                        Lessons</p>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button wire:click='closeModal'
                        class="bg-white py-1.5 px-3 w-full rounded-xl text-heading-dark font-medium hover:bg-gray-300 cursor-pointer">
                        Close
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
