<div>
    @if ($isOpen)
        <div
            class="bg-black/30 fixed w-dvw h-dvh top-0 left-0 z-50 backdrop-blur-xs flex justify-center items-center p-10">
            <div class="w-180 h-full flex flex-col bg-card p-8 rounded-4xl relative gap-8 ">
                <form wire:submit='moveUp' class="w-full h-full flex flex-col gap-8 overflow-auto Addlesson">
                    <div class=" w-full flex items-center justify-between gap-4">
                        <div class="flex items-center gap-2">
                            <img src="{{ asset('images/move-up-icon.png') }}" alt="" class="h-8" />
                            <h1 class="text-3xl font-bold text-heading-dark">
                                Move Up Student
                            </h1>
                        </div>

                        <div>
                            <div
                                class="flex items-center bg-white py-1 px-2 rounded-full shadow-2xl/15 border-2 border-white hover:border-blue-button text-paragraph hover:bg-blue-button hover:text-white cursor-pointer">
                                <select class="w-max outline-none" wire:model.live="grade_level">
                                    <option value="" class=" text-heading-dark" disabled>Grade Level</option>
                                    <option value="all" class=" text-heading-dark">All</option>
                                    @foreach ($gradeLevelOptions as $level)
                                        <option value="{{ $level }}" class=" text-heading-dark">
                                            {{ ucwords($level) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="flex flex-col gap-3 h-full">
                        <h2 class="font-semibold text-2xl">Students</h2>
                        <div class="flex flex-col gap-2 h-full mb-16">
                            {{-- Specialization checkbox --}}
                            <div class="rounded-lg flex flex-col h-full gap-2">
                                {{-- Header --}}
                                <div class="flex items-center justify-between w-full mb-2">
                                    <p class="text-paragraph">Select Students you want to move up.</p>
                                    <button type="button" wire:click="clearStudents"
                                        class="flex items-center justify-center gap-1 px-3 py-1 rounded-lg text-paragraph hover:text-white cursor-pointer bg-white hover:bg-blue-button">
                                        <p class="text-sm">Clear Selected</p>
                                        <span class="material-symbols-rounded">clear_all</span>
                                    </button>
                                </div>

                                {{-- Search --}}
                                <div class="flex items-center gap-2 px-4 py-2 rounded-4xl bg-white w-full">
                                    <span class="material-symbols-rounded">person_search</span>
                                    <input type="text" placeholder="Search Student" wire:model.live="student_search"
                                        class="w-full outline-none text-paragraph placeholder-paragraph" />
                                </div>

                                {{-- Specialization List --}}
                                <div class="h-full flex flex-col gap-1 bg-white p-6 rounded-4xl">
                                    <div class="flex flex-col gap-1 h-full overflow-y-scroll pr-2 rounded-lg">

                                        @forelse($students as $student)
                                            <div
                                                class="flex items-center gap-2 w-full p-2 hover:bg-card rounded-lg cursor-pointer">
                                                <label class="container w-fit">
                                                    <input type="checkbox" value="{{ $student->id }}"
                                                        wire:model="selectedStudents">
                                                    <div class="checkmark"></div>
                                                </label>
                                                <p class="w-full text-paragraph">{{ $student->full_name }}</p>
                                            </div>
                                        @empty
                                            <p
                                                class="text-center text-sm text-gray-500 h-full flex justify-center items-center">
                                                No students found.
                                            </p>
                                        @endforelse
                                        {{-- <p class="text-center text-sm text-gray-500 h-full flex justify-center items-center">No Specialization found.</p> --}}

                                    </div>
                                </div>
                            </div>{{-- End of Specialization checkbox --}}
                        </div>
                    </div>
                    <!-- buttons -->
                    <div
                        class="flex items-center gap-2 absolute w-full left-0 bottom-0 px-8 pb-8 pt-4 rounded-b-4xl bg-card">
                        <button wire:click='closeModal' type="button"
                            class="bg-white py-1.5 px-3 w-full rounded-xl text-heading-dark font-medium hover:bg-gray-300 cursor-pointer">
                            Cancel
                        </button>
                        <button type="submit"
                            class="bg-blue-button py-1.5 px-3 w-full rounded-xl text-white font-medium cursor-pointer hover:bg-blue-700">
                            Move Up
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
