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
                                <select name="" id="" class="w-full outline-none text-paragraph">
                                    <option value="marinduque" class="text-sm text-black" selected disabled>
                                        Marinduque
                                    </option>
                                </select>
                            </div>
                            <div class="px-4 py-2 rounded-lg bg-white w-full">
                                <select name="" id="" class="w-full outline-none text-paragraph"
                                    wire:model.live="permanent_municipal">
                                    <option value='' class="text-sm text-black" disabled>
                                        Municipal
                                    </option>
                                    @foreach ($municipalities as $municipality)
                                        <option value="{{ $municipality }}" class="text-sm text-paragraph">
                                            {{ ucwords($municipality) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="px-4 py-2 rounded-lg bg-white w-full">
                                <select name="" id="" class="w-full outline-none text-paragraph"
                                    wire:key="{{ $permanent_municipal }}" wire:model.live="permanent_barangay">
                                    <option value="" class="text-sm text-black" disabled>
                                        Barangay
                                    </option>
                                    @foreach ($permanent_barangays as $pbarangay)
                                        <option value="{{ $pbarangay }}" class="text-sm text-paragraph">
                                            {{ ucwords($pbarangay) }}</option>
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
                                <select name="" id="" class="w-full outline-none text-paragraph">
                                    <option value="marinduque" class="text-sm text-black" selected disabled>
                                        Marinduque
                                    </option>
                                </select>
                            </div>
                            <div class="px-4 py-2 rounded-lg bg-white w-full">
                                <select name="" id="" class="w-full outline-none text-paragraph"
                                    wire:model.live="current_municipal">
                                    <option value="" class="text-sm text-black" disabled>
                                        Municipal
                                    </option>
                                    @foreach ($municipalities as $municipality)
                                        <option value="{{ $municipality }}" class="text-sm text-paragraph">
                                            {{ ucwords($municipality) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="px-4 py-2 rounded-lg bg-white w-full">
                                <select name="" id="" class="w-full outline-none text-paragraph"
                                    wire:key="{{ $current_municipal }}" wire:model.live="current_barangay">
                                    <option value="" class="text-sm text-black" disabled>
                                        Barangay
                                    </option>
                                    @foreach ($current_barangays as $cbarangay)
                                        <option value="{{ $cbarangay }}" class="text-sm text-paragraph">
                                            {{ ucwords($cbarangay) }}</option>
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

                    <div wire:loading wire:target="addInstructor"
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
