<div>
    @if ($isOpen)
        <div
            class="bg-black/30 fixed w-dvw h-dvh top-0 left-0 z-50 backdrop-blur-xs flex justify-center items-center p-10">
            <div class="w-180 max-h-full flex flex-col bg-card p-8 rounded-4xl relative gap-8 ">
                <form wire:submit='addCurriculum' class="w-full h-full flex flex-col gap-8 overflow-auto Addlesson">
                    <div class="flex items-center gap-4">
                        <img src="{{ asset('images/book.png') }}" alt="" />
                        <h1 class="text-3xl font-bold text-heading-dark">
                            Add Curriculumn
                        </h1>
                    </div>
                    <div class="flex flex-col gap-3">
                        <h2 class="font-semibold text-xl">Curriculum Details</h2>
                        <div class="flex flex-col gap-2">
                            {{-- Curriculum Details Form --}}
                            <input type="text" placeholder="Name" wire:model.live="add_name"
                                class="px-4 py-2 rounded-lg bg-white placeholder-paragraph outline-none" />
                            <div class="px-3 py-2 rounded-lg bg-white">
                                <select wire:change="$set('add_grade_level', $event.target.value)"
                                    class="w-full outline-none text-paragraph">
                                    <option class="text-sm text-black" selected disabled>
                                        Grade Level
                                    </option>
                                    <option value="kindergarten 1" class="text-sm text-paragraph">
                                        Kindergarten 1
                                    </option>
                                    <option value="kindergarten 2" class="text-sm text-paragraph">
                                        Kindergarten 2
                                    </option>
                                    <option value="kindergarten 3" class="text-sm text-paragraph">
                                        Kindergarten 3
                                    </option>
                                </select>
                            </div>

                            <button
                                class="cursor-pointer pl-4 pr-2 py-2 rounded-lg bg-white text-paragraph w-full text-left hover:bg-gray-300 flex items-center justify-between"
                                type="button" wire:click="openSpecializationModal">
                                <p>Select Specialization</p>
                                <span class="material-symbols-rounded text-paragraph">
                                    {{ $showSpecializationDropdown ? 'keyboard_arrow_up' : 'keyboard_arrow_down' }}
                                </span>
                            </button>

                            @if ($showSpecializationDropdown)
                                <div class="rounded-lg bg-white h-fit mt-2">
                                    <div class="p-4 rounded-lg bg-white relative flex flex-col gap-2 h-full">
                                        <div class="flex items-center justify-between w-full">
                                            <p class="text-paragraph">Specialization</p>
                                            <button type="button" wire:click="clearSpecializations"
                                                class="flex items-center justify-center gap-1 px-3 py-1 rounded-lg text-paragraph border-1 border-gray-300 hover:border-blue-button hover:text-white cursor-pointer bg-white hover:bg-blue-button">
                                                <p class="text-sm">Clear Selected</p>
                                                <span class="material-symbols-rounded">clear_all</span>
                                            </button>
                                        </div>
                                        <div class="h-full flex flex-col gap-1 bg-white rounded-lg">
                                            <div class="flex flex-col gap-1 h-full overflow-y-scroll pr-2 rounded-lg">
                                                @forelse($specializations as $specialization)
                                                    <div
                                                        class="flex items-center gap-2 w-full p-2 hover:bg-card rounded-lg cursor-pointer">
                                                        <label class="container w-fit">
                                                            <input type="checkbox" value="{{ $specialization->id }}"
                                                                wire:model="selectedSpecializations">
                                                            <div class="checkmark"></div>
                                                        </label>
                                                        <p class="w-full text-paragraph">
                                                            {{ ucwords($specialization->name) }}</p>
                                                    </div>
                                                @empty
                                                    <p
                                                        class="text-center text-sm text-gray-500 h-full flex justify-center items-center">
                                                        No Specialization found.</p>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif



                            <button
                                class="cursor-pointer pl-4 pr-2 py-2 rounded-lg bg-white text-paragraph w-full text-left hover:bg-gray-300 flex items-center justify-between"
                                type="button" wire:click="openSubjectModal">
                                <p>Select Subjects</p>
                                <span class="material-symbols-rounded text-paragraph">
                                    {{ $showSubjectDropdown ? 'keyboard_arrow_up' : 'keyboard_arrow_down' }}
                                </span>
                            </button>

                            @if ($showSubjectDropdown)
                                <div class="rounded-lg bg-white h-fit mt-2">
                                    <div class="p-4 rounded-lg bg-white relative flex flex-col gap-2 h-full">
                                        <div class="flex items-center justify-between w-full">
                                            <p class="text-paragraph">Subjects</p>
                                            <button type="button" wire:click="clearSubjects"
                                                class="flex items-center justify-center gap-1 px-3 py-1 rounded-lg text-paragraph border-1 border-gray-300 hover:border-blue-button hover:text-white cursor-pointer bg-white hover:bg-blue-button">
                                                <p class="text-sm">Clear Selected</p>
                                                <span class="material-symbols-rounded">clear_all</span>
                                            </button>
                                        </div>
                                        <div class="h-48 flex flex-col gap-1 bg-white rounded-lg">
                                            <div class="flex flex-col gap-1 h-full overflow-y-scroll pr-2 rounded-lg">
                                                @forelse($subjects as $subject)
                                                    <div
                                                        class="flex items-center gap-2 w-full p-2 hover:bg-card rounded-lg cursor-pointer">
                                                        <label class="container w-fit">
                                                            <input type="checkbox" value="{{ $subject->name }}"
                                                                wire:model="selectedSubjects">
                                                            <div class="checkmark"></div>
                                                        </label>
                                                        <p class="w-full text-paragraph">{{ ucwords($subject->name) }}
                                                        </p>
                                                    </div>
                                                @empty
                                                    <p
                                                        class="text-center text-sm text-gray-500 h-full flex justify-center items-center">
                                                        No Subjects found.</p>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <textarea wire:model.live="add_description" name="" id="" maxlength="200"
                                placeholder="Description (Optional)"
                                class="p-4 rounded-lg bg-white placeholder-paragraph resize-none h-40 outline-none mb-18"></textarea>
                        </div>
                    </div>

                    <div wire:loading wire:target="addCurriculum"
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
                    <!-- buttons -->
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
                </form>
            </div>

        </div>
    @endif
</div>
