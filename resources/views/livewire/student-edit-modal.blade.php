<div>
    @if ($step > 0)
        <section
            class="bg-black/40 fixed w-dvw h-dvh top-0 left-0 z-50 backdrop-blur-xs flex justify-center items-center overflow-y-auto p-10">
            <!-- first form -->
            @if ($step === 1)
                <div class="bg-card white p-8 rounded-4xl w-180 flex flex-col gap-8">
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('images/form-icon.png') }}" class="h-8" alt="" />
                        <h1 class="text-3xl font-bold text-heading-dark">
                            Edit Enrollment Form
                        </h1>
                    </div>

                    <div class="flex flex-col items-center gap-4">
                        <div>
                            @if ($photo instanceof \Illuminate\Http\UploadedFile)
                                <img src="{{ $photo->temporaryUrl() }}"
                                    class="w-25 h-25 rounded-full object-cover bg-white p-2 shadow-2xl" />
                            @elseif ($currentPhoto)
                                <img src="{{ Storage::url($currentPhoto) }}"
                                    class="w-25 h-25 rounded-full object-cover bg-white p-2 shadow-2xlr" />
                            @else
                                <img src="https://placehold.co/100x100"
                                    class="w-25 h-25 rounded-full object-cover bg-white p-2 shadow-2xl" />
                            @endif
                        </div>
                        <label for="photo-upload"
                            class="flex items-center text-white gap-2 px-4 py-2 bg-blue-button rounded-full cursor-pointer hover:bg-blue-700">
                            <h1>Upload Photo</h1>
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
                            <div class="flex items-center gap-2 w-full">
                                <input type="text" placeholder="LRN" wire:model.live='lrn' maxlength="12"
                                    class="px-4 py-2 rounded-lg bg-white placeholder-paragraph outline-none w-full" />
                                <div class="px-4 py-2 rounded-lg bg-white">

                                    @php
                                        $statuses = [
                                            'Active' => 'active',
                                            'Inactive' => 'inactive',
                                            'Transferred' => 'transferred',
                                            'Dropped' => 'dropped',
                                        ];

                                        $classes = [
                                            'Active' => 'text-lime',
                                            'Inactive' => 'text-paragraph',
                                            'Transferred' => 'text-yellowOrange',
                                            'Dropped' => 'text-danger',
                                        ];
                                    @endphp
                                    <select class="w-max outline-none " wire:model.live="status">
                                        @foreach ($statuses as $value => $label)
                                            <option value="{{ $label }}" class="{{ $classes[$value] }}">
                                                {{ $value }}
                                            </option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>


                            <div class="flex items-center gap-2 w-full">
                                <input type="text" placeholder="First name" wire:model.live='first_name'
                                    class="px-4 py-2 rounded-lg bg-white placeholder-paragraph outline-none w-full" />
                                <input type="text" placeholder="Middle name" wire:model.live='middle_name'
                                    class="px-4 py-2 rounded-lg bg-white placeholder-paragraph outline-none w-full" />
                                <input type="text" placeholder="Last name" wire:model.live='last_name'
                                    class="px-4 py-2 rounded-lg bg-white placeholder-paragraph outline-none w-full" />
                            </div>

                            <input type="text" placeholder="Birthdate" wire:model.live='birthdate'
                                class="px-2.5 py-1 rounded-lg bg-white placeholder-paragraph outline-none w-full text-paragraph"
                                onfocus="this.type='date'" onblur="if(!this.value) this.type='text'" />

                            <div class="px-4 py-2 rounded-lg bg-white">
                                <select name="" id="" class="w-full outline-none text-paragraph"
                                    wire:change="$set('sex', $event.target.value)">
                                    <option class="text-sm text-black" selected disabled>
                                        {{ ucfirst($sex) }}
                                    </option>
                                    @if ($sex === 'male')
                                        <option value="female" class="text-sm text-paragraph">
                                            Female
                                        </option>
                                    @else
                                        <option value="male" class="text-sm text-paragraph">
                                            Male
                                        </option>
                                    @endif
                                </select>
                            </div>

                            <div class="px-4 py-2 rounded-lg bg-white">
                                <select wire:model.live="grade_level" class="w-full outline-none text-paragraph">
                                    @foreach ($grade_levels as $grade)
                                        <option value="{{ $grade->id }}"
                                            class="text-sm {{ $grade->id === $grade_level ? 'text-black' : 'text-paragraph' }}">
                                            {{ $grade->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="px-4 py-2 rounded-lg bg-white">
                                <select name="" id="" class="w-full outline-none text-paragraph"
                                    wire:change="$set('disability', $event.target.value)">
                                    @foreach ($specializations as $specialization)
                                        @if ($disability === $specialization->name)
                                            <option value="{{ $disability }}" class="text-sm text-black">
                                                {{ ucwords($disability) }}
                                            </option>
                                        @else
                                            <option value="{{ $specialization->name }}" class="text-sm text-paragraph">
                                                {{ ucwords($specialization->name) }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <textarea name="" id="" maxlength="200" placeholder="Description (Optional)"
                                wire:model.live='description'
                                class="px-3 py-2 rounded-lg bg-white placeholder-paragraph resize-none h-24 outline-none"></textarea>
                        </div>
                    </div>
                    <!-- buttons -->
                    <div class="flex items-center gap-2">
                        <button type="button"
                            class="bg-white py-1.5 px-3 w-full rounded-xl text-heading-dark font-medium hover:bg-gray-300 cursor-pointer"
                            wire:click="closeModal" type="button">
                            Cancel
                        </button>
                        <button type="button"
                            class="bg-blue-button py-1.5 px-3 w-full rounded-xl text-white font-medium hover:bg-blue-700 cursor-pointer"
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
                            Edit Enrollment Form
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
                                        @if ($permanent_municipal === $municipality)
                                            <option value="{{ $permanent_municipal }}" class="text-sm text-black">
                                                {{ ucwords($permanent_municipal) }}
                                            </option>
                                        @else
                                            <option value="{{ $municipality }}" class="text-sm text-paragraph">
                                                {{ ucwords($municipality) }}</option>
                                        @endif
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
                                        @if ($permanent_barangay === $pbarangay)
                                            <option value="{{ $permanent_barangay }}" class="text-sm text-black">
                                                {{ ucwords($permanent_barangay) }}
                                            </option>
                                        @else
                                            <option value="{{ $pbarangay }}" class="text-sm text-paragraph">
                                                {{ ucwords($pbarangay) }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col gap-3">
                        <h2 class="font-semibold text-xl">Current Address</h2>
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
                                    <option value='' class="text-sm text-black" disabled>
                                        Municipal
                                    </option>
                                    @foreach ($municipalities as $municipality)
                                        @if ($current_municipal === $municipality)
                                            <option value="{{ $current_municipal }}" class="text-sm text-black"
                                                selected>
                                                {{ ucwords($current_municipal) }}
                                            </option>
                                        @else
                                            <option value="{{ $municipality }}" class="text-sm text-paragraph">
                                                {{ ucwords($municipality) }}</option>
                                        @endif
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
                                        @if ($current_barangay === $cbarangay)
                                            <option value="{{ $current_barangay }}" class="text-sm text-black"
                                                selected>
                                                {{ ucwords($current_barangay) }}
                                            </option>
                                        @else
                                            <option value="{{ $cbarangay }}" class="text-sm text-paragraph">
                                                {{ ucwords($cbarangay) }}</option>
                                        @endif
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
                <div class="bg-card p-8 rounded-4xl w-160 flex flex-col gap-8">
                    <div class="flex w-full items-center-safe justify-between">
                        <div class="flex items-center gap-2">
                            <img src="{{ asset('images/account.png') }}" class="h-8" alt="" />
                            <h1 class="text-3xl font-bold text-heading-dark">
                                Edit Student Account
                            </h1>
                        </div>
                        <button wire:click="resetAccount"
                            class="flex items-center-safe gap-2 text-sm bg-white py-1.5 px-3 rounded-xl hover:bg-danger hover:text-white cursor-pointer">
                            <span class="material-symbols-rounded">
                                settings_backup_restore
                            </span>
                            <p>Reset to Default</p>
                        </button>
                    </div>

                    <div class="flex flex-col gap-3">
                        <div class="flex w-full items-center-safe justify-between">
                            <h2 class="font-semibold text-xl">Student's Account</h2>
                        </div>

                        <div class="flex flex-col gap-2">
                            <input type="text"placeholder="Username"
                                value="{{ $account_username_changed ? '**********' : $account_username }}" disabled
                                class="px-4 py-2 rounded-lg bg-white placeholder-paragraph outline-none w-full" />
                            <input type="text" placeholder="Password"
                                value="{{ $account_password_changed ? '**********' : $default_password }}" disabled
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
                            wire:click="editStudent">
                            Save
                        </button>
                    </div>
                </div>
            @endif
            <!-- End of Third form -->
        </section>
    @endif
</div>
