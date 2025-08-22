<div>
    @if ($step > 0)
        <section
            class="bg-black/30 fixed w-dvw h-dvh top-0 left-0 z-50 backdrop-blur-xs flex justify-center items-center overflow-y-auto p-10">
            <!-- first form -->
            @if ($step === 1)
                <div class="bg-white p-8 rounded-4xl w-150 flex flex-col gap-8">
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('images/form.png') }}" alt="" />
                        <h1 class="text-2xl font-semibold text-heading-dark">
                            Education Enrollment Form
                        </h1>
                    </div>

                    <div class="flex items-center gap-4">
                        <div>
                            @if ($photo)
                                <img src="{{ $photo->temporaryUrl() }}" class="w-15 h-15 rounded-full object-cover" />
                            @else
                                <img src="https://placehold.co/100x100" class="w-15 h-15 rounded-full object-cover" />
                            @endif
                        </div>
                        <label for="photo-upload"
                            class="flex items-center gap-2 px-6 py-3 border border-dashed rounded-full cursor-pointer hover:text-blue-500">
                            <h1>Upload Photo</h1>
                            <span class="material-symbols-rounded">add_photo_alternate</span>
                            <input type="file" id="photo-upload" class="hidden" wire:model="photo"
                                accept="image/*" />
                        </label>
                    </div>

                    <div class="flex flex-col gap-3">
                        <h2 class="font-medium text-lg">Learners Information</h2>
                        <div class="flex flex-col gap-2">
                            <input type="text" placeholder="LRN" wire:model.live='lrn' maxlength="12"
                                class="px-3 py-1 rounded-lg bg-card placeholder-paragraph outline-none w-full" />

                            <div class="flex items-center gap-2 w-full">
                                <input type="text" placeholder="First name" wire:model.live='first_name'
                                    class="px-3 py-1 rounded-lg bg-card placeholder-paragraph outline-none w-full" />
                                <input type="text" placeholder="Middle name" wire:model.live='middle_name'
                                    class="px-3 py-1 rounded-lg bg-card placeholder-paragraph outline-none w-full" />
                                <input type="text" placeholder="Last name" wire:model.live='last_name'
                                    class="px-3 py-1 rounded-lg bg-card placeholder-paragraph outline-none w-full" />
                            </div>

                            <input type="text" placeholder="Birthdate" wire:model.live='birthdate'
                                class="px-2.5 py-1 rounded-lg bg-card placeholder-paragraph outline-none w-full text-paragraph"
                                onfocus="this.type='date'" onblur="if(!this.value) this.type='text'" />

                            <div class="px-2 py-1 rounded-lg bg-card">
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

                            <div class="px-2 py-1 rounded-lg bg-card">
                                <select name="" id="" class="w-full outline-none text-paragraph"
                                    wire:change="$set('grade_level', $event.target.value)">
                                    @foreach ($grade_levels as $level)
                                        @if ($grade_level === $level)
                                            <option value="{{ $grade_level }}" class="text-sm text-black" selected
                                                disabled>
                                                {{ ucwords($grade_level) }}
                                            </option>
                                        @else
                                            <option value="{{ $level }}" class="text-sm text-paragraph">
                                                {{ ucwords($level) }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div class="px-2 py-1 rounded-lg bg-card">
                                <select name="" id="" class="w-full outline-none text-paragraph"
                                    wire:change="$set('disability', $event.target.value)">
                                    @foreach ($specializations as $specialization)
                                        @if ($disability === $specialization)
                                            <option value="{{ $disability }}" class="text-sm text-black" selected
                                                disabled>
                                                {{ ucwords($disability) }}
                                            </option>
                                        @else
                                            <option value="{{ $specialization }}" class="text-sm text-paragraph">
                                                {{ ucwords($specialization) }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <textarea name="" id="" maxlength="200" placeholder="Description (Optional)"
                                wire:model.live='description'
                                class="px-3 py-2 rounded-lg bg-card placeholder-paragraph resize-none h-24 outline-none"></textarea>
                        </div>
                    </div>
                    <!-- buttons -->
                    <div class="flex items-center gap-2">
                        <button type="button"
                            class="bg-gray-100 py-1.5 px-3 w-full rounded-xl text-heading-dark font-medium"
                            wire:click="closeModal" type="button">
                            Cancel
                        </button>
                        <button type="button"
                            class="bg-blue-button py-1.5 px-3 w-full rounded-xl text-white font-medium"
                            wire:click="nextStep">
                            Next
                        </button>
                    </div>
                </div>
            @endif
            <!-- End of first form -->

            <!-- Second form -->
            @if ($step === 2)
                <div class="bg-white p-8 rounded-4xl w-150 flex flex-col gap-8">
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('images/form.png') }}" alt="" />
                        <h1 class="text-2xl font-semibold text-heading-dark">
                            Education Enrollment Form
                        </h1>
                    </div>

                    <div class="flex flex-col gap-3">
                        <h2 class="font-medium text-lg">Permanent Address</h2>
                        <div class="flex items-center gap-2 w-full">
                            <div class="px-2 py-1 rounded-lg bg-card w-full">
                                <select name="" id="" class="w-full outline-none text-paragraph">
                                    <option value="marinduque" class="text-sm text-black" selected disabled>
                                        Marinduque
                                    </option>
                                </select>
                            </div>
                            <div class="px-2 py-1 rounded-lg bg-card w-full">
                                <select name="" id="" class="w-full outline-none text-paragraph"
                                    wire:change="$set('permanent_municipal', $event.target.value)">
                                    <option class="text-sm text-black" selected disabled>
                                        Municipal
                                    </option>
                                    @foreach ($municipalities as $municipality)
                                        <option value="{{ $municipality }}" class="text-sm text-paragraph">
                                            {{ $municipality }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="px-2 py-1 rounded-lg bg-card w-full">
                                <select name="" id="" class="w-full outline-none text-paragraph"
                                    wire:change="$set('permanent_barangay', $event.target.value)">
                                    <option class="text-sm text-black" selected disabled>
                                        Barangay
                                    </option>
                                    @foreach ($barangays as $barangay)
                                        <option value="{{ $barangay }}" class="text-sm text-paragraph">
                                            {{ $barangay }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col gap-3">
                        <h2 class="font-medium text-lg">Current Address</h2>
                        <div class="flex items-center gap-2 w-full">
                            <div class="px-2 py-1 rounded-lg bg-card w-full">
                                <select name="" id="" class="w-full outline-none text-paragraph">
                                    <option value="marinduque" class="text-sm text-black" selected disabled>
                                        Marinduque
                                    </option>
                                </select>
                            </div>
                            <div class="px-2 py-1 rounded-lg bg-card w-full">
                                <select name="" id="" class="w-full outline-none text-paragraph"
                                    wire:change="$set('current_municipal', $event.target.value)">
                                    <option class="text-sm text-black" selected disabled>
                                        Municipal
                                    </option>
                                    @foreach ($municipalities as $municipality)
                                        <option value="{{ $municipality }}" class="text-sm text-paragraph">
                                            {{ $municipality }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="px-2 py-1 rounded-lg bg-card w-full">
                                <select name="" id="" class="w-full outline-none text-paragraph"
                                    wire:change="$set('current_barangay', $event.target.value)">
                                    <option class="text-sm text-black" selected disabled>
                                        Barangay
                                    </option>
                                    @foreach ($barangays as $barangay)
                                        <option value="{{ $barangay }}" class="text-sm text-paragraph">
                                            {{ $barangay }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3">
                        <h2 class="font-medium text-lg">Guardian's Information</h2>
                        <div class="flex flex-col gap-2">
                            <input type="text" placeholder="First name" wire:model.live="guardian_first_name"
                                class="px-3 py-1 rounded-lg bg-card placeholder-paragraph outline-none w-full" />
                            <input type="text" placeholder="Middle name" wire:model.live="guardian_middle_name"
                                class="px-3 py-1 rounded-lg bg-card placeholder-paragraph outline-none w-full" />
                            <input type="text" placeholder="Lastname" wire:model.live="guardian_last_name"
                                class="px-3 py-1 rounded-lg bg-card placeholder-paragraph outline-none w-full" />
                            <input type="email" name="" id="" placeholder="Email"
                                wire:model.live="guardian_email"
                                class="px-3 py-1 rounded-lg bg-card placeholder-paragraph outline-none w-full" />
                            <input type="text" name="" id="" placeholder="Phone no. (Optional)"
                                wire:model.live="guardian_phone" maxlength="10"
                                class="px-3 py-1 rounded-lg bg-card placeholder-paragraph outline-none w-full" />
                        </div>
                    </div>

                    <!-- buttons -->
                    <div class="flex items-center gap-2">
                        <button type="button"
                            class="bg-gray-100 py-1.5 px-3 w-full rounded-xl text-heading-dark font-medium"
                            wire:click="closeModal">
                            Cancel
                        </button>
                        <button type="button"
                            class="bg-yellowOrange py-1.5 px-3 w-full rounded-xl text-white font-medium"
                            wire:click="previousStep">
                            Prev
                        </button>
                        <button type="button"
                            class="bg-blue-button py-1.5 px-3 w-full rounded-xl text-white font-medium"
                            wire:click="nextStep">
                            Next
                        </button>
                    </div>
                </div>
            @endif
            <!-- End of Second form -->

            <!-- Third form -->
            @if ($step === 3)
                <div class="bg-white p-8 rounded-4xl w-150 flex flex-col gap-8">
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('images/form.png') }}" alt="" />
                        <h1 class="text-2xl font-semibold text-heading-dark">
                            Create Student Account
                        </h1>
                    </div>

                    <div class="flex flex-col gap-3">
                        <h2 class="font-medium text-lg">Student's Account</h2>
                        <div class="flex flex-col gap-2">
                            <input type="text" name="" id="" placeholder="Username"
                                wire:model.live='account_username'
                                class="px-3 py-1 rounded-lg bg-card placeholder-paragraph outline-none w-full" />
                            <input type="password" name="" id="" placeholder="Password"
                                wire:model.live='account_password'
                                class="px-3 py-1 rounded-lg bg-card placeholder-paragraph outline-none w-full" />
                        </div>
                    </div>

                    <!-- buttons -->
                    <div class="flex items-center gap-2">
                        <button type="button"
                            class="bg-gray-100 py-1.5 px-3 w-full rounded-xl text-heading-dark font-medium"
                            wire:click="closeModal">
                            Cancel
                        </button>
                        <button type="button"
                            class="bg-yellowOrange py-1.5 px-3 w-full rounded-xl text-white font-medium"
                            wire:click="previousStep">
                            Prev
                        </button>
                        <button type="button"
                            class="bg-blue-button py-1.5 px-3 w-full rounded-xl text-white font-medium"
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
