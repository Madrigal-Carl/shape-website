<div>
    @if ($step > 0)
        <section id="teacherFormPopup"
            class="fixed inset-0 z-50 bg-black/40 backdrop-blur-sm flex justify-center items-center overflow-y-auto p-4 gap-6">
            <!-- Form 1 -->
            @if ($step === 1)
                <div id="firstForm"
                    class="bg-white rounded-3xl shadow-2xl w-full max-w-xl p-8 flex flex-col gap-8 animate-fade-in">
                    <!-- Header -->
                    <div class="flex items-center gap-2">
                        <img src="{{asset('images/form.png')}}" alt=""/>
                        <h1 class="text-2xl font-semibold text-heading-dark">Edit Teacher's Form</h1>
                    </div>

                    <!-- Upload Photo -->
                    <div class="flex items-center gap-4">
                        <img id="profilePreview" src="https://placehold.co/100x100" alt="Profile"
                            class="w-20 h-20 rounded-full object-cover" />
                        <label
                            class="flex items-center gap-2 px-6 py-2 border border-gray-300 rounded-full cursor-pointer hover:text-blue-600 shadow-sm hover:shadow-md transition">
                            <span>Upload Photo</span>
                            <span class="material-symbols-rounded">add_photo_alternate</span>
                            <input type="file" id="profileInput" class="hidden" accept="image/*" />
                        </label>
                    </div>

                    <!-- Teachers Information -->
                    <div class="flex flex-col gap-3">
                        <h2 class="font-semibold text-lg">Teachers Information</h2>

                        <input type="text" placeholder="License Number"
                            class="px-4 py-2 rounded-lg bg-gray-100 placeholder:text-paragraph outline-none w-full" />

                        <div class="flex flex-col sm:flex-row gap-2">
                            <input type="text" placeholder="First name"
                                class="px-4 py-2 rounded-lg bg-gray-100 placeholder:text-paragraph outline-none w-full" />
                            <input type="text" placeholder="Middle name"
                                class="px-4 py-2 rounded-lg bg-gray-100 placeholder:text-paragraph outline-none w-full" />
                            <input type="text" placeholder="Last name"
                                class="px-4 py-2 rounded-lg bg-gray-100 placeholder:text-paragraph outline-none w-full" />
                        </div>

                        <div class="relative">
                            <input type="text" placeholder="Birthdate"
                                class="px-4 py-2 rounded-lg bg-gray-100 placeholder:text-paragraph outline-none w-full"
                                onfocus="this.type='date'" onblur="if(!this.value)this.type='text'" />
                            <span
                                class="material-symbols-rounded absolute right-3 top-2.5 text-paragraph">calendar_today</span>
                        </div>

                        <div class="px-4 py-2 rounded-lg bg-card">
                            <select class="rounded-lg text-paragraph outline-none w-full">
                                <option disabled selected>Sex</option>
                                <option>Male</option>
                                <option>Female</option>
                            </select>
                        </div>

                        <div class="px-4 py-2 rounded-lg bg-card">
                            <select class="rounded-lg text-paragraph outline-none w-full">
                                <option disabled selected>Grade Level</option>
                                <option>Kindergarten</option>
                                <option>Grade 1</option>
                                <option>Grade 2</option>
                                <option>Grade 3</option>
                            </select>
                        </div>

                        <div class="px-4 py-2 rounded-lg bg-card">
                            <select class="rounded-lg text-paragraph outline-none w-full">
                                <option disabled selected>Specialization</option>
                                <option>Math</option>
                                <option>English</option>
                                <option>Science</option>
                                <option>Filipino</option>
                            </select>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-4">
                        <button id="cancelBtn" type="button" wire:click='closeModal'
                            class="bg-gray-100 py-2 px-4 w-full rounded-xl text-heading-dark font-medium transition">
                            Cancel
                        </button>
                        <button wire:click="nextStep" type="button"
                            class="bg-blue-button py-2 px-4 w-full rounded-xl text-white font-medium transition"
                            id="nextBtn">
                            Next
                        </button>
                    </div>
                </div>
            @endif

            <!-- Second form -->
            @if ($step === 2)
                <div id="secondForm"
                    class="bg-white rounded-3xl shadow-2xl w-full max-w-xl p-8 flex-col gap-8 animate-fade-in flex">
                    <div class="flex items-center gap-2">
                        <img src="{{asset('images/form.png')}}" alt="" />
                        <h1 class="text-2xl font-semibold text-heading-dark">
                            Edit Teacher's Form
                        </h1>
                    </div>
                    <!-- Permanent Address -->
                    <div class="flex flex-col gap-3">
                        <h2 class="font-medium text-lg">Permanent Address</h2>
                        <div class="flex items-center gap-2 w-full">
                            <!-- Province (Fixed) -->
                            <div class="px-2 py-1 rounded-lg bg-card w-full">
                                <select disabled class="w-full outline-none text-paragraph">
                                    <option selected>Marinduque</option>
                                </select>
                            </div>

                            <!-- Municipality -->
                            <div class="px-2 py-1 rounded-lg bg-card w-full">
                                <select id="perm-muni" class="w-full outline-none text-paragraph">
                                    <option disabled selected>Municipality</option>
                                    <option value="Boac">Boac</option>
                                    <option value="Mogpog">Mogpog</option>
                                    <option value="Gasan">Gasan</option>
                                    <option value="Buenavista">Buenavista</option>
                                    <option value="Torrijos">Torrijos</option>
                                    <option value="Santa Cruz">Santa Cruz</option>
                                </select>
                            </div>

                            <!-- Barangay (searchable) -->
                            <div class="px-2 py-1 rounded-lg bg-card w-full">
                                <input list="perm-brgy-list" id="perm-brgy"
                                    class="w-full outline-none text-paragraph px-3 py-2 rounded-lg placeholder:text-paragraph"
                                    placeholder="Barangay" />
                                <datalist id="perm-brgy-list"></datalist>
                            </div>
                        </div>
                    </div>

                    <!-- Current Address -->
                    <div class="flex flex-col gap-3">
                        <h2 class="font-medium text-lg">Current Address</h2>
                        <div class="flex items-center gap-2 w-full">
                            <!-- Province (Fixed) -->
                            <div class="px-2 py-1 rounded-lg bg-card w-full">
                                <select disabled class="w-full outline-none text-paragraph">
                                    <option selected>Marinduque</option>
                                </select>
                            </div>

                            <!-- Municipality -->
                            <div class="px-2 py-1 rounded-lg bg-card w-full">
                                <select id="curr-muni" class="w-full outline-none text-paragraph">
                                    <option disabled selected class="">Municipality</option>
                                    <option value="Boac">Boac</option>
                                    <option value="Mogpog">Mogpog</option>
                                    <option value="Gasan">Gasan</option>
                                    <option value="Buenavista">Buenavista</option>
                                    <option value="Torrijos">Torrijos</option>
                                    <option value="Santa Cruz">Santa Cruz</option>
                                </select>
                            </div>

                            <!-- Barangay (searchable) -->
                            <div class="px-2 py-1 rounded-lg bg-card w-full">
                                <input list="curr-brgy-list" id="curr-brgy"
                                    class="w-full outline-none text-paragraph px-3 py-2 rounded-lg placeholder:text-paragraph"
                                    placeholder="Barangay" />
                                <datalist id="curr-brgy-list"></datalist>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3">
                        <h2 class="font-medium text-lg">Create Account</h2>
                        <div class="flex flex-col gap-2">
                            <input type="text" placeholder="Username"
                                class="px-3 py-4 rounded-lg bg-card placeholder-paragraph outline-none w-full" />
                            <input type="password" placeholder="Password"
                                class="px-3 py-2 rounded-lg bg-card placeholder-paragraph outline-none w-full" />
                        </div>
                    </div>

                    <!-- buttons -->
                    <div class="flex items-center gap-2">
                        <button id="cancelSecondBtn" type="button" wire:click='closeModal'
                            class="bg-gray-100 py-1.5 px-3 w-full rounded-xl text-heading-dark font-medium">
                            Cancel
                        </button>
                        <button id="prevBtn" type="button" wire:click="previousStep"
                            class="bg-yellowOrange py-1.5 px-3 w-full rounded-xl text-white font-medium">
                            Prev
                        </button>
                        <button id="submitBtn" type="button" wire:click='addInstructor'
                            class="bg-blue-button py-1.5 px-3 w-full rounded-xl text-white font-medium">
                            Submit
                        </button>
                    </div>
                </div>
            @endif
        </section>
    @endif
</div>
