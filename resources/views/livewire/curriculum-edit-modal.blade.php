<div>
    @if ($isOpen)
        <div class="bg-black/30 fixed w-dvw h-dvh top-0 left-0 z-50 backdrop-blur-xs flex justify-center items-center">
            <form wire:submit='editCurriculum' class="bg-white p-8 rounded-3xl w-1/3 flex flex-col gap-8">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('images/book.png') }}" alt="" />
                    <h1 class="text-2xl font-semibold text-heading-dark">
                        Edit Curriculumn
                    </h1>
                </div>

                <div class="flex flex-col gap-3">
                    <h2 class="font-medium text-lg">Curriculum Details</h2>
                    <div class="flex flex-col gap-2">
                        <input type="text" placeholder="Name" wire:model.live="edit_name"
                            class="px-3 py-1 rounded-lg bg-card placeholder-paragraph outline-none" />

                        <div class="px-2 py-1 rounded-lg bg-card">
                            <select wire:change="$set('edit_grade_level', $event.target.value)"
                                class="w-full outline-none text-paragraph">
                                @foreach ($grade_levels as $grade_level)
                                    @if ($edit_grade_level === $grade_level)
                                        <option value="{{ $edit_grade_level }}" class="text-sm text-paragraph">
                                            {{ ucwords($edit_grade_level) }}
                                        </option>
                                    @else
                                        <option value="{{ $grade_level }}" class="text-sm text-paragraph">
                                            {{ ucwords($grade_level) }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="px-2 py-1 rounded-lg bg-card">
                            <select wire:change="$set('edit_specialization', $event.target.value)" name=""
                                id=""
                                class="w-full outline-none text-paragraph outline-1 outline-card focus:outline-blue-button">
                                <option class="text-sm text-black" selected disabled>
                                    Specialization
                                </option>
                                @foreach ($specializations as $specialization)
                                    <option value="{{ $specialization->id }}" class="text-sm text-paragraph">
                                        {{ ucwords($specialization->name) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex flex-wrap gap-2">
                            @foreach ($selectedSpecializations as $i => $specId)
                                @php
                                    $spec = $specializations->firstWhere('id', $specId);
                                @endphp
                                <div wire:key="specialization-{{ $i }}"
                                    class="flex items-center gap-2 px-3 py-1 bg-card rounded-full w-fit">
                                    <p class="text-sm">{{ ucwords($spec->name) }}</p>
                                    <button wire:click="removeSpecialization({{ $i }})" type="button"
                                        class="text-red-500 hover:text-red-700">✕</button>
                                </div>
                            @endforeach
                        </div>

                        <div
                            class="flex items-center justify-between pl-3 pr-2 py-1 rounded-lg border border-dashed border-paragraph placeholder-paragraph inputs">
                            <p class="text-paragraph">Add another Specialization</p>
                            <span class="material-symbols-rounded small-icons text-paragraph">add</span>
                        </div>

                        <textarea name="" id="" maxlength="200" placeholder="Description (Optional)"
                            class="px-3 py-2 rounded-lg bg-card placeholder-paragraph resize-none h-24 outline-none">{{ $edit_description }}</textarea>
                        <div class="px-2 py-1 rounded-lg bg-card">
                            <select wire:change="$set('edit_subject', $event.target.value)" name=""
                                id="" class="w-full outline-none text-paragraph">
                                <option class="text-sm text-black" selected disabled>
                                    Subjects
                                </option>
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->name }}" class="text-sm text-paragraph">
                                        {{ ucwords($subject->name) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex flex-wrap gap-2">
                            @foreach ($selectedSubjects as $i => $spec)
                                <div wire:key="subject-{{ $i }}"
                                    class="flex items-center gap-2 px-3 py-1 bg-card rounded-full w-fit">
                                    <p class="text-sm">{{ ucwords($spec) }}</p>
                                    <button wire:click="removeSubject({{ $i }})" type="button"
                                        class="text-red-500 hover:text-red-700">✕</button>
                                </div>
                            @endforeach
                        </div>

                        <div
                            class="flex items-center justify-between pl-3 pr-2 py-1 rounded-lg border border-dashed border-paragraph placeholder-paragraph inputs">
                            <p class="text-paragraph">Add another Subject</p>
                            <span class="material-symbols-rounded small-icons text-paragraph">add</span>
                        </div>
                    </div>
                </div>
                <!-- buttons -->
                <div class="flex items-center gap-2">
                    <button wire:click='closeModal' type="button"
                        class="bg-gray-100 py-1.5 px-3 w-full rounded-xl text-heading-dark font-medium">
                        Cancel
                    </button>
                    <button type="submit" class="bg-blue-button py-1.5 px-3 w-full rounded-xl text-white font-medium">
                        Save
                    </button>
                </div>
            </form>
        </div>
    @endif
</div>
