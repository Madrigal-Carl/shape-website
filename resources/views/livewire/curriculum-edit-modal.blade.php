<div>
    @if ($isOpen)
        <div class="bg-black/30 fixed w-dvw h-dvh top-0 left-0 z-50 backdrop-blur-xs flex justify-center items-center p-10">
            <div class="w-180 h-full flex flex-col bg-card p-8 rounded-4xl relative gap-8 ">
                <form wire:submit='editCurriculum' class="w-full h-full flex flex-col gap-8 overflow-auto Addlesson">
                    <div class="flex items-center gap-4">
                        <img src="{{ asset('images/book.png') }}" alt="" />
                        <h1 class="text-2xl font-semibold text-heading-dark">
                            Edit Curriculumn
                        </h1>
                    </div>

                    <div class="flex flex-col gap-3">
                        <h2 class="font-semibold text-xl">Curriculum Details</h2>
                        <div class="flex flex-col gap-2">
                            <input type="text" placeholder="Name" wire:model.live="edit_name"
                                class="px-4 py-2 rounded-lg bg-white placeholder-paragraph outline-none" />

                            <div class="px-3 py-2 rounded-lg bg-white">
                                <select wire:change="$set('edit_grade_level', $event.target.value)"
                                    class="w-full outline-none text-paragraph">
                                    @for ($i = 1; $i <= 3; $i++)
                                        @php
                                            $grade = "kindergarten $i";
                                        @endphp
                                        @if ($grade === $edit_grade_level)
                                            <option value="{{ $edit_grade_level }}" class="text-sm text-black" selected>
                                                {{ ucwords($edit_grade_level) }}
                                            </option>
                                        @else
                                            <option value="{{ $grade }}" class="text-sm text-paragraph">
                                                Kindergarten {{ $i }}
                                            </option>
                                        @endif
                                    @endfor
                                </select>
                            </div>
                            <button class="pl-4 pr-2 py-2 rounded-lg bg-white text-paragraph w-full text-left hover:bg-gray-300 flex items-center justify-between"
                                type="button" wire:click="openSpecializationModal">
                                <p>Select Specialization</p>
                                {{-- <span class="material-symbols-rounded text-paragraph">keyboard_arrow_down</span> --}}
                                <span class="material-symbols-rounded text-paragraph">keyboard_arrow_up</span>
                            </button>

                            <div class="rounded-lg bg-white h-fit">

                                {{-- Specialization checkbox --}}
                                <div class="p-4 rounded-lg bg-white relative flex flex-col gap-2 h-full">
                                    {{-- Header --}}
                                    <div class="flex items-center justify-between w-full">
                                        <p class="text-paragraph">Specialization</p>
                                        <button type="button" wire:click="clearStudents"
                                            class="flex items-center justify-center gap-1 px-3 py-1 rounded-lg text-paragraph border-1 border-gray-300 hover:border-blue-button hover:text-white cursor-pointer bg-white hover:bg-blue-button">
                                            <p class="text-sm">Clear Selected</p>
                                            <span class="material-symbols-rounded">clear_all</span>
                                        </button>
                                    </div>

                                    {{-- Specialization List --}}
                                    <div class="h-full flex flex-col gap-1 bg-white rounded-lg">
                                        <div class="flex flex-col gap-1 h-full overflow-y-scroll pr-2 rounded-lg">

                                                <div
                                                    class="flex items-center gap-2 w-full p-2 hover:bg-card rounded-lg cursor-pointer">
                                                    <label class="container w-fit">
                                                        <input type="checkbox">
                                                        <div class="checkmark"></div>
                                                    </label>
                                                    <p class="w-full text-paragraph">Hearing Impairement</p>
                                                </div>

                                                <div
                                                    class="flex items-center gap-2 w-full p-2 hover:bg-card rounded-lg cursor-pointer">
                                                    <label class="container w-fit">
                                                        <input type="checkbox">
                                                        <div class="checkmark"></div>
                                                    </label>
                                                    <p class="w-full text-paragraph">Speech Impairement</p>
                                                </div>

                                                <div
                                                    class="flex items-center gap-2 w-full p-2 hover:bg-card rounded-lg cursor-pointer">
                                                    <label class="container w-fit">
                                                        <input type="checkbox">
                                                        <div class="checkmark"></div>
                                                    </label>
                                                    <p class="w-full text-paragraph">Autism</p>
                                                </div>
                                                {{-- <p class="text-center text-sm text-gray-500 h-full flex justify-center items-center">No Specialization found.</p> --}}

                                        </div>
                                    </div>
                                </div>{{-- End of Specialization checkbox --}}
                            </div>



                            <button class="pl-4 pr-2 py-2 rounded-lg bg-white text-paragraph w-full text-left hover:bg-gray-300 flex items-center justify-between"
                                type="button" wire:click="openSpecializationModal">
                                <p>Select Subjects</p>
                                {{-- <span class="material-symbols-rounded text-paragraph">keyboard_arrow_down</span> --}}
                                <span class="material-symbols-rounded text-paragraph">keyboard_arrow_up</span>
                            </button>

                            <div class="rounded-lg bg-white h-fit">

                                {{-- Subject Checkbox --}}
                                <div class="p-4 rounded-lg bg-white relative flex flex-col gap-2 h-full">
                                    {{-- Header --}}
                                    <div class="flex items-center justify-between w-full mb-2">
                                        <p class="text-paragraph">Subjects</p>
                                        <button type="button" wire:click="clearStudents"
                                            class="flex items-center justify-center gap-1 px-3 py-1 rounded-lg text-paragraph border-1 border-gray-300 hover:border-blue-button hover:text-white cursor-pointer bg-white hover:bg-blue-button">
                                            <p class="text-sm">Clear Selected</p>
                                            <span class="material-symbols-rounded">clear_all</span>
                                        </button>
                                    </div>

                                    {{-- Subject List --}}
                                    <div class="h-48 flex flex-col gap-1 bg-white rounded-lg">
                                        <div class="flex flex-col gap-1 h-full overflow-y-scroll pr-2 rounded-lg">
                                            <div
                                                    class="flex items-center gap-2 w-full p-2 hover:bg-card rounded-lg cursor-pointer">
                                                    <label class="container w-fit">
                                                        <input type="checkbox">
                                                        <div class="checkmark"></div>
                                                    </label>
                                                    <p class="w-full text-paragraph">Mathematics</p>
                                                </div>

                                            {{-- <p class="text-center text-sm text-gray-500 h-full flex justify-center items-center">No Subjects found.</p> --}}

                                        </div>
                                    </div>
                                </div>{{-- End of Subject Checkbox --}}
                            </div>
                            <textarea wire:model.live="add_description" name="" id="" maxlength="200"
                                placeholder="Description (Optional)"
                                class="p-4 rounded-lg bg-white placeholder-paragraph resize-none h-40 outline-none mb-18">{{ $edit_description }}</textarea>
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
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
