<div>
    @if ($step > 0)
        <section id="teacherFormPopup"
            class="fixed inset-0 z-50 bg-black/40 backdrop-blur-xs flex justify-center items-center p-10 gap-6">
            <!-- Form 1 -->
            @if ($step === 1)
                <div
                    class="w-180 max-h-full flex flex-col bg-card p-8 rounded-4xl relative gap-8 overflow-y-auto Addlesson">
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('images/form-icon.png') }}" class="h-8" alt="" />
                        <h1 class="text-3xl font-bold text-heading-dark">
                            Instructor's Form
                        </h1>
                    </div>

                    <div class="flex flex-col items-center gap-4">
                        <div>
                            @if ($photo)
                                <img src="{{ $photo->temporaryUrl() }}"
                                    class="w-25 h-25 rounded-full object-cover bg-white p-2 shadow-2xl" />
                            @else
                                <img src="https://placehold.co/100x100"
                                    class="w-25 h-25 rounded-full object-cover bg-white p-2 shadow-2xl" />
                            @endif
                        </div>
                        <label for="photo-upload"
                            class="flex items-center text-white gap-2 px-4 py-2 bg-blue-button rounded-full cursor-pointer hover:bg-blue-700">
                            <h1>Upload</h1>
                            <span class="material-symbols-rounded">add_photo_alternate</span>
                            <input type="file" id="photo-upload" class="hidden" wire:model="photo"
                                accept="image/*" />
                        </label>
                        <div x-data="{ progress: 0 }"
                            x-on:livewire-upload-progress.window="progress = $event.detail.progress"
                            x-on:livewire-upload-start.window="progress = 0"
                            x-on:livewire-upload-finish.window="progress = 0"
                            x-on:livewire-upload-error.window="progress = 0" wire:loading wire:target="photo"
                            class="mt-2 w-28 flex-col items-center">
                            <div class="bg-gray-200 h-2 rounded-full overflow-hidden">
                                <div class="bg-blue-500 h-2 transition-all duration-300"
                                    :style="'width: ' + progress + '%'"></div>
                            </div>
                            <p class="text-xs text-blue-600 mt-1 text-center">Uploading... <span
                                    x-text="progress"></span>%
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3">
                        <h2 class="font-semibold text-xl">Teacher's Information</h2>
                        <div class="flex flex-col gap-2">
                            <input type="text" placeholder="License Number" wire:model.live='license_number'
                                maxlength="7"
                                class="px-4 py-2 rounded-lg bg-white placeholder-paragraph outline-none w-full" />

                            <div class="flex items-center gap-2 w-full">
                                <input type="text" placeholder="First name" wire:model.live='first_name'
                                    class="px-4 py-2 rounded-lg bg-white placeholder-paragraph outline-none w-full" />
                                <input type="text" placeholder="Middle name" wire:model.live='middle_name'
                                    class="px-4 py-2 rounded-lg bg-white placeholder-paragraph outline-none w-full" />
                                <input type="text" placeholder="Last name" wire:model.live='last_name'
                                    class="px-4 py-2 rounded-lg bg-white placeholder-paragraph outline-none w-full" />
                            </div>

                            <input type="text" placeholder="Birthdate" wire:model.live='birthdate'
                                class="px-4 py-2 rounded-lg bg-white placeholder-paragraph outline-none w-full text-paragraph"
                                onfocus="this.type='date'" onblur="if(!this.value) this.type='text'" />

                            <div class="px-4 py-2 rounded-lg bg-white">
                                <select class="w-full outline-none text-paragraph" wire:model.live="sex">
                                    <option value="" class="text-sm text-black" selected disabled>
                                        Sex
                                    </option>
                                    <option value="male" class="text-sm text-paragraph">
                                        Male
                                    </option>
                                    <option value="female" class="text-sm text-paragraph">
                                        Female
                                    </option>
                                </select>
                            </div>

                            <button
                                class="cursor-pointer pl-4 pr-2 py-2 rounded-lg bg-white text-paragraph w-full text-left hover:bg-gray-300 flex items-center justify-between"
                                type="button" wire:click="$toggle('showGradeLevels')">
                                <p>Select Grade Levels</p>
                                <span class="material-symbols-rounded text-paragraph">
                                    {{ $showGradeLevels ? 'keyboard_arrow_up' : 'keyboard_arrow_down' }}
                                </span>
                            </button>
                            {{-- Grade Levels Toggle --}}

                            @if ($showGradeLevels)
                                <div class="rounded-lg bg-white h-fit">
                                    <div class="p-4 rounded-lg bg-white relative flex flex-col gap-2 h-full">
                                        <div class="flex items-center justify-between w-full">
                                            <p class="text-paragraph">Grade Levels</p>
                                            <button type="button" wire:click="clearGradeLevels"
                                                class="flex items-center justify-center gap-1 px-3 py-1 rounded-lg text-paragraph border-1 border-gray-300 hover:border-blue-button hover:text-white cursor-pointer bg-white hover:bg-blue-button">
                                                <p class="text-sm">Clear Selected</p>
                                                <span class="material-symbols-rounded">clear_all</span>
                                            </button>
                                        </div>
                                        <div class="h-fit flex flex-col gap-1 bg-white rounded-lg">
                                            <div class="flex flex-col gap-1 h-full overflow-y-scroll pr-2 rounded-lg"
                                                style="max-height: 120px;">
                                                @forelse($gradeLevels as $level)
                                                    <div
                                                        class="flex items-center gap-2 w-full p-2 hover:bg-card rounded-lg cursor-pointer">
                                                        <label class="container w-fit">
                                                            <input type="checkbox" wire:model="selectedGradeLevels"
                                                                value="{{ $level->id }}">
                                                            <div class="checkmark"></div>
                                                        </label>
                                                        <p class="w-full text-paragraph">
                                                            {{ ucwords($level->name) }}
                                                        </p>
                                                    </div>
                                                @empty
                                                    <p
                                                        class="text-center text-sm text-gray-500 h-full flex justify-center items-center">
                                                        No Grade Level found.
                                                    </p>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <button
                                class="cursor-pointer pl-4 pr-2 py-2 rounded-lg bg-white text-paragraph w-full text-left hover:bg-gray-300 flex items-center justify-between"
                                type="button" wire:click="$toggle('showSpecializations')">
                                <p>Select Specialization</p>
                                <span class="material-symbols-rounded text-paragraph">
                                    {{ $showSpecializations ? 'keyboard_arrow_up' : 'keyboard_arrow_down' }}
                                </span>
                            </button>
                            {{-- Specialization Toggle --}}

                            @if ($showSpecializations)
                                <div class="rounded-lg bg-white h-fit">
                                    <div class="p-4 rounded-lg bg-white relative flex flex-col gap-2 h-full">
                                        <div class="flex items-center justify-between w-full">
                                            <p class="text-paragraph">Specialization</p>
                                            <button type="button" wire:click="clearSpecializations"
                                                class="flex items-center justify-center gap-1 px-3 py-1 rounded-lg text-paragraph border-1 border-gray-300 hover:border-blue-button hover:text-white cursor-pointer bg-white hover:bg-blue-button">
                                                <p class="text-sm">Clear Selected</p>
                                                <span class="material-symbols-rounded">clear_all</span>
                                            </button>
                                        </div>
                                        <div class="h-fit flex flex-col gap-1 bg-white rounded-lg">
                                            <div class="flex flex-col gap-1 h-full overflow-y-scroll pr-2 rounded-lg"
                                                style="max-height: 120px;">
                                                @forelse($specializations as $spec)
                                                    <div
                                                        class="flex items-center gap-2 w-full p-2 hover:bg-card rounded-lg cursor-pointer">
                                                        <label class="container w-fit">
                                                            <input type="checkbox"
                                                                wire:model="selectedSpecializations"
                                                                value="{{ $spec->id }}">
                                                            <div class="checkmark"></div>
                                                        </label>
                                                        <p class="w-full text-paragraph">
                                                            {{ ucwords($spec->name) }}
                                                        </p>
                                                    </div>
                                                @empty
                                                    <p
                                                        class="text-center text-sm text-gray-500 h-full flex justify-center items-center">
                                                        No Specialization found.
                                                    </p>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <!-- buttons -->
                        <div class="flex items-center gap-2">
                            <button type="button"
                                class="bg-white py-1.5 px-4 w-full rounded-xl text-heading-dark font-medium hover:bg-gray-300 cursor-pointer"
                                wire:click="closeModal">
                                Cancel
                            </button>
                            <button type="button"
                                class="bg-blue-button py-1.5 px-4 w-full rounded-xl text-white font-medium hover:bg-blue-700 cursor-pointer"
                                wire:click="nextStep">
                                Next
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Second form -->
            @if ($step === 2)
                <div class="bg-card p-8 rounded-4xl w-180 flex flex-col gap-8">
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('images/form-icon.png') }}" class="h-8" alt="" />
                        <h1 class="text-3xl font-bold text-heading-dark">
                            Instructor's Form
                        </h1>
                    </div>

                    <div class="flex flex-col gap-3">
                        <h2 class="font-semibold text-xl">Permanent Address</h2>
                        <div class="flex items-center gap-2 w-full">
                            <div class="px-4 py-2 rounded-lg bg-white w-full">
                                <select class="w-full outline-none text-paragraph" disabled>
                                    <option value="marinduque" class="text-sm text-black" selected>
                                        Marinduque
                                    </option>
                                </select>
                            </div>
                            <div class="px-4 py-2 rounded-lg bg-white w-full">
                                <select class="w-full outline-none text-paragraph"
                                    wire:model.live="permanent_municipal">
                                    <option value="" class="text-sm text-black" selected disabled>
                                        Municipal
                                    </option>
                                    @foreach ($municipalities as $municipal)
                                        <option value="{{ $municipal }}" class="text-sm text-paragraph">
                                            {{ ucfirst($municipal) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="px-4 py-2 rounded-lg bg-white w-full">
                                <select class="w-full outline-none text-paragraph"
                                    wire:model.live="permanent_barangay">
                                    <option value="" class="text-sm text-black" selected disabled>
                                        Barangay
                                    </option>
                                    @foreach ($permanent_barangays as $barangay)
                                        <option value="{{ $barangay }}" class="text-sm text-paragraph">
                                            {{ ucfirst($barangay) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col gap-3">
                        <div class="flex items-center justify-between w-full">
                            <h2 class="font-semibold text-xl">Current Address</h2>
                            <div class="flex items-center gap-2 w-fit p-2 hover:bg-card rounded-lg cursor-pointer">
                                <label class="container w-fit">
                                    <input type="checkbox" wire:model.live="copyPermanentToCurrent">
                                    <div class="checkmark"></div>
                                </label>
                                <p class="w-full text-paragraph">Use Permanent Address</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 w-full">
                            <div class="px-4 py-2 rounded-lg bg-white w-full">
                                <select class="w-full outline-none text-paragraph" disabled>
                                    <option value="marinduque" class="text-sm text-black" selected>
                                        Marinduque
                                    </option>
                                </select>
                            </div>
                            <div class="px-4 py-2 rounded-lg bg-white w-full">
                                <select class="w-full outline-none text-paragraph"
                                    wire:model.live="current_municipal">
                                    <option value="" class="text-sm text-black" selected disabled>
                                        Municipal
                                    </option>
                                    @foreach ($municipalities as $municipal)
                                        <option value="{{ $municipal }}" class="text-sm text-paragraph">
                                            {{ ucfirst($municipal) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="px-4 py-2 rounded-lg bg-white w-full">
                                <select class="w-full outline-none text-paragraph" wire:model.live="current_barangay">
                                    <option value="" class="text-sm text-black" selected disabled>
                                        Barangay
                                    </option>
                                    @foreach ($current_barangays as $barangay)
                                        <option value="{{ $barangay }}" class="text-sm text-paragraph">
                                            {{ ucfirst($barangay) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- buttons -->
                    <div class="flex items-center gap-2">
                        <button type="button"
                            class="bg-white py-1.5 px-3 w-full rounded-xl text-heading-dark font-medium hover:bg-gray-300 cursor-pointer"
                            wire:click="closeModal">
                            Cancel
                        </button>
                        <button type="button"
                            class="bg-yellowOrange py-1.5 px-3 w-full rounded-xl text-white font-medium hover:bg-amber-500 cursor-pointer"
                            wire:click="previousStep">
                            Prev
                        </button>
                        <button type="button"
                            class="bg-blue-button py-1.5 px-3 w-full rounded-xl text-white font-medium hover:bg-blue-700 cursor-pointer"
                            wire:click="nextStep">
                            Next
                        </button>
                    </div>
                </div>
            @endif

            <!-- Third form -->
            @if ($step === 3)
                <div class="bg-card p-8 rounded-4xl w-150 flex flex-col gap-8">
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('images/account.png') }}" class="h-8" alt="" />
                        <h1 class="text-3xl font-bold text-heading-dark">
                            Create Instructor's Account
                        </h1>
                    </div>

                    <div class="flex flex-col gap-3">
                        <h2 class="font-semibold text-xl">Instructor's Account</h2>
                        <div class="flex flex-col gap-2">
                            <input type="text" name="" id="" placeholder="Username"
                                wire:model.live='account_username' disabled
                                class="px-4 py-2 rounded-lg bg-white placeholder-paragraph outline-none w-full" />
                            <input type="text" name="" id="" placeholder="Password"
                                wire:model.live='account_password' disabled
                                class="px-4 py-2 rounded-lg bg-white placeholder-paragraph outline-none w-full" />
                        </div>
                    </div>

                    <!-- buttons -->
                    <div class="flex items-center gap-2">
                        <button type="button"
                            class="bg-white py-1.5 px-3 w-full rounded-xl text-heading-dark font-medium hover:bg-gray-300 cursor-pointer"
                            wire:click="closeModal">
                            Cancel
                        </button>
                        <button type="button"
                            class="bg-yellowOrange py-1.5 px-3 w-full rounded-xl text-white font-medium hover:bg-amber-500 cursor-pointer"
                            wire:click="previousStep">
                            Prev
                        </button>
                        <button type="button"
                            class="bg-blue-button py-1.5 px-3 w-full rounded-xl text-white font-medium hover:bg-blue-700 cursor-pointer"
                            wire:click="addInstructor">
                            Register
                        </button>
                    </div>
                </div>
            @endif
        </section>
    @endif
</div>
