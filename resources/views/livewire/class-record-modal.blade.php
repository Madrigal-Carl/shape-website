<div>
    @if ($isOpen)
        <div
            class="bg-black/30 fixed w-dvw h-dvh top-0 left-0 z-50 backdrop-blur-xs flex justify-center items-center p-10">
            <div class="w-180 max-h-full flex flex-col bg-card p-8 rounded-4xl relative gap-8 ">

                <div class="grid col-span-3">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

                        @foreach ($specializations as $spec)
                            <button type="button" wire:click="$set('selectedDisability', '{{ $spec->id }}')"
                                class="cursor-pointer flex flex-col items-center p-4">
                                <div
                                    class="flex items-center justify-center w-20 h-20 rounded-full bg-indigo-50 group-hover:bg-indigo-100 transition-colors
                                    @if ($selectedDisability == $spec->id) ring-4 ring-blue-button @endif">

                                    <img src="{{ asset('images/specialization_icons/' . $spec->icon) }}"
                                        alt="{{ $spec->name }}" class="h-6">

                                </div>

                                <div class="mt-3 text-center">
                                    <div class="text-sm font-medium text-gray-700">
                                        {{ ucwords($spec->name) }}
                                    </div>
                                </div>
                            </button>
                        @endforeach

                    </div>
                </div>

                <div class="px-3 py-2 rounded-lg bg-white">
                    <select wire:model.live="grade_level_id" class="w-full outline-none text-paragraph">
                        <option value="" class="text-sm text-black" disabled>
                            Grade Level
                        </option>
                        @foreach ($grade_levels as $level)
                            <option value="{{ $level->id }}" class="text-sm text-paragraph">
                                {{ ucwords($level->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center gap-2 w-full px-8 pb-8 pt-4 rounded-b-4xl bg-card">
                    <button wire:click='closeModal'
                        class="bg-white py-1.5 px-3 w-full rounded-xl text-heading-dark font-medium hover:bg-gray-300 cursor-pointer">
                        Cancel
                    </button>

                    <button wire:click="exportClassRecord"
                        class="bg-blue-button py-1.5 px-3 w-full rounded-xl text-white font-medium cursor-pointer hover:bg-blue-700">
                        Export
                    </button>
                </div>

            </div>
        </div>
    @endif
</div>
