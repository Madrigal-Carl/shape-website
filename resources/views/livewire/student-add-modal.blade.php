<div>
    @if ($step !== 0)
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
                        <input type="image" src="https://placehold.co/100x100" alt=""
                            class="w-15 rounded-full" />
                        <div class="flex items-center gap-2 px-6 py-3 border-1 border-dashed rounded-full hover:text-blue-button"
                            id="dropzone">
                            <!-- Image dropzone -->
                            <h1 class="">Upload Photo</h1>
                            <span class="material-symbols-rounded">add_photo_alternate</span>
                            <input type="file" name="" id="" class="hidden" />
                        </div>
                    </div>

                    <div class="flex flex-col gap-3">
                        <h2 class="font-medium text-lg">Learners Information</h2>
                        <div class="flex flex-col gap-2">
                            <input type="text" placeholder="LRN"
                                class="px-3 py-1 rounded-lg bg-card placeholder-paragraph outline-none w-full" />

                            <div class="flex items-center gap-2 w-full">
                                <input type="text" placeholder="First name"
                                    class="px-3 py-1 rounded-lg bg-card placeholder-paragraph outline-none w-full" />
                                <input type="text" placeholder="Middle name"
                                    class="px-3 py-1 rounded-lg bg-card placeholder-paragraph outline-none w-full" />
                                <input type="text" placeholder="Last name"
                                    class="px-3 py-1 rounded-lg bg-card placeholder-paragraph outline-none w-full" />
                            </div>

                            <input type="text" placeholder="Birthdate"
                                class="px-2.5 py-1 rounded-lg bg-card placeholder-paragraph outline-none w-full text-paragraph"
                                onfocus="this.type='date'" onblur="if(!this.value) this.type='text'" />

                            <div class="px-2 py-1 rounded-lg bg-card">
                                <select name="" id="" class="w-full outline-none text-paragraph">
                                    <option value="pending" class="text-sm text-black" selected disabled>
                                        Sex
                                    </option>
                                    <option value="pending" class="text-sm text-paragraph">
                                        Male
                                    </option>
                                    <option value="pending" class="text-sm text-paragraph">
                                        Female
                                    </option>
                                </select>
                            </div>

                            <div class="px-2 py-1 rounded-lg bg-card">
                                <select name="" id="" class="w-full outline-none text-paragraph">
                                    <option value="pending" class="text-sm text-black" selected disabled>
                                        Grade Level
                                    </option>
                                    <option value="pending" class="text-sm text-paragraph">
                                        1
                                    </option>
                                    <option value="pending" class="text-sm text-paragraph">
                                        2
                                    </option>
                                    <option value="pending" class="text-sm text-paragraph">
                                        3
                                    </option>
                                    <option value="pending" class="text-sm text-paragraph">
                                        4
                                    </option>
                                </select>
                            </div>

                            <div class="px-2 py-1 rounded-lg bg-card">
                                <select name="" id="" class="w-full outline-none text-paragraph">
                                    <option value="pending" class="text-sm text-black" selected disabled>
                                        Disability
                                    </option>
                                    <option value="pending" class="text-sm text-paragraph">
                                        1
                                    </option>
                                    <option value="pending" class="text-sm text-paragraph">
                                        2
                                    </option>
                                    <option value="pending" class="text-sm text-paragraph">
                                        3
                                    </option>
                                    <option value="pending" class="text-sm text-paragraph">
                                        4
                                    </option>
                                </select>
                            </div>

                            <textarea name="" id="" maxlength="200" placeholder="Description (Optional)"
                                class="px-3 py-2 rounded-lg bg-card placeholder-paragraph resize-none h-24 outline-none"></textarea>
                        </div>
                    </div>
                    <!-- buttons -->
                    <div class="flex items-center gap-2">
                        <button class="bg-gray-100 py-1.5 px-3 w-full rounded-xl text-heading-dark font-medium"
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
                <div class="bg-white p-8 rounded-4xl w-150 hidden flex-col gap-8">
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
                                    <option value="pending" class="text-sm text-black" selected disabled>
                                        Barangay
                                    </option>
                                    <option value="pending" class="text-sm text-paragraph">
                                        1
                                    </option>
                                    <option value="pending" class="text-sm text-paragraph">
                                        2
                                    </option>
                                    <option value="pending" class="text-sm text-paragraph">
                                        3
                                    </option>
                                    <option value="pending" class="text-sm text-paragraph">
                                        4
                                    </option>
                                </select>
                            </div>

                            <div class="px-2 py-1 rounded-lg bg-card w-full">
                                <select name="" id="" class="w-full outline-none text-paragraph">
                                    <option value="pending" class="text-sm text-black" selected disabled>
                                        Municipal
                                    </option>
                                    <option value="pending" class="text-sm text-paragraph">
                                        1
                                    </option>
                                    <option value="pending" class="text-sm text-paragraph">
                                        2
                                    </option>
                                    <option value="pending" class="text-sm text-paragraph">
                                        3
                                    </option>
                                    <option value="pending" class="text-sm text-paragraph">
                                        4
                                    </option>
                                </select>
                            </div>

                            <div class="px-2 py-1 rounded-lg bg-card w-full">
                                <select name="" id="" class="w-full outline-none text-paragraph">
                                    <option value="pending" class="text-sm text-black" selected disabled>
                                        Province
                                    </option>
                                    <option value="pending" class="text-sm text-paragraph">
                                        1
                                    </option>
                                    <option value="pending" class="text-sm text-paragraph">
                                        2
                                    </option>
                                    <option value="pending" class="text-sm text-paragraph">
                                        3
                                    </option>
                                    <option value="pending" class="text-sm text-paragraph">
                                        4
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col gap-3">
                        <h2 class="font-medium text-lg">Current Address</h2>
                        <div class="flex items-center gap-2 w-full">
                            <div class="px-2 py-1 rounded-lg bg-card w-full">
                                <select name="" id="" class="w-full outline-none text-paragraph">
                                    <option value="pending" class="text-sm text-black" selected disabled>
                                        Barangay
                                    </option>
                                    <option value="pending" class="text-sm text-paragraph">
                                        1
                                    </option>
                                    <option value="pending" class="text-sm text-paragraph">
                                        2
                                    </option>
                                    <option value="pending" class="text-sm text-paragraph">
                                        3
                                    </option>
                                    <option value="pending" class="text-sm text-paragraph">
                                        4
                                    </option>
                                </select>
                            </div>

                            <div class="px-2 py-1 rounded-lg bg-card w-full">
                                <select name="" id="" class="w-full outline-none text-paragraph">
                                    <option value="pending" class="text-sm text-black" selected disabled>
                                        Municipal
                                    </option>
                                    <option value="pending" class="text-sm text-paragraph">
                                        1
                                    </option>
                                    <option value="pending" class="text-sm text-paragraph">
                                        2
                                    </option>
                                    <option value="pending" class="text-sm text-paragraph">
                                        3
                                    </option>
                                    <option value="pending" class="text-sm text-paragraph">
                                        4
                                    </option>
                                </select>
                            </div>

                            <div class="px-2 py-1 rounded-lg bg-card w-full">
                                <select name="" id="" class="w-full outline-none text-paragraph">
                                    <option value="pending" class="text-sm text-black" selected disabled>
                                        Province
                                    </option>
                                    <option value="pending" class="text-sm text-paragraph">
                                        1
                                    </option>
                                    <option value="pending" class="text-sm text-paragraph">
                                        2
                                    </option>
                                    <option value="pending" class="text-sm text-paragraph">
                                        3
                                    </option>
                                    <option value="pending" class="text-sm text-paragraph">
                                        4
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3">
                        <h2 class="font-medium text-lg">Guardian's Information</h2>
                        <div class="flex flex-col gap-2">
                            <input type="text" placeholder="First name"
                                class="px-3 py-1 rounded-lg bg-card placeholder-paragraph outline-none w-full" />
                            <input type="text" placeholder="Middle name"
                                class="px-3 py-1 rounded-lg bg-card placeholder-paragraph outline-none w-full" />
                            <input type="text" placeholder="Lastname"
                                class="px-3 py-1 rounded-lg bg-card placeholder-paragraph outline-none w-full" />
                            <input type="email" name="" id="" placeholder="Email"
                                class="px-3 py-1 rounded-lg bg-card placeholder-paragraph outline-none w-full" />
                            <input type="number" name="" id="" placeholder="Phone no."
                                class="px-3 py-1 rounded-lg bg-card placeholder-paragraph outline-none w-full" />
                        </div>
                    </div>

                    <!-- buttons -->
                    <div class="flex items-center gap-2">
                        <button class="bg-gray-100 py-1.5 px-3 w-full rounded-xl text-heading-dark font-medium"
                            wire:click="closeModal">
                            Cancel
                        </button>
                        <button type="submit"
                            class="bg-yellowOrange py-1.5 px-3 w-full rounded-xl text-white font-medium"
                            wire:click="previousStep">
                            Prev
                        </button>
                        <button type="submit"
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
                <div class="bg-white p-8 rounded-4xl w-150 hidden flex-col gap-8">
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('images/form.png') }}" alt="" />
                        <h1 class="text-2xl font-semibold text-heading-dark">
                            Create Student Account
                        </h1>
                    </div>

                    <div class="flex flex-col gap-3">
                        <h2 class="font-medium text-lg">Assign Curriculum</h2>
                        <div class="px-2 py-1 rounded-lg bg-card w-full">
                            <select name="" id="" class="w-full outline-none text-paragraph">
                                <option value="pending" class="text-sm text-black" selected disabled>
                                    Barangay
                                </option>
                                <option value="pending" class="text-sm text-paragraph">1</option>
                                <option value="pending" class="text-sm text-paragraph">2</option>
                                <option value="pending" class="text-sm text-paragraph">3</option>
                                <option value="pending" class="text-sm text-paragraph">4</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3">
                        <h2 class="font-medium text-lg">Guardian's Information</h2>
                        <div class="flex flex-col gap-2">
                            <input type="email" name="" id="" placeholder="Email"
                                class="px-3 py-1 rounded-lg bg-card placeholder-paragraph outline-none w-full" />
                            <input type="password" name="" id="" placeholder="Phone no."
                                class="px-3 py-1 rounded-lg bg-card placeholder-paragraph outline-none w-full" />
                        </div>
                    </div>

                    <!-- buttons -->
                    <div class="flex items-center gap-2">
                        <button class="bg-gray-100 py-1.5 px-3 w-full rounded-xl text-heading-dark font-medium"
                            wire:click="closeModal">
                            Cancel
                        </button>
                        <button type="submit"
                            class="bg-yellowOrange py-1.5 px-3 w-full rounded-xl text-white font-medium"
                            wire:click="previousStep">
                            Prev
                        </button>
                        <button type="submit"
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
