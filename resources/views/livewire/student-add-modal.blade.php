<div>
    @if ($step > 0)
        <section
            class="bg-black/40 fixed w-dvw h-dvh top-0 left-0 z-50 backdrop-blur-xs flex justify-center items-center overflow-y-auto p-10">
            <!-- first form -->
            @if ($step === 1)
                <div class="bg-card p-8 rounded-4xl w-180 flex flex-col gap-8">
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('images/form-icon.png') }}" class="h-8" alt="" />
                        <h1 class="text-3xl font-bold text-heading-dark">
                            Enrollment Form
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
                                    x-text="progress"></span>%</p>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3">
                        <h2 class="font-semibold text-xl">Learners Information</h2>
                        <div class="flex flex-col gap-2">
                            <input type="text" placeholder="LRN" wire:model.live='lrn' maxlength="12"
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
                                <select name="" id="" class="w-full outline-none text-paragraph"
                                    wire:change="$set('sex', $event.target.value)">
                                    <option class="text-sm text-black" selected disabled>
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

                            <div class="px-4 py-2 rounded-lg bg-white">
                                <select name="" id="" class="w-full outline-none text-paragraph"
                                    wire:model.live="grade_level">
                                    <option value="" class="text-sm text-black" selected disabled>
                                        Grade Level
                                    </option>
                                    @foreach ($grade_levels as $level)
                                        <option value="{{ $level->id }}" class="text-sm text-paragraph">
                                            {{ ucwords($level->name) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="px-4 py-2 rounded-lg bg-white">
                                <select name="" id="" class="w-full outline-none text-paragraph"
                                    wire:model.live="disability">
                                    <option value="" class="text-sm text-black" selected disabled>
                                        Disability
                                    </option>
                                    @foreach ($specializations as $specialization)
                                        <option value="{{ $specialization->name }}" class="text-sm text-paragraph">
                                            {{ ucwords($specialization->name) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <textarea name="" id="" maxlength="200" placeholder="Description (Optional)"
                                wire:model.live='description'
                                class="px-4 py-2 rounded-lg bg-white placeholder-paragraph resize-none h-24 outline-none"></textarea>
                        </div>
                    </div>
                    <!-- buttons -->
                    <div class="flex items-center gap-2">
                        <button type="button"
                            class="bg-white py-1.5 px-4 w-full rounded-xl text-heading-dark font-medium hover:bg-gray-300 cursor-pointer"
                            wire:click="closeModal" type="button">
                            Cancel
                        </button>
                        <button type="button"
                            class="bg-blue-button py-1.5 px-4 w-full rounded-xl text-white font-medium hover:bg-blue-700 cursor-pointer"
                            wire:click="nextStep">
                            Next
                        </button>
                    </div>
                </div>
            @endif
            <!-- End of first form -->

            <!-- Second form -->
            @if ($step === 2)
                <div class="bg-card p-8 rounded-4xl w-180 flex flex-col gap-8">
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('images/form-icon.png') }}" class="h-8" alt="" />
                        <h1 class="text-3xl font-bold text-heading-dark">
                            Enrollment Form
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
                                    <option value='' class="text-sm text-black" selected disabled>
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

                    <div class="flex flex-col gap-3">
                        <h2 class="font-semibold text-xl">Guardian's Information</h2>
                        <div class="flex flex-col gap-2">
                            <input type="text" placeholder="First name" wire:model.live="guardian_first_name"
                                class="px-4 py-2 rounded-lg bg-white placeholder-paragraph outline-none w-full" />
                            <input type="text" placeholder="Middle name" wire:model.live="guardian_middle_name"
                                class="px-4 py-2 rounded-lg bg-white placeholder-paragraph outline-none w-full" />
                            <input type="text" placeholder="Lastname" wire:model.live="guardian_last_name"
                                class="px-4 py-2 rounded-lg bg-white placeholder-paragraph outline-none w-full" />
                            <input type="email" name="" id="" placeholder="Email"
                                wire:model.live="guardian_email"
                                class="px-4 py-2 rounded-lg bg-white placeholder-paragraph outline-none w-full" />
                            <input type="text" name="" id="" placeholder="Phone no. (Optional)"
                                wire:model.live="guardian_phone" maxlength="10"
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
                            wire:click="nextStep">
                            Next
                        </button>
                    </div>
                </div>
            @endif
            <!-- End of Second form -->

            <!-- Third form -->
            @if ($step === 3)
                <div class="bg-card p-8 rounded-4xl w-150 flex flex-col gap-8">
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('images/account.png') }}" class="h-8" alt="" />
                        <h1 class="text-3xl font-bold text-heading-dark">
                            Educational Background
                        </h1>
                    </div>
                    <div class="flex flex-col gap-3">
                        <h2 class="font-semibold text-xl">For Transferee and Returning Learners</h2>
                        <div class="flex flex-col gap-2">
                            <input type="number" name="" id="" placeholder="School ID"
                                wire:model.live="school_id"
                                class="px-4 py-2 rounded-lg bg-white placeholder-paragraph outline-none w-full" />
                            <div class="pl-3 pr-4 py-2 rounded-lg bg-white">
                                <select name="" id="" class="w-full outline-none text-paragraph"
                                    wire:model.live="background_grade_level">
                                    <option value="" class="text-sm text-black" selected disabled>
                                        Last Grade Level Completed </option>
                                    @foreach ($background_grade_levels as $level)
                                        <option value="{{ $level->id }}" class="text-sm text-paragraph">
                                            {{ ucwords($level->name) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="text" placeholder="Last School Year Completed (e.g. 2022–2023)"
                                maxlength="9" pattern="\d{4}[-–]\d{4}" wire:model.live="last_school_year_completed"
                                class="px-4 py-2 rounded-lg bg-white placeholder-paragraph outline-none w-full text-paragraph" />

                            <input type="text" name="" id="" placeholder="Last School Attended"
                                wire:model.live="last_school_attended"
                                class="px-4 py-2 rounded-lg bg-white placeholder-paragraph outline-none w-full" />
                        </div>
                    </div>

                    <div class="flex flex-col gap-3">
                        <h2 class="font-semibold text-xl">Student's Account</h2>
                        <div class="flex flex-col gap-2">
                            <input type="text" name="" id="" placeholder="Username" disabled
                                value="{{ $account_username }}"
                                class="px-4 py-2 rounded-lg bg-white placeholder-paragraph outline-none w-full" />
                            <input type="text" name="" id="" placeholder="Password" disabled
                                value="{{ $account_password }}"
                                class="px-4 py-2 rounded-lg bg-white placeholder-paragraph outline-none w-full" />
                        </div>
                    </div>

                    <div wire:loading wire:target="addStudent"
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
                            wire:click="addStudent">
                            Register
                        </button>
                    </div>
                </div>
            @endif
            <!-- End of Third form -->
        </section>
    @endif
</div>
