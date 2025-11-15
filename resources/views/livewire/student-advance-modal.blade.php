<div>
    @if ($isOpen)
        <div
            class="bg-black/40 fixed w-dvw h-dvh top-0 left-0 z-50 backdrop-blur-xs flex justify-center items-center p-10">
            <div class="w-180 h-full flex flex-col bg-card p-8 rounded-4xl relative gap-8 ">
                <form wire:submit='advanceStudents' class="w-full h-full flex flex-col gap-8 overflow-auto Addlesson">
                    <div class=" w-full flex items-center justify-between gap-4">
                        <div class="flex items-center gap-2">
                            <img src="{{ asset('images/move-up-icon.png') }}" alt="" class="h-8" />
                            <h1 class="text-3xl font-bold text-heading-dark">
                                Advance Students
                            </h1>
                        </div>

                        <div>
                            <div
                                class="flex items-center bg-white py-1 px-2 rounded-full shadow-2xl/15 border-2 border-white hover:border-blue-button text-paragraph hover:bg-blue-button hover:text-white cursor-pointer">
                                <select class="w-max outline-none" wire:model.live="grade_level">
                                    <option value="" class=" text-heading-dark" disabled>Grade Level</option>
                                    <option value="all" class=" text-heading-dark">All</option>
                                    @foreach ($grade_levels as $level)
                                        <option value="{{ $level->id }}" class=" text-heading-dark">
                                            {{ ucwords($level->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="flex flex-col gap-3 flex-1 min-h-0">
                        <h2 class="font-semibold text-2xl">Students</h2>
                        <div class="flex flex-col gap-2 flex-1 min-h-0">
                            <div class="rounded-lg flex flex-col h-full gap-2">
                                <div class="flex items-center justify-between w-full mb-2">
                                    <p class="text-paragraph">Select Students you want to move up.</p>
                                    <button type="button" wire:click="clearStudents"
                                        class="flex items-center justify-center gap-1 px-3 py-1 rounded-lg text-paragraph hover:text-white cursor-pointer bg-white hover:bg-blue-button">
                                        <p class="text-sm">Clear Selected</p>
                                        <span class="material-symbols-rounded">clear_all</span>
                                    </button>
                                </div>

                                <div class="flex items-center gap-2 px-4 py-2 rounded-2xl bg-white w-full">
                                    <span class="material-symbols-rounded">person_search</span>
                                    <input type="text" placeholder="Search Student" wire:model.live="student_search"
                                        class="w-full outline-none text-heading-dark placeholder-heading-dark" />
                                </div>

                                <div class="flex-1 min-h-0 flex flex-col gap-1 bg-white p-6 rounded-2xl">
                                    <div class="flex flex-col gap-1 flex-1 min-h-0 overflow-y-scroll pr-2 rounded-lg">

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

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div wire:loading wire:target="advanceStudents"
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

                    <div class="flex items-center gap-2 w-full rounded-b-4xl">
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
