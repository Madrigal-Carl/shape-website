<main class="col-span-7 pl-4 pr-8 py-4 flex flex-col h-dvh gap-4 overflow-y-auto">
    <h1 class="text-4xl font-bold">Profile Info.</h1>
    <!-- Greetings -->
    <div class="bg-white flex gap-2 mt-4 w-auto justify-between p-12 rounded-3xl">
        <div class="flex gap-8 items-center">
            <img src="{{ asset('storage/' . auth()->user()->accountable->path) }}"
                class="w-36 h-36 aspect-square rounded-full" alt="" />

            {{-- <img src="https://placehold.co/100x100" class="w-35 h-35 rounded-full object-cover bg-white p-2 shadow-2xl" /> --}}

            <div class="flex flex-col gap-2">
                <label for="photo-upload"
                    class="w-fit flex items-center border-1 border-gray-300 gap-2 px-4 py-2 bg-white rounded-2xl cursor-pointer hover:text-white hover:border-blue-button hover:bg-blue-button">
                    <span class="material-symbols-rounded">add_photo_alternate</span>
                    <h1>Upload new photo</h1>
                    <input type="file" id="photo-upload" class="hidden" wire:model="photo" accept="image/*" />
                </label>
                <div class="flex flex-col text-paragraph text-sm">
                    <p>At least 800x800 px recommended. </p>
                    <p>JPG or PNG id allowed. </p>
                </div>

            </div>

        </div>

    </div>

    <div class="bg-white flex flex-col gap-4 w-auto justify-between p-12 rounded-[24px]">
        {{-- Personal Basic Info --}}
        <div class="w-full border-1 border-card p-4 rounded-[12px] flex flex-col gap-2">
            <div class="flex w-full items-start justify-between">
                <h1 class=" text-2xl font-semibold">Full name</h1>

                <div class="flex gap-2 items-center">
                    <!-- when in edit this button will become cancel -->
                    <button
                        class="w-fit flex items-center border-1 border-gray-300 gap-1 px-4 py-2 bg-white rounded-2xl cursor-pointer hover:text-white hover:border-blue-button hover:bg-blue-button">
                        <span
                            class="material-symbols-rounded">edit</span><!-- when in edit this button will become 'cancel' icon-->
                        <p>edit</p>
                    </button>

                    <!-- when in edit this button will appear as save-->
                    <button
                        class="w-fit hidden items-center border-1 border-gray-300 gap-1 px-4 py-2 bg-white rounded-2xl cursor-pointer hover:text-white hover:border-blue-button hover:bg-blue-button">
                        <span class="material-symbols-rounded">save</span>
                        <p>Save</p>
                    </button>
                </div>

            </div>


            <!-- Personal Inputs -->
            <div class="grid grid-cols-3 gap-4">
                <div class="flex flex-col gap-1">
                    <label for="" class="text-paragraph">First name</label>
                    <input wire:model="text"
                        class=" placeholder:text-heading-dark placeholder:font-medium bg-card px-3 py-1.5 rounded-xl outline-none border-1 border-white focus:border-blue-button hover:border-blue-button"
                        type="text" placeholder="Erickson Dave" />
                </div>
                <div class="flex flex-col gap-1">
                    <label for="" class="text-paragraph">Middle name</label>
                    <input wire:model="username"
                        class=" placeholder:text-heading-dark placeholder:font-medium bg-card px-3 py-1.5 rounded-xl outline-none border-1 border-white focus:border-blue-button hover:border-blue-button"
                        type="text" placeholder="Cruzado" />
                </div>
                <div class="flex flex-col gap-1">
                    <label for="" class="text-paragraph">Last name</label>
                    <input wire:model="text"
                        class=" placeholder:text-heading-dark placeholder:font-medium bg-card px-3 py-1.5 rounded-xl outline-none border-1 border-white focus:border-blue-button hover:border-blue-button"
                        type="text" placeholder="Geroleo" />
                </div>
            </div>
        </div>

        <div class="w-full border-1 border-card p-4 rounded-[12px] flex flex-col gap-2">
            <div class="flex w-full items-start justify-between">
                <h1 class=" text-2xl font-semibold">Address</h1>

                <div class="flex gap-2 items-center">
                    <!-- when in edit this button will become cancel -->
                    <button
                        class="w-fit flex items-center border-1 border-gray-300 gap-1 px-4 py-2 bg-white rounded-2xl cursor-pointer hover:text-white hover:border-blue-button hover:bg-blue-button">
                        <span
                            class="material-symbols-rounded">edit</span><!-- when in edit this button will become 'cancel' icon-->
                        <p>edit</p>
                    </button>

                    <!-- when in edit this button will appear as save-->
                    <button
                        class="w-fit hidden items-center border-1 border-gray-300 gap-1 px-4 py-2 bg-white rounded-2xl cursor-pointer hover:text-white hover:border-blue-button hover:bg-blue-button">
                        <span class="material-symbols-rounded">save</span>
                        <p>Save</p>
                    </button>
                </div>

            </div>


            <!-- Address Inputs -->
            <div class="grid grid-cols-3 gap-4">
                <div class="flex flex-col gap-1">
                    <label for="" class="text-paragraph">Province</label>
                    <div
                        class="w-full bg-card px-3 py-1.5 rounded-xl outline-none border-1 border-white focus:border-blue-button hover:border-blue-button">
                        <select name="" id="" class="w-full outline-none text-heading-dark font-medium">
                            <option value="marinduque" class="text-sm text-heading-dark" selected disabled>
                                Marinduque
                            </option>
                        </select>
                    </div>
                </div>

                <div class="flex flex-col gap-1">
                    <label for="" class="text-paragraph">Municipality</label>
                    <div
                        class="w-full bg-card px-3 py-1.5 rounded-xl outline-none border-1 border-white focus:border-blue-button hover:border-blue-button">
                        <select name="" id="" class="w-full outline-none text-heading-dark font-medium">
                            <option value="marinduque" class="text-sm text-heading-dark" selected disabled>
                                Boac
                            </option>
                        </select>
                    </div>
                </div>

                <div class="flex flex-col gap-1">
                    <label for="" class="text-paragraph">Barangay</label>
                    <div
                        class="w-full bg-card px-3 py-1.5 rounded-xl outline-none border-1 border-white focus:border-blue-button hover:border-blue-button">
                        <select name="" id="" class="w-full outline-none text-heading-dark font-medium">
                            <option value="marinduque" class="text-sm text-heading-dark" selected disabled>
                                Balimbing
                            </option>
                        </select>
                    </div>
                </div>

            </div>
        </div>





        {{-- Account Info --}}
        <div class="w-full bg-card p-4 rounded-[12px] flex flex-col gap-2">
            <div class="flex w-full items-start justify-between">
                <h1 class=" text-2xl font-semibold">Account Info</h1>
                <div class="flex gap-2 items-center">
                    <!-- when in edit this button will become cancel -->
                    <button
                        class="w-fit flex items-center border-1 border-gray-300 gap-1 px-4 py-2 bg-white rounded-2xl cursor-pointer hover:text-white hover:border-blue-button hover:bg-blue-button">
                        <span
                            class="material-symbols-rounded">edit</span><!-- when in edit this button will become 'cancel' icon-->
                        <p>edit</p>
                    </button>

                    <!-- when in edit this button will appear as save-->
                    <button
                        class="w-fit hidden items-center border-1 border-gray-300 gap-1 px-4 py-2 bg-white rounded-2xl cursor-pointer hover:text-white hover:border-blue-button hover:bg-blue-button">
                        <span class="material-symbols-rounded">save</span>
                        <p>Save</p>
                    </button>
                </div>
            </div>


            <!-- Account Inputs when in default-->
            <div class="grid grid-cols-2 gap-4">
                <div class="flex flex-col gap-1">
                    <label for="" class="text-paragraph">Username</label>
                    <input wire:model="text"
                        class=" placeholder:text-heading-dark placeholder:font-medium bg-white px-3 py-1.5 rounded-xl outline-none border-1 border-white focus:border-blue-button hover:border-blue-button"
                        type="text" placeholder="davepogi123" />
                </div>
                <div class="flex flex-col gap-1">
                    <label for="" class="text-paragraph">Password</label>
                    <input wire:model="password"
                        class=" placeholder:text-heading-dark placeholder:font-medium bg-white px-3 py-1.5 rounded-xl outline-none border-1 border-white focus:border-blue-button hover:border-blue-button"
                        type="password" placeholder="password123" />
                </div>

            </div>

            <!-- Account Inputs when in Edit mode-->

            <div class="hidden grid-cols-3 gap-4"><!-- hidden to grid-->
                <div class="flex flex-col gap-1">
                    <label for="" class="text-paragraph">Enter new Username</label>
                    <input wire:model="text"
                        class=" placeholder:text-heading-dark placeholder:font-medium bg-white px-3 py-1.5 rounded-xl outline-none border-1 border-white focus:border-blue-button hover:border-blue-button"
                        type="username" placeholder="Erickson Dave" />
                </div>
                <div class="flex flex-col gap-1">
                    <label for="" class="text-paragraph">Enter new password</label>
                    <input wire:model="password"
                        class=" placeholder:text-heading-dark placeholder:font-medium bg-white px-3 py-1.5 rounded-xl outline-none border-1 border-white focus:border-blue-button hover:border-blue-button"
                        type="password" placeholder="Cruzado" />
                </div>

                <div class="flex flex-col gap-1">
                    <label for="" class="text-paragraph">Confirm Password</label>
                    <input wire:model="username"
                        class=" placeholder:text-heading-dark placeholder:font-medium bg-white px-3 py-1.5 rounded-xl outline-none border-1 border-white focus:border-blue-button hover:border-blue-button"
                        type="text" placeholder="Cruzado" />
                </div>
            </div>
        </div>
    </div>
</main>
