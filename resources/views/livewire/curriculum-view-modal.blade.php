<div>
    @if ($isOpen)
        <div class="bg-black/30 fixed w-dvw h-dvh top-0 left-0 z-50 backdrop-blur-xs flex justify-center items-center">
            <div class="bg-white p-8 rounded-3xl w-1/3 flex flex-col gap-8">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('images/book.png') }}" alt="" />
                    <h1 class="text-2xl font-semibold text-heading-dark">
                        {{ ucfirst($curriculum->name) }}
                    </h1>
                </div>

                <div class="flex w-full gap-4">
                    <div
                        class="bg-gradient-to-tr from-blue-button to-[#00EEFF] shadow-blue-button shadow-2xl/45 p-6 text-white rounded-3xl flex flex-col justify-between gap-6">
                        <div class="flex justify-between w-40">
                            <div>
                                <p class="text-xs leading-snug font-normal">Total Students</p>
                                <h1 class="text-lg font-semibold leading-6">ENROLLED</h1>
                            </div>
                            <span class="material-symbols-rounded icon">people</span>
                        </div>
                        <h1 class="text-4xl font-semibold">{{ $curriculum->students_count }}</h1>
                    </div>

                    <div class="border-1 border-gray-300 p-6 rounded-3xl w-full flex flex-col justify-between">
                        <div class="flex items-center w-auto">
                            <h3 class="text-sm font-semibold w-25">Status:</h3>
                            <div class="px-2 py-1 rounded-lg bg-[#D2FBD0] w-fit">
                                <p class="w-fit outline-none text-[#0D5F07] text-sm">
                                    {{ ucfirst($curriculum->status) }}</p>
                            </div>
                        </div>

                        <div class="flex items-center w-auto">
                            <h3 class="text-sm font-semibold w-25">Id:</h3>
                            <p class="text-sm">{{ $curriculum->id }}</p>
                        </div>

                        <div class="flex items-center w-auto">
                            <h3 class="text-sm font-semibold w-25">Specialize:</h3>
                            <p class="text-sm">
                                {{ collect($curriculum->specialization)->map(fn($s) => ucfirst(explode(' ', $s)[0]))->implode(', ') }}
                            </p>
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
                    <div class="grid grid-cols-4 gap-4">
                        @foreach ($curriculum->curriculumSubjects as $curriculumSubject)
                            <div class="flex flex-col items-center gap-6 bg-gray-100 rounded-3xl p-4 col-span-1">
                                <h2 class="text-base">{{ ucfirst($curriculumSubject->subject->name) }}</h2>
                                <div class="text-center">
                                    <h1 class="text-xl font-semibold">X Units</h1>
                                    <p class="text-sm text-paragraph">{{ count($curriculumSubject->subject->lessons) }}
                                        Lessons</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button wire:click='closeModal'
                        class="bg-gray-100 py-1.5 px-3 w-full rounded-xl text-heading-dark font-medium">
                        Close
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
