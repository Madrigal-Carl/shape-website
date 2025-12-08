<div>
    @if ($isOpen)
        <section
            class="bg-black/40 fixed w-dvw h-dvh top-0 left-0 z-50 backdrop-blur-xs flex justify-center overflow-y-auto p-10">
            <!-- Third form -->
            <div class="bg-card p-8 rounded-4xl w-280 flex flex-col gap-12 self-center-safe">
                <div class="flex items-center justify-between gap-2">
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('images/person.png') }}" class="h-8" alt="" />
                        <h1 class="text-3xl font-bold text-heading-dark">
                            Student's Info.
                        </h1>
                    </div>


                    <!-- Action Buttons -->
                    <div class="flex items-center gap-2">
                        {{-- <button
                            class="profile-button flex items-center bg-white py-2 px-5 rounded-full gap-2 text-paragraph cursor-pointer hover:text-white hover:bg-blue-button">
                            <span class="material-symbols-rounded">save</span>
                            <p class="text-sm">Export Form</p>
                        </button> --}}
                        <div
                            class="flex items-center bg-white py-2 px-5 rounded-full text-paragraph hover:bg-blue-button hover:text-white cursor-pointer">
                            <select name="" id="" class="w-max outline-none" wire:model.live="quarter">
                                <option value="1" class=" text-heading-dark">
                                    1st Quarter
                                </option>
                                <option value="2" class=" text-heading-dark">
                                    2nd Quarter
                                </option>
                                <option value="3" class=" text-heading-dark">
                                    3rd Quarter
                                </option>
                                <option value="4" class=" text-heading-dark">
                                    4th Quarter
                                </option>
                            </select>
                        </div>

                        <button wire:click="exportDocx"
                            class="profile-button flex items-center bg-white py-2 px-5 rounded-full gap-2 text-paragraph cursor-pointer hover:text-white hover:bg-blue-button">
                            <span class="material-symbols-rounded">docs</span>
                            <p class="text-sm">Generate Reports</p>
                        </button>

                        <button type="button" wire:click='closeModal'
                            class="bg-white profile-button flex items-center p-2 rounded-full gap-2 text-paragraph cursor-pointer hover:text-white hover:bg-blue-button">
                            <span class="material-symbols-rounded">close</span>
                        </button>
                    </div>
                </div>

                <!-- Profile pic and info -->
                <div class="flex gap-6">
                    <div class="h-20 w-20 rounded-full overflow-hidden">
                        <img src="{{ asset('storage/' . $student->path) }}" alt=""
                            class="object-cover object-center h-full w-full" />
                    </div>

                    <div class="flex flex-col justify-between">
                        <h1 class="font-medium text-xl leading-4">{{ $student->full_name }}
                        </h1>
                        <p class="text-sm text-paragraph">LRN: <span>{{ $student->lrn }}</span></p>
                        <div class="w-fit">
                            @php
                                $statusStyles = [
                                    'active' => ['bg' => 'bg-[#D2FBD0]', 'text' => 'text-[#0D5F07]'],
                                    'pending' => ['bg' => 'bg-[#F7F7F7]', 'text' => 'text-[#3B3B3B]'],
                                    'qualified' => ['bg' => 'bg-[#D2FBD0]', 'text' => 'text-[#0D5F07]'],
                                    'unqualified' => [
                                        'bg' => 'bg-[#F7F7F7]',
                                        'text' => 'text-[#3B3B3B]',
                                    ],
                                    'graduated' => ['bg' => 'bg-[#D0E8FF]', 'text' => 'text-[#004A9F]'],
                                    'transferred' => [
                                        'bg' => 'bg-[#F0E5C0]',
                                        'text' => 'text-[#7F5900]',
                                    ],
                                    'dropped' => ['bg' => 'bg-[#fce4e4]', 'text' => 'text-[#af0000]'],
                                ];

                                $style = $statusStyles[strtolower($student->enrollmentStatus($school_year))] ?? [
                                    'bg' => 'bg-gray-200',
                                    'text' => 'text-gray-600',
                                ];
                            @endphp

                            <div class="gap-2 {{ $style['bg'] }} px-3 py-1 rounded-lg flex items-center w-fit">
                                <small
                                    class="{{ $style['text'] }}">{{ ucwords($student->enrollmentStatus($school_year)) }}</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Summary -->
                <div class="flex flex-col gap-4">
                    <h1 class="text-2xl font-semibold text-heading-dark">Summary</h1>
                    <div class="grid grid-cols-3 grid-rows-1 gap-4">
                        <div
                            class="bg-gradient-to-tr h-48 from-blue-button to-[#00EEFF] p-6 text-white rounded-3xl flex flex-col justify-between gap-6">
                            <div class="flex justify-between w-full">
                                <div>
                                    <p class="text-xs leading-snug font-normal">Earned</p>
                                    <h1 class="text-lg font-semibold leading-6">AWARDS</h1>
                                </div>
                                <span class="material-symbols-rounded icon">award_star</span>
                            </div>
                            <h1 class="text-5xl font-bold">{{ $student->totalAwardsCount($school_year) }}</h1>
                        </div>

                        <div
                            class="bg-gradient-to-tr h-48 from-lime to-[#00ff80] p-6 text-white rounded-3xl flex flex-col justify-between gap-6">
                            <div class="flex justify-between w-full">
                                <div>
                                    <p class="text-xs leading-snug font-normal">Completed</p>
                                    <h1 class="text-lg font-semibold leading-6">LESSONS</h1>
                                </div>
                                <span class="material-symbols-rounded icon">book_ribbon</span>
                            </div>
                            <h1 class="text-5xl font-bold">{{ $student->completedLessonsCount($school_year, $quarter) }}
                            </h1>
                        </div>

                        <div
                            class="bg-gradient-to-tr h-48 from-yellowOrange to-[#FFEA00] p-6 text-white rounded-3xl flex flex-col justify-between gap-6">
                            <div class="flex justify-between w-full">
                                <div>
                                    <p class="text-xs leading-snug font-normal">Completed</p>
                                    <h1 class="text-lg font-semibold leading-6">ACTIVITIES</h1>
                                </div>
                                <span class="material-symbols-rounded icon">stadia_controller</span>
                            </div>
                            <h1 class="text-5xl font-bold">
                                {{ $student->completedActivitiesCount($school_year, $quarter) }}</h1>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-4">

                    <!-- Basic Info -->
                    <div class="flex flex-col gap-4 bg-white p-6 rounded-2xl">
                        <h1 class="text-2xl font-semibold text-heading-dark">Basic Info</h1>
                        <div class="grid grid-cols-4 gap-4">
                            <div class="col-span-1 flex flex-col gap-1">
                                <p class="font-medium">Gender:</p>
                                <p class="font-medium">Age:</p>
                                <p class="font-medium">Birthday:</p>
                                <p class="font-medium">Current Address:</p>
                                <p class="font-medium">Permanent Address:</p>
                                <p class="font-medium">Grade:</p>
                                <p class="font-medium">Dissability:</p>
                                <p class="font-medium">Parent:</p>
                                <p class="font-medium">Parent Contact No.:</p>
                                <p class="font-medium">Parent Email:</p>
                                <p class="font-medium">Notes:</p>
                            </div>

                            <div class="col-span-3 flex flex-col gap-1">
                                <p class="text-paragraph">{{ ucfirst($student->sex) }}</p>
                                <p class="text-paragraph">{{ \Carbon\Carbon::parse($student->birth_date)->age }}</p>
                                <p class="text-paragraph">
                                    {{ \Carbon\Carbon::parse($student->birth_date)->format('F d, Y') }}</p>
                                <p class="text-paragraph">{{ ucwords($student->currentAddress->barangay) }},
                                    {{ ucwords($student->currentAddress->municipality) }},
                                    {{ ucwords($student->currentAddress->province) }}</p>
                                <p class="text-paragraph">{{ ucwords($student->permanentAddress->barangay) }},
                                    {{ ucwords($student->permanentAddress->municipality) }},
                                    {{ ucwords($student->permanentAddress->province) }}</p>
                                <p class="text-paragraph">
                                    {{ ucwords($student->isEnrolledIn($school_year)->gradeLevel->name) }}</p>
                                <p class="text-paragraph">{{ ucwords($student->disability_type) }}</p>
                                <p class="text-paragraph">{{ $student->guardian->fullname }}</p>
                                <p class="text-paragraph">{{ ucwords($student->guardian->phone_number) }}</p>
                                <p class="text-paragraph">{{ ucwords($student->guardian->email) }}</p>
                                <p class="text-paragraph italic">{{ ucfirst($student->support_need) }}
                                </p>
                            </div>
                        </div>
                        <!-- End of Basic Info -->
                    </div>

                    <!-- Educational Background -->
                    @if ($student->isEnrolledIn($school_year)?->educationRecord)
                        <div class="flex flex-col gap-4 bg-white p-6 rounded-2xl">
                            <h1 class="text-2xl font-semibold text-heading-dark">Educational Background</h1>

                            <div class="grid grid-cols-4 gap-4">
                                <div class="col-span-1 flex flex-col gap-1">
                                    <p class="font-medium">School ID:</p>
                                    <p class="font-medium">Last Grade Level Completed:</p>
                                    <p class="font-medium">Last School Year Completed:</p>
                                    <p class="font-medium">Last School Attended:</p>
                                </div>

                                <div class="col-span-3 flex flex-col gap-1">
                                    <p class="text-paragraph">
                                        {{ $student->isEnrolledIn($school_year)->educationRecord->school_id }}
                                    </p>
                                    <p class="text-paragraph">
                                        {{ ucwords($student->isEnrolledIn($school_year)->educationRecord->gradeLevel->name) }}
                                    </p>
                                    <p class="text-paragraph">
                                        {{ $student->isEnrolledIn($school_year)->educationRecord->school_year }}
                                    </p>
                                    <p class="text-paragraph">
                                        {{ $student->isEnrolledIn($school_year)->educationRecord->school_name }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif


                    @if (!$filteredLessons->isEmpty())
                        <div class="flex flex-col bg-white rounded-2xl p-6 gap-4 ">
                            <div class="flex items-center justify-between w-full">
                                <h1 class="text-2xl font-semibold text-heading-dark">Assigned Lessons</h1>
                                <!-- Action Buttons -->
                                <div class="flex items-center gap-2">
                                    <div
                                        class="flex items-center bg-card py-2 px-5 rounded-full text-paragraph hover:bg-blue-button hover:text-white cursor-pointer">
                                        <select class="w-max outline-none" wire:model.live="subject">
                                            <option value="">All Subjects</option>
                                            @foreach ($this->subjects as $subject)
                                                <option value="{{ $subject->id }}">{{ ucwords($subject->name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            {{-- Lesson Container --}}
                            <div class="w-full flex flex-col gap-2">

                                {{-- Lessons --}}
                                @foreach ($filteredLessons as $lessonData)
                                    @php
                                        $lessonId = $lessonData['model']->id;
                                        $isOpen = $openLesson === $lessonId;
                                    @endphp

                                    <div class="bg-card py-4 px-6 rounded-2xl flex flex-col gap-4">

                                        {{-- Header (Clickable Accordion Trigger) --}}
                                        <div class="w-full flex items-center justify-between cursor-pointer"
                                            wire:click="toggleLesson({{ $lessonId }})">

                                            <h1 class="text-xl font-semibold">
                                                {{ ucwords($lessonData['model']->title) }}
                                            </h1>

                                            <div class="flex items-center gap-3">
                                                <p class="text-xl font-medium">{{ $lessonData['percent'] }}%</p>

                                                {{-- Arrow --}}
                                                <svg class="w-6 h-6 transition-transform duration-300 {{ $isOpen ? 'rotate-180' : '' }}"
                                                    fill="none" stroke="currentColor" stroke-width="2"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19 9l-7 7-7-7" />
                                                </svg>
                                            </div>
                                        </div>

                                        {{-- COLLAPSIBLE CONTENT --}}
                                        @if ($isOpen)
                                            <div class="mt-2 flex flex-col gap-6">

                                                {{-- Gamified Activities --}}
                                                <div class="w-full flex flex-col gap-2">
                                                    <h2 class="text-lg font-semibold text-heading-dark">Gamified
                                                        Activities
                                                    </h2>

                                                    <div
                                                        class="w-full flex flex-col gap-2 border-l-2 pl-4 border-gray-300">
                                                        @forelse ($lessonData['game_activities'] as $game)
                                                            <div class="flex items-center justify-between">
                                                                <h1 class="text-md font-medium">
                                                                    {{ $game->gameActivity->name ?? 'Activity' }}</h1>

                                                                @if ($student->activityStatus($game) === 'finished')
                                                                    <p
                                                                        class="text-sm flex items-center bg-[#D2FBD0] text-[#0D5F07] px-3 py-1 rounded-full">
                                                                        completed
                                                                    </p>
                                                                @else
                                                                    <p
                                                                        class="text-sm flex items-center bg-[#fce4e4] text-[#af0000] px-3 py-1 rounded-full">
                                                                        incomplete
                                                                    </p>
                                                                @endif
                                                            </div>
                                                        @empty
                                                            <div class="w-full h-12 flex items-center justify-center">
                                                                <h1 class="text-md font-medium">No Activity Assigned.
                                                                </h1>
                                                            </div>
                                                        @endforelse
                                                    </div>
                                                </div>

                                                {{-- F2F Activities --}}
                                                <div class="w-full flex flex-col gap-2">
                                                    <h2 class="text-lg font-semibold text-heading-dark">F2F Activities
                                                    </h2>

                                                    <div
                                                        class="w-full flex flex-col gap-2 border-l-2 pl-4 border-gray-300">

                                                        @forelse ($lessonData['class_activities'] as $act)
                                                            <div class="flex items-center justify-between">
                                                                <h1 class="text-md font-medium">{{ $act->name }}
                                                                </h1>

                                                                @if ($student->activityStatus($act) === 'finished')
                                                                    <p
                                                                        class="text-sm flex items-center bg-[#D2FBD0] text-[#0D5F07] px-3 py-1 rounded-full">
                                                                        completed
                                                                    </p>
                                                                @else
                                                                    <p
                                                                        class="text-sm flex items-center bg-[#fce4e4] text-[#af0000] px-3 py-1 rounded-full">
                                                                        incomplete
                                                                    </p>
                                                                @endif
                                                            </div>
                                                        @empty
                                                            <div class="w-full h-12 flex items-center justify-center">
                                                                <h1 class="text-md font-medium">No Activity Assigned.
                                                                </h1>
                                                            </div>
                                                        @endforelse
                                                    </div>
                                                </div>

                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            @if ($filteredLessons->lastPage() > 1)
                                <div
                                    class="rounded-full bg-white gap-1 p-2 w-fit self-center-safe flex items-center text-sm">

                                    {{-- Previous --}}
                                    <button wire:click="previousPage" wire:loading.attr="disabled"
                                        class="cursor-pointer py-1 flex items-center px-3 {{ $filteredLessons->onFirstPage() ? 'opacity-40 cursor-default' : '' }}">
                                        <span class="material-symbols-outlined">
                                            chevron_left
                                        </span>
                                    </button>

                                    {{-- Page Numbers --}}
                                    @for ($i = 1; $i <= $filteredLessons->lastPage(); $i++)
                                        <button wire:click="gotoPage({{ $i }})"
                                            class="py-1 px-4 rounded-full cursor-pointer
                                        {{ $i == $filteredLessons->currentPage() ? 'bg-blue-button text-white' : 'hover:bg-blue-button hover:text-white' }}">
                                            {{ $i }}
                                        </button>
                                    @endfor

                                    {{-- Next --}}
                                    <button wire:click="nextPage" wire:loading.attr="disabled"
                                        class="cursor-pointer py-1 flex items-center px-3 {{ $filteredLessons->currentPage() == $filteredLessons->lastPage() ? 'opacity-40 cursor-default' : '' }}">
                                        <span class="material-symbols-outlined">
                                            chevron_right
                                        </span>
                                    </button>

                                </div>
                            @endif
                        </div>
                    @endif
                </div>
                <!-- End of Third form -->
        </section>
    @endif
</div>
