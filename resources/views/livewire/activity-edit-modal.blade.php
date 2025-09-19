<div>
    @if ($isOpen)
        <div
            class="bg-black/30 fixed w-dvw h-dvh top-0 left-0 z-50 backdrop-blur-xs flex justify-center items-center p-10">
            <div class="flex h-full justify-center gap-6">
                <div class="w-180 h-full Addlesson bg-card p-8 rounded-4xl relative">
                    <!-- first form -->
                    <div class="Addlesson w-full h-[100%] flex flex-col gap-8 self-center-safe overflow-y-auto">
                        <div class="flex items-center gap-2">
                            <img src="{{ asset('images/activity-add-icon.png') }}" class="h-8" alt="" />
                            <h1 class="text-3xl font-bold text-heading-dark">
                                Edit Activity
                            </h1>
                        </div>

                        <div class="flex flex-col gap-3">
                            <h2 class="font-semibold text-xl ">Activity Information</h2>
                            <div class="flex flex-col gap-2">
                                <input type="text" placeholder="Activity Name" wire:model.live="activity_name"
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

                        <div class="flex flex-col gap-3 flex-1 min-h-0">
                            <h2 class="font-semibold text-xl">Specialize Learning <span
                                    class="text-paragraph font-normal text-sm">(optional)</span></h2>
                            {{-- Specilize selected Student --}}
                            <div class=" rounded-lg relative flex flex-col gap-2 flex-1 min-h-0">
                                {{-- Header --}}
                                <div class="flex items-center justify-between w-full">
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
                                    <input type="text" placeholder="Search Student" wire:model.live="student_search"
                                        class="w-full outline-none text-heading-dark placeholder-heading-dark" />
                                </div>



                                {{-- Student List --}}
                                <div class="flex-1 min-h-0 flex flex-col gap-1 bg-white rounded-lg p-2">
                                    <div class="flex flex-col gap-1 flex-1 min-h-0 overflow-y-scroll pr-2 rounded-lg">
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
                                            <p
                                                class="text-center text-sm text-gray-500 h-full flex justify-center items-center">
                                                No students found.</p>
                                        @endforelse

                                    </div>
                                </div>
                            </div>{{-- End of Specilize selected Student --}}
                        </div>
                    </div>
                </div>
                <!-- End Add lesson container -->

                <div class="w-180 h-full Addlesson bg-card p-8 rounded-4xl relative">
                    <div class="Addlesson w-full h-[100%] flex flex-col pb-14 self-center-safe overflow-y-auto">
                        <div class="flex items-center gap-2 sticky top-0 left-0 w-full bg-card pb-4">
                            <img src="{{ asset('images/activity-record-icon.png') }}" class="h-8" alt="" />
                            <h1 class="text-3xl font-bold text-heading-dark">
                                Class Activity Record
                            </h1>
                        </div>

                        {{-- Students-con --}}
                        <div class="flex flex-col gap-3 h-full">

                            {{-- Per Student container --}}
                            @forelse ($studentsToRender as $stud)
                                <div
                                    class="flex flex-col gap-4 items-center bg-white rounded-3xl hover:bg-gray-300  cursor-pointer">
                                    {{-- Student profile --}}
                                    <div wire:click="toggleStudentAccordion({{ $stud->id }})"
                                        class=" flex gap-2 items-start justify-between w-full transition-all p-4  duration-200">
                                        <div class="flex gap-2 items-center w-full">
                                            <img src="{{ asset('storage/' . $stud->path) }}"
                                                class="w-12 h-12 aspect-square object-cover rounded-full"
                                                alt="" />
                                            <div class="flex flex-col">
                                                <p class="text-lg font-semibold">
                                                    {{ $stud->fullname }}
                                                </p>
                                                <small class="leading-none text-paragraph">
                                                    {{ ucwords($stud->disability_type) }}
                                                </small>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-6">
                                            <div class="w-45 flex items-center gap-2">
                                                <p class="font-semibold">Attemp:</p>
                                                <input type="number" name="" id=""
                                                    value="{{ count($attempts[$stud->id] ?? [['score' => '', 'time' => '']]) }}"
                                                    readonly
                                                    class="w-full outline-none bg-card px-2 py-1 text-blue-button font-semibold rounded-lg placeholder:text-blue-button"
                                                    placeholder="999">
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <label class="container w-fit">
                                                    <input type="checkbox"
                                                        wire:model="completed.{{ $stud->id }}">
                                                    <div class="checkmark"></div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    @if ($activeStudentId === $stud->id)
                                        <div
                                            class="flex w-full bg-white rounded-b-3xl flex-col gap-2 p-4 border-t-1 border-gray-300">

                                            {{-- Heading --}}
                                            <div class="grid grid-cols-2 w-full">
                                                <h1 class="font-semibold">Score</h1>
                                                <h1 class="font-semibold">Time</h1>
                                            </div>

                                            {{-- input cons --}}
                                            <div class="flex flex-col w-full items-start justify-between gap-2">
                                                @foreach ($attempts[$stud->id] ?? [['score' => '', 'time' => '']] as $index => $attempt)
                                                    <div class="grid grid-cols-2 gap-2 w-full">
                                                        {{-- Score --}}
                                                        <div class="w-full px-4 py-2 rounded-lg bg-card">
                                                            <input type="number"
                                                                wire:model="attempts.{{ $stud->id }}.{{ $index }}.score"
                                                                class="w-full outline-none text-heading-dark"
                                                                placeholder="Enter Score">
                                                        </div>
                                                        {{-- Time --}}
                                                        <div class="w-full px-4 py-2 rounded-lg bg-card">
                                                            <input type="number"
                                                                wire:model="attempts.{{ $stud->id }}.{{ $index }}.time"
                                                                class="w-full outline-none text-heading-dark"
                                                                placeholder="Enter time spent (mins)">
                                                        </div>
                                                    </div>
                                                @endforeach

                                                <div class="flex gap-2 self-end-safe">
                                                    {{-- Add attempt --}}
                                                    <button type="button"
                                                        wire:click="addAttempt({{ $stud->id }})"
                                                        class="px-4 py-2 flex items-center gap-1 bg-white border-1 border-gray-300 rounded-xl hover:bg-blue-button hover:text-white hover:border-blue-button cursor-pointer">
                                                        <span class="material-symbols-rounded">add</span>
                                                        <p class="text-sm">Add Attempt</p>
                                                    </button>

                                                    {{-- Remove attempt --}}
                                                    <button type="button"
                                                        wire:click="removeAttempt({{ $stud->id }})"
                                                        class="px-4 py-2 flex items-center gap-1 bg-white border-1 border-gray-300 rounded-xl hover:bg-red-500 hover:text-white hover:border-red-500 cursor-pointer">
                                                        <span class="material-symbols-rounded">delete</span>
                                                        <p class="text-sm">Delete</p>
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    @endif
                                </div>
                            @empty
                                <div
                                    class="flex flex-col items-center justify-center gap-4 py-12 bg-white rounded-2xl shadow-inner h-full">
                                    <h2 class="text-lg font-semibold text-heading-dark">No Students Found</h2>
                                    <p class="text-paragraph text-center">Add students to see their activity records
                                        here.</p>
                                </div>
                            @endforelse

                        </div>
                    </div>

                    <div
                        class="flex items-center gap-2 absolute w-full left-0 bottom-0 px-8 pb-8 pt-4 rounded-b-4xl bg-card">
                        <button wire:click='closeModal' type="button"
                            class="bg-white py-1.5 px-3 w-full rounded-xl text-heading-dark font-medium hover:bg-gray-300 cursor-pointer">
                            Cancel
                        </button>
                        <button type="button" wire:click='editActivity'
                            class="bg-blue-button py-1.5 px-3 w-full rounded-xl text-white font-medium cursor-pointer hover:bg-blue-700">
                            Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
