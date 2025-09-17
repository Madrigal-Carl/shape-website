<div>
    @if ($isOpen)
        <div
            class="bg-black/30 fixed w-dvw h-dvh top-0 left-0 z-50 backdrop-blur-xs flex justify-center items-center p-10">
            <!-- Add lesson container -->
            <form wire:submit='addLesson' class="flex h-full justify-center gap-6">
                <div class="w-180 h-full Addlesson bg-card p-8 rounded-4xl relative">
                    <!-- first form -->
                    <div class="Addlesson w-full h-[100%] flex flex-col gap-8 self-center-safe overflow-y-auto">
                        <div class="flex items-center gap-2">
                            <img src="{{ asset('images/activity-add-icon.png') }}" class="h-8" alt="" />
                            <h1 class="text-3xl font-bold text-heading-dark">
                                Add Activity
                            </h1>
                        </div>

                        <div class="flex flex-col gap-3">
                            <h2 class="font-semibold text-xl ">Activity Information</h2>
                            <div class="flex flex-col gap-2">
                                <input type="text" placeholder="Lesson Name" wire:model.live="lesson_name"
                                    class="px-4 py-2 rounded-lg bg-white placeholder-paragraph outline-none w-full" />

                                <div class="px-4 py-2 rounded-lg bg-white">
                                    <select wire:model.live="grade_level" name="" id=""
                                        class="w-full outline-none text-paragraph">
                                        <option value="" class="text-sm text-black" selected disabled>
                                            Grade & Section
                                        </option>
                                        <option class="text-sm text-paragraph">
                                            Kindergarten
                                        </option>
                                    </select>
                                </div>
                                <div class="flex items-center gap-2 w-full">
                                    <div class="px-4 py-2 rounded-lg bg-white w-full">
                                        <select name="" id=""
                                            class="w-full outline-none text-paragraph">
                                            <option value="" class="text-sm text-black" selected disabled>
                                                Curriculum
                                            </option>
                                            <option class="text-sm text-paragraph">
                                                FSL Curriculum
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 w-full">
                                    <div class="px-4 py-2 rounded-lg bg-white w-full">
                                        <select name="" id=""
                                            class="w-full outline-none text-paragraph">
                                            <option value="" class="text-sm text-black" selected disabled>
                                                Subject
                                            </option>
                                            <option class="text-sm text-paragraph">
                                                Mathematics
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <textarea name="" id="" maxlength="200" placeholder="Description (Optional)"
                                    class="px-3 py-2 rounded-lg bg-white placeholder-paragraph resize-none h-24 outline-none"></textarea>
                            </div>
                        </div>

                        <div class="flex flex-col gap-3 flex-1 min-h-0">
                            <h2 class="font-semibold text-xl">Specialize Learning <span
                                    class="text-paragraph font-normal text-sm">(optional)</span></h2>
                            {{-- Specilize selected Student --}}
                            <div class=" rounded-lg relative flex flex-col gap-2 flex-1 min-h-0">
                                {{-- Header --}}
                                <div class="flex items-center justify-between w-full">
                                    <p class="text-paragraph">Select Student for specialize learning.</p>
                                    <button type="button"
                                        class="flex items-center justify-center gap-1 px-3 py-2 rounded-lg text-paragraph hover:text-white cursor-pointer bg-white hover:bg-blue-button">
                                        <p class="text-sm">Clear All</p>
                                        <span class="material-symbols-rounded">clear_all</span>
                                    </button>
                                </div>

                                {{-- Search --}}
                                <div class="flex items-center gap-2 px-4 py-2 rounded-lg bg-white w-full">
                                    <span class="material-symbols-rounded">person_search</span>
                                    <input type="text" placeholder="Search Student" wire:model.live="student_search"
                                        class="w-full outline-none text-paragraph placeholder-paragraph" />
                                </div>



                                {{-- Student List --}}
                                <div class="flex-1 min-h-0 bg-white rounded-lg p-2">
                                    <div class="flex flex-col gap-1 h-full overflow-y-scroll pr-2 rounded-lg">
                                        <div
                                            class="flex items-center gap-2 w-full p-2 hover:bg-card rounded-lg cursor-pointer">
                                            <label class="container w-fit">
                                                <input type="checkbox">
                                                <div class="checkmark"></div>
                                            </label>
                                            <p class="w-full text-paragraph">Carl Madrigal</p>
                                        </div>

                                        {{-- <p
                                                class="text-center text-sm text-gray-500 h-full flex justify-center items-center">
                                                No students found.</p> --}}
                                    </div>
                                </div>
                            </div>{{-- End of Specilize selected Student --}}
                        </div>
                    </div>
                </div>
                <!-- End Add lesson container -->

                <div class="w-180 h-full Addlesson bg-card p-8 rounded-4xl relative">
                    <div class="Addlesson w-full h-[100%] flex flex-col pb-16 gap-4 self-center-safe overflow-y-auto">
                        <div class="flex items-center gap-2 sticky top-0 left-0 w-full bg-card pb-4">
                            <img src="{{ asset('images/activity-record-icon.png') }}" class="h-8" alt="" />
                            <h1 class="text-3xl font-bold text-heading-dark">
                                Class Activity Record
                            </h1>
                        </div>

                        {{-- Students-con --}}
                        <div class="flex flex-col gap-3">

                            {{-- Individual Student Con --}}
                            <div class="flex flex-col gap-4 items-center bg-white rounded-2xl p-4">
                                {{-- Student profile --}}
                                <div class="flex gap-2 items-start  justify-between bg-white w-full">
                                    <div class="flex gap-2 items-center w-full">
                                        <img src="{{ asset('storage/' . auth()->user()->accountable->path) }}"
                                            class="w-12 h-12 aspect-square object-cover rounded-full" alt="" />
                                        <div class="flex flex-col">
                                            <p class="text-lg">
                                                <span
                                                    class="font-semibold leading-none">{{ auth()->user()->accountable->last_name }},
                                                </span>{{ auth()->user()->accountable->first_name }}
                                            </p>
                                            <small class="leading-none text-paragraph">
                                                Hearing Impaired
                                            </small>
                                        </div>

                                    </div>
                                    <div class="w-45 flex items-center gap-2">
                                        <p class="font-semibold">Attemp:</p>
                                        <input type="number" name="" id=""
                                            class="w-full outline-none bg-card px-2 py-1 text-blue-button font-semibold rounded-lg placeholder:text-blue-button"
                                            placeholder="999">
                                    </div>
                                </div>

                                {{-- Inputs (score, time) note: Make this flex for accordion --}}
                                <div class="hidden w-full flex-col gap-2 pt-4 border-t-1 border-gray-300">

                                    {{-- Heading --}}
                                    <div class="grid grid-cols-2 w-full">
                                        <h1 class="font-semibold">Score</h1>
                                        <h1 class="font-semibold">Time</h1>
                                    </div>

                                    {{-- input cons --}}
                                    <div class="flex flex-col w-full items-start justify-between gap-2">

                                        {{-- Indiv cons --}}
                                        <div class="grid grid-cols-2 gap-2 w-full">
                                            {{-- Score --}}
                                            <div class="w-full px-4 py-2 rounded-lg bg-card">
                                                <input type="number" name="" id=""
                                                    class="w-full outline-none text-heading-dark"
                                                    placeholder="Enter Score">
                                            </div>

                                            {{-- Time --}}
                                            <div class="w-full px-4 py-2 rounded-lg bg-card">
                                                <input type="number" name="" id=""
                                                    class="w-full outline-none text-heading-dark"
                                                    placeholder="Enter time spent">
                                            </div>
                                        </div>

                                        {{-- Indiv cons --}}
                                        <div class="grid grid-cols-2 gap-2 w-full">
                                            {{-- Score --}}
                                            <div class="w-full px-4 py-2 rounded-lg bg-card">
                                                <input type="number" name="" id=""
                                                    class="w-full outline-none text-heading-dark"
                                                    placeholder="Enter Score">
                                            </div>

                                            {{-- Time --}}
                                            <div class="w-full px-4 py-2 rounded-lg bg-card">
                                                <input type="number" name="" id=""
                                                    class="w-full outline-none text-heading-dark"
                                                    placeholder="Enter time spent">
                                            </div>
                                        </div>

                                        {{-- Indiv cons --}}
                                        <div class="grid grid-cols-2 gap-2 w-full">
                                            {{-- Score --}}
                                            <div class="w-full px-4 py-2 rounded-lg bg-card">
                                                <input type="number" name="" id=""
                                                    class="w-full outline-none text-heading-dark"
                                                    placeholder="Enter Score">
                                            </div>

                                            {{-- Time --}}
                                            <div class="w-full px-4 py-2 rounded-lg bg-card">
                                                <input type="number" name="" id=""
                                                    class="w-full outline-none text-heading-dark"
                                                    placeholder="Enter time spent">
                                            </div>

                                        </div>

                                        <button
                                            class="self-end-safe px-4 py-2 flex items-center gap-1 bg-white border-1 border-gray-300 rounded-xl hover:bg-blue-button hover:text-white hover:border-blue-button cursor-pointer">
                                            <span class="material-symbols-rounded">
                                                add
                                            </span>
                                            <p class="text-sm">Add Attemp</p>
                                        </button>
                                    </div>

                                </div>
                            </div>


                            {{-- Individual Student Con --}}
                            <div class="flex flex-col gap-4 items-center bg-white rounded-2xl p-4">
                                {{-- Student profile --}}
                                <div class="flex gap-2 items-start  justify-between bg-white w-full">
                                    <div class="flex gap-2 items-center w-full">
                                        <img src="{{ asset('storage/' . auth()->user()->accountable->path) }}"
                                            class="w-12 h-12 aspect-square object-cover rounded-full"
                                            alt="" />
                                        <div class="flex flex-col">
                                            <p class="text-lg">
                                                <span
                                                    class="font-semibold leading-none">{{ auth()->user()->accountable->last_name }},
                                                </span>{{ auth()->user()->accountable->first_name }}
                                            </p>
                                            <small class="leading-none text-paragraph">
                                                Hearing Impaired
                                            </small>
                                        </div>

                                    </div>
                                    <div class="w-45 flex items-center gap-2">
                                        <p class="font-semibold">Attemp:</p>
                                        <input type="number" name="" id=""
                                            class="w-full outline-none bg-card px-2 py-1 text-blue-button font-semibold rounded-lg placeholder:text-blue-button"
                                            placeholder="999">
                                    </div>
                                </div>

                                {{-- Inputs (score, time) --}}
                                <div class="flex w-full flex-col gap-2 pt-4 border-t-1 border-gray-300">
                                    {{-- Heading --}}
                                    <div class="grid grid-cols-2 w-full">
                                        <h1 class="font-semibold">Score</h1>
                                        <h1 class="font-semibold">Time</h1>
                                    </div>

                                    {{-- input cons --}}
                                    <div class="flex flex-col w-full items-start justify-between gap-2">

                                        {{-- Indiv cons --}}
                                        <div class="grid grid-cols-2 gap-2 w-full">
                                            {{-- Score --}}
                                            <div class="w-full px-4 py-2 rounded-lg bg-card">
                                                <input type="number" name="" id=""
                                                    class="w-full outline-none text-heading-dark"
                                                    placeholder="Enter Score">
                                            </div>

                                            {{-- Time --}}
                                            <div class="w-full px-4 py-2 rounded-lg bg-card">
                                                <input type="number" name="" id=""
                                                    class="w-full outline-none text-heading-dark"
                                                    placeholder="Enter time spent">
                                            </div>
                                        </div>

                                        {{-- Indiv cons --}}
                                        <div class="grid grid-cols-2 gap-2 w-full">
                                            {{-- Score --}}
                                            <div class="w-full px-4 py-2 rounded-lg bg-card">
                                                <input type="number" name="" id=""
                                                    class="w-full outline-none text-heading-dark"
                                                    placeholder="Enter Score">
                                            </div>

                                            {{-- Time --}}
                                            <div class="w-full px-4 py-2 rounded-lg bg-card">
                                                <input type="number" name="" id=""
                                                    class="w-full outline-none text-heading-dark"
                                                    placeholder="Enter time spent">
                                            </div>
                                        </div>

                                        {{-- Indiv cons --}}
                                        <div class="grid grid-cols-2 gap-2 w-full">
                                            {{-- Score --}}
                                            <div class="w-full px-4 py-2 rounded-lg bg-card">
                                                <input type="number" name="" id=""
                                                    class="w-full outline-none text-heading-dark"
                                                    placeholder="Enter Score">
                                            </div>

                                            {{-- Time --}}
                                            <div class="w-full px-4 py-2 rounded-lg bg-card">
                                                <input type="number" name="" id=""
                                                    class="w-full outline-none text-heading-dark"
                                                    placeholder="Enter time spent">
                                            </div>

                                        </div>

                                        <button
                                            class="self-end-safe px-4 py-2 flex items-center gap-1 bg-white border-1 border-gray-300 rounded-xl hover:bg-blue-button hover:text-white hover:border-blue-button cursor-pointer">
                                            <span class="material-symbols-rounded">
                                                add
                                            </span>
                                            <p class="text-sm">Add Attemp</p>
                                        </button>
                                    </div>

                                </div>
                            </div>


                            {{-- Individual Student Con --}}
                            <div class="flex flex-col gap-4 items-center bg-white rounded-2xl p-4">
                                {{-- Student profile --}}
                                <div class="flex gap-2 items-start  justify-between bg-white w-full">
                                    <div class="flex gap-2 items-center w-full">
                                        <img src="{{ asset('storage/' . auth()->user()->accountable->path) }}"
                                            class="w-12 h-12 aspect-square object-cover rounded-full"
                                            alt="" />
                                        <div class="flex flex-col">
                                            <p class="text-lg">
                                                <span
                                                    class="font-semibold leading-none">{{ auth()->user()->accountable->last_name }},
                                                </span>{{ auth()->user()->accountable->first_name }}
                                            </p>
                                            <small class="leading-none text-paragraph">
                                                Hearing Impaired
                                            </small>
                                        </div>

                                    </div>
                                    <div class="w-45 flex items-center gap-2">
                                        <p class="font-semibold">Attemp:</p>
                                        <input type="number" name="" id=""
                                            class="w-full outline-none bg-card px-2 py-1 text-blue-button font-semibold rounded-lg placeholder:text-blue-button"
                                            placeholder="999">
                                    </div>
                                </div>

                                {{-- Inputs (score, time) --}}
                                <div class="flex w-full flex-col gap-2 pt-4 border-t-1 border-gray-300">
                                    {{-- Heading --}}
                                    <div class="grid grid-cols-2 w-full">
                                        <h1 class="font-semibold">Score</h1>
                                        <h1 class="font-semibold">Time</h1>
                                    </div>

                                    {{-- input cons --}}
                                    <div class="flex flex-col w-full items-start justify-between gap-2">

                                        {{-- Indiv cons --}}
                                        <div class="grid grid-cols-2 gap-2 w-full">
                                            {{-- Score --}}
                                            <div class="w-full px-4 py-2 rounded-lg bg-card">
                                                <input type="number" name="" id=""
                                                    class="w-full outline-none text-heading-dark"
                                                    placeholder="Enter Score">
                                            </div>

                                            {{-- Time --}}
                                            <div class="w-full px-4 py-2 rounded-lg bg-card">
                                                <input type="number" name="" id=""
                                                    class="w-full outline-none text-heading-dark"
                                                    placeholder="Enter time spent">
                                            </div>
                                        </div>

                                        {{-- Indiv cons --}}
                                        <div class="grid grid-cols-2 gap-2 w-full">
                                            {{-- Score --}}
                                            <div class="w-full px-4 py-2 rounded-lg bg-card">
                                                <input type="number" name="" id=""
                                                    class="w-full outline-none text-heading-dark"
                                                    placeholder="Enter Score">
                                            </div>

                                            {{-- Time --}}
                                            <div class="w-full px-4 py-2 rounded-lg bg-card">
                                                <input type="number" name="" id=""
                                                    class="w-full outline-none text-heading-dark"
                                                    placeholder="Enter time spent">
                                            </div>
                                        </div>

                                        {{-- Indiv cons --}}
                                        <div class="grid grid-cols-2 gap-2 w-full">
                                            {{-- Score --}}
                                            <div class="w-full px-4 py-2 rounded-lg bg-card">
                                                <input type="number" name="" id=""
                                                    class="w-full outline-none text-heading-dark"
                                                    placeholder="Enter Score">
                                            </div>

                                            {{-- Time --}}
                                            <div class="w-full px-4 py-2 rounded-lg bg-card">
                                                <input type="number" name="" id=""
                                                    class="w-full outline-none text-heading-dark"
                                                    placeholder="Enter time spent">
                                            </div>

                                        </div>

                                        <button
                                            class="self-end-safe px-4 py-2 flex items-center gap-1 bg-white border-1 border-gray-300 rounded-xl hover:bg-blue-button hover:text-white hover:border-blue-button cursor-pointer">
                                            <span class="material-symbols-rounded">
                                                add
                                            </span>
                                            <p class="text-sm">Add Attemp</p>
                                        </button>
                                    </div>

                                </div>
                            </div>


                            {{-- Individual Student Con --}}
                            <div class="flex flex-col gap-4 items-center bg-white rounded-2xl p-4">
                                {{-- Student profile --}}
                                <div class="flex gap-2 items-start  justify-between bg-white w-full">
                                    <div class="flex gap-2 items-center w-full">
                                        <img src="{{ asset('storage/' . auth()->user()->accountable->path) }}"
                                            class="w-12 h-12 aspect-square object-cover rounded-full"
                                            alt="" />
                                        <div class="flex flex-col">
                                            <p class="text-lg">
                                                <span
                                                    class="font-semibold leading-none">{{ auth()->user()->accountable->last_name }},
                                                </span>{{ auth()->user()->accountable->first_name }}
                                            </p>
                                            <small class="leading-none text-paragraph">
                                                Hearing Impaired
                                            </small>
                                        </div>

                                    </div>
                                    <div class="w-45 flex items-center gap-2">
                                        <p class="font-semibold">Attemp:</p>
                                        <input type="number" name="" id=""
                                            class="w-full outline-none bg-card px-2 py-1 text-blue-button font-semibold rounded-lg placeholder:text-blue-button"
                                            placeholder="999">
                                    </div>
                                </div>

                                {{-- Inputs (score, time) --}}
                                <div class="flex w-full flex-col gap-2 pt-4 border-t-1 border-gray-300">
                                    {{-- Heading --}}
                                    <div class="grid grid-cols-2 w-full">
                                        <h1 class="font-semibold">Score</h1>
                                        <h1 class="font-semibold">Time</h1>
                                    </div>

                                    {{-- input cons --}}
                                    <div class="flex flex-col w-full items-start justify-between gap-2">

                                        {{-- Indiv cons --}}
                                        <div class="grid grid-cols-2 gap-2 w-full">
                                            {{-- Score --}}
                                            <div class="w-full px-4 py-2 rounded-lg bg-card">
                                                <input type="number" name="" id=""
                                                    class="w-full outline-none text-heading-dark"
                                                    placeholder="Enter Score">
                                            </div>

                                            {{-- Time --}}
                                            <div class="w-full px-4 py-2 rounded-lg bg-card">
                                                <input type="number" name="" id=""
                                                    class="w-full outline-none text-heading-dark"
                                                    placeholder="Enter time spent">
                                            </div>
                                        </div>

                                        {{-- Indiv cons --}}
                                        <div class="grid grid-cols-2 gap-2 w-full">
                                            {{-- Score --}}
                                            <div class="w-full px-4 py-2 rounded-lg bg-card">
                                                <input type="number" name="" id=""
                                                    class="w-full outline-none text-heading-dark"
                                                    placeholder="Enter Score">
                                            </div>

                                            {{-- Time --}}
                                            <div class="w-full px-4 py-2 rounded-lg bg-card">
                                                <input type="number" name="" id=""
                                                    class="w-full outline-none text-heading-dark"
                                                    placeholder="Enter time spent">
                                            </div>
                                        </div>

                                        {{-- Indiv cons --}}
                                        <div class="grid grid-cols-2 gap-2 w-full">
                                            {{-- Score --}}
                                            <div class="w-full px-4 py-2 rounded-lg bg-card">
                                                <input type="number" name="" id=""
                                                    class="w-full outline-none text-heading-dark"
                                                    placeholder="Enter Score">
                                            </div>

                                            {{-- Time --}}
                                            <div class="w-full px-4 py-2 rounded-lg bg-card">
                                                <input type="number" name="" id=""
                                                    class="w-full outline-none text-heading-dark"
                                                    placeholder="Enter time spent">
                                            </div>

                                        </div>

                                        <button
                                            class="self-end-safe px-4 py-2 flex items-center gap-1 bg-white border-1 border-gray-300 rounded-xl hover:bg-blue-button hover:text-white hover:border-blue-button cursor-pointer">
                                            <span class="material-symbols-rounded">
                                                add
                                            </span>
                                            <p class="text-sm">Add Attemp</p>
                                        </button>
                                    </div>

                                </div>
                            </div>


                            {{-- Individual Student Con --}}
                            <div class="flex flex-col gap-4 items-center bg-white rounded-2xl p-4">
                                {{-- Student profile --}}
                                <div class="flex gap-2 items-start  justify-between bg-white w-full">
                                    <div class="flex gap-2 items-center w-full">
                                        <img src="{{ asset('storage/' . auth()->user()->accountable->path) }}"
                                            class="w-12 h-12 aspect-square object-cover rounded-full"
                                            alt="" />
                                        <div class="flex flex-col">
                                            <p class="text-lg">
                                                <span
                                                    class="font-semibold leading-none">{{ auth()->user()->accountable->last_name }},
                                                </span>{{ auth()->user()->accountable->first_name }}
                                            </p>
                                            <small class="leading-none text-paragraph">
                                                Hearing Impaired
                                            </small>
                                        </div>

                                    </div>
                                    <div class="w-45 flex items-center gap-2">
                                        <p class="font-semibold">Attemp:</p>
                                        <input type="number" name="" id=""
                                            class="w-full outline-none bg-card px-2 py-1 text-blue-button font-semibold rounded-lg placeholder:text-blue-button"
                                            placeholder="999">
                                    </div>
                                </div>

                                {{-- Inputs (score, time) --}}
                                <div class="flex w-full flex-col gap-2 pt-4 border-t-1 border-gray-300">
                                    {{-- Heading --}}
                                    <div class="grid grid-cols-2 w-full">
                                        <h1 class="font-semibold">Score</h1>
                                        <h1 class="font-semibold">Time</h1>
                                    </div>

                                    {{-- input cons --}}
                                    <div class="flex flex-col w-full items-start justify-between gap-2">

                                        {{-- Indiv cons --}}
                                        <div class="grid grid-cols-2 gap-2 w-full">
                                            {{-- Score --}}
                                            <div class="w-full px-4 py-2 rounded-lg bg-card">
                                                <input type="number" name="" id=""
                                                    class="w-full outline-none text-heading-dark"
                                                    placeholder="Enter Score">
                                            </div>

                                            {{-- Time --}}
                                            <div class="w-full px-4 py-2 rounded-lg bg-card">
                                                <input type="number" name="" id=""
                                                    class="w-full outline-none text-heading-dark"
                                                    placeholder="Enter time spent">
                                            </div>
                                        </div>

                                        {{-- Indiv cons --}}
                                        <div class="grid grid-cols-2 gap-2 w-full">
                                            {{-- Score --}}
                                            <div class="w-full px-4 py-2 rounded-lg bg-card">
                                                <input type="number" name="" id=""
                                                    class="w-full outline-none text-heading-dark"
                                                    placeholder="Enter Score">
                                            </div>

                                            {{-- Time --}}
                                            <div class="w-full px-4 py-2 rounded-lg bg-card">
                                                <input type="number" name="" id=""
                                                    class="w-full outline-none text-heading-dark"
                                                    placeholder="Enter time spent">
                                            </div>
                                        </div>

                                        {{-- Indiv cons --}}
                                        <div class="grid grid-cols-2 gap-2 w-full">
                                            {{-- Score --}}
                                            <div class="w-full px-4 py-2 rounded-lg bg-card">
                                                <input type="number" name="" id=""
                                                    class="w-full outline-none text-heading-dark"
                                                    placeholder="Enter Score">
                                            </div>

                                            {{-- Time --}}
                                            <div class="w-full px-4 py-2 rounded-lg bg-card">
                                                <input type="number" name="" id=""
                                                    class="w-full outline-none text-heading-dark"
                                                    placeholder="Enter time spent">
                                            </div>

                                        </div>

                                        <button
                                            class="self-end-safe px-4 py-2 flex items-center gap-1 bg-white border-1 border-gray-300 rounded-xl hover:bg-blue-button hover:text-white hover:border-blue-button cursor-pointer">
                                            <span class="material-symbols-rounded">
                                                add
                                            </span>
                                            <p class="text-sm">Add Attemp</p>
                                        </button>
                                    </div>

                                </div>
                            </div>


                            {{-- Individual Student Con --}}
                            <div class="flex flex-col gap-4 items-center bg-white rounded-2xl p-4">
                                {{-- Student profile --}}
                                <div class="flex gap-2 items-start  justify-between bg-white w-full">
                                    <div class="flex gap-2 items-center w-full">
                                        <img src="{{ asset('storage/' . auth()->user()->accountable->path) }}"
                                            class="w-12 h-12 aspect-square object-cover rounded-full"
                                            alt="" />
                                        <div class="flex flex-col">
                                            <p class="text-lg">
                                                <span
                                                    class="font-semibold leading-none">{{ auth()->user()->accountable->last_name }},
                                                </span>{{ auth()->user()->accountable->first_name }}
                                            </p>
                                            <small class="leading-none text-paragraph">
                                                Hearing Impaired
                                            </small>
                                        </div>

                                    </div>
                                    <div class="w-45 flex items-center gap-2">
                                        <p class="font-semibold">Attemp:</p>
                                        <input type="number" name="" id=""
                                            class="w-full outline-none bg-card px-2 py-1 text-blue-button font-semibold rounded-lg placeholder:text-blue-button"
                                            placeholder="999">
                                    </div>
                                </div>

                                {{-- Inputs (score, time) --}}
                                <div class="flex w-full flex-col gap-2 pt-4 border-t-1 border-gray-300">
                                    {{-- Heading --}}
                                    <div class="grid grid-cols-2 w-full">
                                        <h1 class="font-semibold">Score</h1>
                                        <h1 class="font-semibold">Time</h1>
                                    </div>

                                    {{-- input cons --}}
                                    <div class="flex flex-col w-full items-start justify-between gap-2">

                                        {{-- Indiv cons --}}
                                        <div class="grid grid-cols-2 gap-2 w-full">
                                            {{-- Score --}}
                                            <div class="w-full px-4 py-2 rounded-lg bg-card">
                                                <input type="number" name="" id=""
                                                    class="w-full outline-none text-heading-dark"
                                                    placeholder="Enter Score">
                                            </div>

                                            {{-- Time --}}
                                            <div class="w-full px-4 py-2 rounded-lg bg-card">
                                                <input type="number" name="" id=""
                                                    class="w-full outline-none text-heading-dark"
                                                    placeholder="Enter time spent">
                                            </div>
                                        </div>

                                        {{-- Indiv cons --}}
                                        <div class="grid grid-cols-2 gap-2 w-full">
                                            {{-- Score --}}
                                            <div class="w-full px-4 py-2 rounded-lg bg-card">
                                                <input type="number" name="" id=""
                                                    class="w-full outline-none text-heading-dark"
                                                    placeholder="Enter Score">
                                            </div>

                                            {{-- Time --}}
                                            <div class="w-full px-4 py-2 rounded-lg bg-card">
                                                <input type="number" name="" id=""
                                                    class="w-full outline-none text-heading-dark"
                                                    placeholder="Enter time spent">
                                            </div>
                                        </div>

                                        {{-- Indiv cons --}}
                                        <div class="grid grid-cols-2 gap-2 w-full">
                                            {{-- Score --}}
                                            <div class="w-full px-4 py-2 rounded-lg bg-card">
                                                <input type="number" name="" id=""
                                                    class="w-full outline-none text-heading-dark"
                                                    placeholder="Enter Score">
                                            </div>

                                            {{-- Time --}}
                                            <div class="w-full px-4 py-2 rounded-lg bg-card">
                                                <input type="number" name="" id=""
                                                    class="w-full outline-none text-heading-dark"
                                                    placeholder="Enter time spent">
                                            </div>

                                        </div>

                                        <button
                                            class="self-end-safe px-4 py-2 flex items-center gap-1 bg-white border-1 border-gray-300 rounded-xl hover:bg-blue-button hover:text-white hover:border-blue-button cursor-pointer">
                                            <span class="material-symbols-rounded">
                                                add
                                            </span>
                                            <p class="text-sm">Add Attemp</p>
                                        </button>
                                    </div>

                                </div>
                            </div>

                            {{-- Individual Student Con --}}
                            <div class="flex flex-col gap-4 items-center bg-white rounded-2xl p-4">
                                {{-- Student profile --}}
                                <div class="flex gap-2 items-start  justify-between bg-white w-full">
                                    <div class="flex gap-2 items-center w-full">
                                        <img src="{{ asset('storage/' . auth()->user()->accountable->path) }}"
                                            class="w-12 h-12 aspect-square object-cover rounded-full"
                                            alt="" />
                                        <div class="flex flex-col">
                                            <p class="text-lg">
                                                <span
                                                    class="font-semibold leading-none">{{ auth()->user()->accountable->last_name }},
                                                </span>{{ auth()->user()->accountable->first_name }}
                                            </p>
                                            <small class="leading-none text-paragraph">
                                                Hearing Impaired
                                            </small>
                                        </div>

                                    </div>
                                    <div class="w-45 flex items-center gap-2">
                                        <p class="font-semibold">Attemp:</p>
                                        <input type="number" name="" id=""
                                            class="w-full outline-none bg-card px-2 py-1 text-blue-button font-semibold rounded-lg placeholder:text-blue-button"
                                            placeholder="999">
                                    </div>
                                </div>

                                {{-- Inputs (score, time) --}}
                                <div class="flex w-full flex-col gap-2 pt-4 border-t-1 border-gray-300">
                                    {{-- Heading --}}
                                    <div class="grid grid-cols-2 w-full">
                                        <h1 class="font-semibold">Score</h1>
                                        <h1 class="font-semibold">Time</h1>
                                    </div>

                                    {{-- input cons --}}
                                    <div class="flex flex-col w-full items-start justify-between gap-2">

                                        {{-- Indiv cons --}}
                                        <div class="grid grid-cols-2 gap-2 w-full">
                                            {{-- Score --}}
                                            <div class="w-full px-4 py-2 rounded-lg bg-card">
                                                <input type="number" name="" id=""
                                                    class="w-full outline-none text-heading-dark"
                                                    placeholder="Enter Score">
                                            </div>

                                            {{-- Time --}}
                                            <div class="w-full px-4 py-2 rounded-lg bg-card">
                                                <input type="number" name="" id=""
                                                    class="w-full outline-none text-heading-dark"
                                                    placeholder="Enter time spent">
                                            </div>
                                        </div>

                                        {{-- Indiv cons --}}
                                        <div class="grid grid-cols-2 gap-2 w-full">
                                            {{-- Score --}}
                                            <div class="w-full px-4 py-2 rounded-lg bg-card">
                                                <input type="number" name="" id=""
                                                    class="w-full outline-none text-heading-dark"
                                                    placeholder="Enter Score">
                                            </div>

                                            {{-- Time --}}
                                            <div class="w-full px-4 py-2 rounded-lg bg-card">
                                                <input type="number" name="" id=""
                                                    class="w-full outline-none text-heading-dark"
                                                    placeholder="Enter time spent">
                                            </div>
                                        </div>

                                        {{-- Indiv cons --}}
                                        <div class="grid grid-cols-2 gap-2 w-full">
                                            {{-- Score --}}
                                            <div class="w-full px-4 py-2 rounded-lg bg-card">
                                                <input type="number" name="" id=""
                                                    class="w-full outline-none text-heading-dark"
                                                    placeholder="Enter Score">
                                            </div>

                                            {{-- Time --}}
                                            <div class="w-full px-4 py-2 rounded-lg bg-card">
                                                <input type="number" name="" id=""
                                                    class="w-full outline-none text-heading-dark"
                                                    placeholder="Enter time spent">
                                            </div>

                                        </div>

                                        <button
                                            class="self-end-safe px-4 py-2 flex items-center gap-1 bg-white border-1 border-gray-300 rounded-xl hover:bg-blue-button hover:text-white hover:border-blue-button cursor-pointer">
                                            <span class="material-symbols-rounded">
                                                add
                                            </span>
                                            <p class="text-sm">Add Attemp</p>
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
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
</div>
@endif
</div>
