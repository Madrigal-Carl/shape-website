<div>
    @if ($isOpen)
        <section class="bg-black/40 fixed w-dvw h-dvh p-10 top-0 left-0 z-50 backdrop-blur-xs flex justify-center gap-6">
            <!-- Teacher Profile -->
            <div class="flex items-center justify-center gap-6">
                <div class="col-span-1 w-180 h-full  bg-card p-8 rounded-4xl relative overflow-hidden">

                    <div class="w-full h-full flex flex-col  gap-12 Addlesson overflow-y-auto">
                        <div class="flex items-center justify-between gap-2">
                            <div class="flex items-center gap-2">
                                <img src="{{ asset('images/person.png') }}" class="h-8" alt="" />
                                <h1 class="text-3xl font-bold text-heading-dark">
                                    Teacher's Info.
                                </h1>
                            </div>


                            <div
                                class="profile-button flex items-center bg-white py-2 px-5 rounded-full gap-2 text-paragraph cursor-pointer hover:text-white hover:bg-blue-button">
                                <select class="w-40 outline-none" wire:model.live='school_year'>
                                    @php
                                        $currentYear = now()->schoolYear()?->name;
                                        $years = collect($school_years);

                                        if (!$years->contains($currentYear)) {
                                            $years->push($currentYear);
                                        }
                                    @endphp

                                    @foreach ($school_years as $sy)
                                        <option value="{{ $sy->id }}"
                                            {{ $sy->id == $school_year ? 'selected' : '' }}>
                                            S.Y {{ $sy->name }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>
                        </div>

                        <!-- Profile pic and info -->
                        <div class="flex gap-6">
                            <img src="{{ 'storage/' . $instructor->path }}" alt="" class="rounded-full w-20" />

                            <div class="flex flex-col justify-between">
                                <h1 class="font-medium text-xl leading-4">{{ $instructor->full_name }}
                                </h1>
                                <p class="text-sm text-paragraph">License number:
                                    <span>{{ $instructor->license_number }}</span>
                                </p>
                                <div class="w-fit">
                                    <div class="flex justify-center items-center">
                                        @php
                                            $statusStyles = [
                                                'active' => ['bg' => 'bg-[#D2FBD0]', 'text' => 'text-[#0D5F07]'],
                                                'inactive' => ['bg' => 'bg-[#F7F7F7]', 'text' => 'text-[#3B3B3B]'],
                                                'resigned' => ['bg' => 'bg-[#D0E8FF]', 'text' => 'text-[#004A9F]'],
                                                'retired' => [
                                                    'bg' => 'bg-[#F0E5C0]',
                                                    'text' => 'text-[#7F5900]',
                                                ],
                                                'terminated' => [
                                                    'bg' => 'bg-[#fce4e4]',
                                                    'text' => 'text-[#af0000]',
                                                ],
                                            ];

                                            $style = $statusStyles[strtolower($instructor->status)] ?? [
                                                'bg' => 'bg-gray-200',
                                                'text' => 'text-gray-600',
                                            ];
                                        @endphp

                                        <div
                                            class="gap-2 {{ $style['bg'] }} px-3 py-1 rounded-lg flex items-center w-fit">
                                            <small
                                                class="{{ $style['text'] }}">{{ ucwords($instructor->status) }}</small>
                                        </div>
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
                                            <p class="text-xs leading-snug font-normal">Total</p>
                                            <h1 class="text-lg font-semibold leading-6">STUDENTS</h1>
                                        </div>
                                        <span class="material-symbols-rounded icon">people</span>
                                    </div>
                                    <h1 class="text-5xl font-bold">{{ $instructor->students()->count() }}</h1>
                                </div>

                                <div
                                    class="bg-gradient-to-tr h-48 from-lime to-[#00ff80] p-6 text-white rounded-3xl flex flex-col justify-between gap-6">
                                    <div class="flex justify-between w-full">
                                        <div>
                                            <p class="text-xs leading-snug font-normal">No. of Active</p>
                                            <h1 class="text-lg font-semibold leading-6">LESSONS</h1>
                                        </div>
                                        <span class="material-symbols-rounded icon">book_ribbon</span>
                                    </div>
                                    <h1 class="text-5xl font-bold">
                                        {{ $instructor->curriculums->where('status', 'active')->flatMap->curriculumSubjects->flatMap->lessons->unique('id')->count() }}
                                    </h1>
                                </div>

                                <div
                                    class="bg-gradient-to-tr h-48 from-yellowOrange to-[#FFEA00] p-6 text-white rounded-3xl flex flex-col justify-between gap-6">
                                    <div class="flex justify-between w-full">
                                        <div>
                                            <p class="text-xs leading-snug font-normal">No. of Active</p>
                                            <h1 class="text-lg font-semibold leading-6">Curriculum</h1>
                                        </div>
                                        <span class="material-symbols-rounded icon">video_library</span>
                                    </div>
                                    <h1 class="text-5xl font-bold">{{ $instructor->curriculums_count }}
                                    </h1>
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
                                        <p class="font-medium">Specialization:</p>
                                    </div>

                                    <div class="col-span-3 flex flex-col gap-1">
                                        <p class="text-paragraph">{{ ucwords($instructor->sex) }}</p>
                                        <p class="text-paragraph">
                                            {{ \Carbon\Carbon::parse($instructor->birth_date)->age }}
                                        </p>
                                        <p class="text-paragraph">
                                            {{ \Carbon\Carbon::parse($instructor->birth_date)->format('F d, Y') }}</p>
                                        <p class="text-paragraph">{{ ucwords($instructor->currentAddress->barangay) }},
                                            {{ ucwords($instructor->currentAddress->municipality) }},
                                            {{ ucwords($instructor->currentAddress->province) }}</p>
                                        <p class="text-paragraph">
                                            {{ ucwords($instructor->permanentAddress->barangay) }},
                                            {{ ucwords($instructor->permanentAddress->municipality) }},
                                            {{ ucwords($instructor->permanentAddress->province) }}</p>
                                        <p class="text-paragraph">Super Handsome</p>
                                        <p class="text-paragraph">
                                            {{ $instructor->specializations->pluck('name')->map(fn($name) => ucwords($name))->implode(', ') }}
                                        </p>
                                    </div>
                                </div>
                                <!-- End of Basic Info -->
                            </div>
                        </div>

                    </div>


                </div>
                <!-- End Teacher Profile -->


                {{-- Students Table --}}
                <div class="w-220 h-full Addlesson bg-card p-8 rounded-4xl relative">
                    <div
                        class="col-span-1 Addlesson w-full h-full flex flex-col gap-8 self-center-safe overflow-hidden">

                        <!-- Student Table -->
                        <div class="w-full flex flex-col gap-4 h-full">
                            <div class="side flex items-center justify-between gap-2 mb-2">
                                <h1 class="text-2xl font-semibold text-heading-dark">Student List</h1>
                                <div class="flex items-center gap-4 self-start">
                                    <div
                                        class="profile-button flex items-center bg-white py-2 px-5 rounded-full gap-2 text-paragraph cursor-pointer hover:text-white hover:bg-blue-button">
                                        <select class="w-40 outline-none" wire:model.live="grade_level">
                                            <option value="" class=" text-heading-dark" disabled>
                                                Grade Level
                                            </option>
                                            <option value="all" class=" text-heading-dark">
                                                All
                                            </option>
                                            @foreach ($grade_levels as $grade)
                                                <option value="{{ $grade->id }}" class=" text-heading-dark">
                                                    {{ ucwords($grade->name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <button type="button" wire:click='closeModal'
                                        class="bg-white profile-button flex items-center p-2 rounded-full gap-2 text-paragraph cursor-pointer hover:text-white hover:bg-blue-button hover:shadow-blue-button">
                                        <span class="material-symbols-rounded">close</span>
                                    </button>
                                </div>
                            </div>

                            <div class="flex flex-col w-full p-6 min-h-[20%] bg-white rounded-3xl">
                                <div class="flex flex-col overflow-y-scroll min-h-[20%]">
                                    <div class="flex flex-col rounded-3xl bg-white">
                                        <table class="table-auto border-separate relative">
                                            <thead class="sticky top-0 left-0 z-40 bg-white">
                                                <tr>
                                                    <th class="px-4 pb-3 text-center font-semibold">ID</th>
                                                    <th class="px-4 pb-3 text-center font-semibold">Name</th>
                                                    <th class="px-4 pb-3 text-center font-semibold">
                                                        Disability
                                                    </th>
                                                    <th class="px-4 pb-3 text-center font-semibold w-20">
                                                        Lessons
                                                    </th>
                                                    <th class="px-4 pb-3 text-center font-semibold w-20">
                                                        Activities
                                                    </th>
                                                    <th class="px-4 pb-3 text-center font-semibold">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($students as $student)
                                                    <tr>
                                                        <td class="px-4 py-3 text-center text-paragraph">
                                                            {{ $student->id }}</td>
                                                        <td class="px-4 py-3 text-center text-paragraph align-middle">
                                                            <p class="truncate w-40">
                                                                {{ $student->full_name }}</p>
                                                        </td>
                                                        <td class="px-4 py-3 text-center text-paragraph align-middle">
                                                            <p class="truncate w-40">
                                                                {{ ucwords($student->disability_type) }}</p>
                                                        </td>
                                                        <td class="px-4 py-3 text-center text-paragraph">
                                                            {{ $student->totalLessonsCount($school_year) }}
                                                        </td>
                                                        <td class="px-4 py-3 text-center text-paragraph">
                                                            {{ $student->totalActivitiesCount($school_year) }}
                                                        </td>
                                                        <td class="px-4 py-3 text-center">
                                                            <div class="flex justify-center items-center">
                                                                <div
                                                                    class="gap-2 bg-[#D2FBD0] px-2 py-1 rounded-full flex items-center w-fit">
                                                                    <small
                                                                        class="text-[#0D5F07]">{{ ucwords($student->enrollmentStatus()) }}</small>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="7" class="text-center py-6 text-gray-500">
                                                            No Students found.
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @if ($students->lastPage() > 1)
                                <div
                                    class="rounded-full bg-white gap-1 p-2 w-fit self-center-safe flex items-center text-sm">
                                    <button
                                        class="cursor-pointer py-1 flex items-center px-3 {{ $students->onFirstPage() ? 'hidden' : '' }}"
                                        @if (!$students->onFirstPage()) wire:click="gotoPage({{ $students->currentPage() - 1 }})" @endif>
                                        <span class="material-symbols-outlined">
                                            chevron_left
                                        </span>
                                    </button>

                                    @foreach ($students->getUrlRange(1, $students->lastPage()) as $page => $url)
                                        @if ($page == $students->currentPage())
                                            <button
                                                class=" bg-blue-button text-white py-1 px-4 rounded-full cursor-pointer">{{ $page }}</button>
                                        @else
                                            <button wire:click="gotoPage({{ $page }})"
                                                class="py-1 px-4 hover:bg-blue-button rounded-full hover:text-white cursor-pointer">{{ $page }}</button>
                                        @endif
                                    @endforeach

                                    <button
                                        class="cursor-pointer py-1 flex items-center px-3 {{ $students->hasMorePages() ? '' : 'hidden' }}"
                                        @if ($students->hasMorePages()) wire:click="gotoPage({{ $students->currentPage() + 1 }})" @endif>
                                        <span class="material-symbols-outlined">
                                            chevron_right
                                        </span>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </section>
    @endif
</div>
