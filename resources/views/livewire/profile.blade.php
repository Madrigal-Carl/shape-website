<main class="col-span-7 pl-4 pr-7 py-4 flex flex-col h-dvh gap-4 overflow-y-auto">
    <h1 class="text-4xl font-bold">Profile Info.</h1>
    <!-- Greetings -->
    <div class="bg-white flex gap-2 w-auto justify-between p-12 rounded-3xl">
        <div class="flex gap-4 items-center">
            <div class="relative w-36 h-36">
                @if ($photo)
                    <img src="{{ $photo->temporaryUrl() }}" class="w-36 h-36 aspect-square rounded-full object-cover"
                        alt="Preview" />
                @else
                    <img src="{{ asset('storage/' . auth()->user()->accountable->path) }}"
                        class="w-36 h-36 aspect-square rounded-full object-cover" alt="Profile" />
                @endif

                <div wire:loading wire:target="photo" class="absolute inset-0 bg-white/60 rounded-full w-full h-full">
                    <div role="status">
                        <svg aria-hidden="true"
                            class="absolute top-[38%] left-[38%] inline w-10 h-10 text-gray-200 animate-spin fill-blue-600"
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
                </div>
            </div>

            <div class="flex flex-col gap-2">
                <label for="photo-upload"
                    class="w-fit flex items-center border-1 border-gray-300 gap-2 px-4 py-2 bg-white rounded-2xl cursor-pointer hover:text-white hover:border-blue-button hover:bg-blue-button">
                    <span class="material-symbols-rounded">add_photo_alternate</span>
                    <h1>Upload new photo</h1>
                    <input type="file" id="photo-upload" class="hidden" wire:model="photo" accept="image/*" />
                </label>
                <div class="flex flex-col text-paragraph text-sm">
                    <p>At least 800x800 px recommended. </p>
                    <p>JPG or PNG is allowed. </p>
                </div>
            </div>
            @if ($photo)
                <button wire:click="savePhoto"
                    class="mt-2 px-4 py-2 bg-blue-button text-white rounded-xl hover:bg-blue-700">
                    Save Photo
                </button>
            @endif
        </div>
    </div>

    <div class="bg-white flex flex-col gap-4 w-auto justify-between p-12 rounded-[24px]">
        {{-- Personal Basic Info --}}
        <div class="w-full border-1 border-card p-4 rounded-[12px] flex flex-col gap-4">
            <div class="flex w-full items-start justify-between">
                <div class="flex items-center gap-2">
                    <img src="{{ asset('images/person.png') }}" class="h-6" alt="">
                    <h1 class="text-2xl font-semibold">Full name</h1>
                </div>


                <div class="flex gap-2 items-center">
                    <!-- Edit / Cancel -->
                    <button wire:click="toggleEdit"
                        class="w-fit flex items-center border-1 border-gray-300 gap-1 px-4 py-2 bg-white rounded-2xl cursor-pointer hover:text-white hover:border-blue-button hover:bg-blue-button">
                        <span class="material-symbols-rounded">
                            {{ $isEditing ? 'cancel' : 'edit' }}
                        </span>
                        <p>{{ $isEditing ? 'Cancel' : 'Edit' }}</p>
                    </button>

                    <!-- Save -->
                    @if ($isEditing)
                        <button wire:click="save"
                            class="w-fit flex items-center border-1 border-gray-300 gap-1 px-4 py-2 bg-white rounded-2xl cursor-pointer hover:text-white hover:border-blue-button hover:bg-blue-button">
                            <span class="material-symbols-rounded">save</span>
                            <p>Save</p>
                        </button>
                    @endif
                </div>
            </div>

            <!-- Personal Inputs -->
            <div class="grid grid-cols-3 gap-4">
                <div class="flex flex-col gap-1">
                    <label class="text-paragraph">First name</label>
                    <input wire:model="first_name"
                        class="placeholder:text-heading-dark placeholder:font-medium bg-card px-3 py-1.5 rounded-xl outline-none border-1 border-white focus:border-blue-button hover:border-blue-button"
                        type="text" placeholder="Erickson Dave" {{ $isEditing ? '' : 'disabled' }} />
                </div>
                <div class="flex flex-col gap-1">
                    <label class="text-paragraph">Middle name</label>
                    <input wire:model="middle_name"
                        class="placeholder:text-heading-dark placeholder:font-medium bg-card px-3 py-1.5 rounded-xl outline-none border-1 border-white focus:border-blue-button hover:border-blue-button"
                        type="text" placeholder="Cruzado" {{ $isEditing ? '' : 'disabled' }} />
                </div>
                <div class="flex flex-col gap-1">
                    <label class="text-paragraph">Last name</label>
                    <input wire:model="last_name"
                        class="placeholder:text-heading-dark placeholder:font-medium bg-card px-3 py-1.5 rounded-xl outline-none border-1 border-white focus:border-blue-button hover:border-blue-button"
                        type="text" placeholder="Geroleo" {{ $isEditing ? '' : 'disabled' }} />
                </div>
            </div>
        </div>


        <div class="w-full border-1 border-card p-4 rounded-[12px] flex flex-col gap-4">
            <div class="flex w-full items-start justify-between">
                <div class="flex items-center gap-2">
                    <img src="{{ asset('images/address.png') }}" class="h-6" alt="">
                    <h1 class="text-2xl font-semibold">Address</h1>
                </div>

                <div class="flex gap-2 items-center">
                    <button wire:click="toggleEditAddress"
                        class="w-fit flex items-center border-1 border-gray-300 gap-1 px-4 py-2 bg-white rounded-2xl cursor-pointer hover:text-white hover:border-blue-button hover:bg-blue-button">
                        <span class="material-symbols-rounded">
                            {{ $isEditingAddress ? 'cancel' : 'edit' }}
                        </span>
                        <p>{{ $isEditingAddress ? 'Cancel' : 'Edit' }}</p>
                    </button>

                    @if ($isEditingAddress)
                        <button wire:click="saveAddress"
                            class="w-fit flex items-center border-1 border-gray-300 gap-1 px-4 py-2 bg-white rounded-2xl cursor-pointer hover:text-white hover:border-blue-button hover:bg-blue-button">
                            <span class="material-symbols-rounded">save</span>
                            <p>Save</p>
                        </button>
                    @endif
                </div>
            </div>

            <!-- Permanent Address -->
            <div class="flex flex-col gap-2">
                <h2 class="font-semibold text-lg">Permanent Address</h2>
                <div class="grid grid-cols-3 gap-4">
                    <!-- Province -->
                    <div class="flex flex-col gap-1">
                        <label class="text-paragraph">Province</label>
                        <div
                            class="w-full bg-card px-3 py-1.5 rounded-xl outline-none border-1 border-white focus:border-blue-button hover:border-blue-button">
                            <select disabled class="w-full outline-none text-heading-dark font-medium">
                                <option selected>Marinduque</option>
                            </select>
                        </div>
                    </div>

                    <!-- Municipality -->
                    <div class="flex flex-col gap-1">
                        <label class="text-paragraph">Municipality</label>
                        <div
                            class="w-full bg-card px-3 py-1.5 rounded-xl outline-none border-1 border-white focus:border-blue-button hover:border-blue-button">
                            <select wire:model.live="permanent_municipality" {{ $isEditingAddress ? '' : 'disabled' }}
                                class="w-full outline-none text-heading-dark font-medium">
                                <option value="">-- Select Municipality --</option>
                                @foreach ($municipalities as $municipal)
                                    <option value="{{ $municipal }}"
                                        {{ $permanent_municipality === $municipal ? 'selected' : '' }}>
                                        {{ ucwords($municipal) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Barangay -->
                    <div class="flex flex-col gap-1">
                        <label class="text-paragraph">Barangay</label>
                        <div
                            class="w-full bg-card px-3 py-1.5 rounded-xl outline-none border-1 border-white focus:border-blue-button hover:border-blue-button">
                            <select wire:model.live="permanent_barangay"
                                wire:key="permanent-{{ $permanent_municipality }}"
                                {{ $isEditingAddress ? '' : 'disabled' }}
                                {{ empty($permanent_barangays) ? 'disabled' : '' }}
                                class="w-full outline-none text-heading-dark font-medium">
                                <option value="">-- Select Barangay --</option>
                                @foreach ($permanent_barangays as $barangay)
                                    <option value="{{ $barangay }}">{{ ucwords($barangay) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Current Address -->
            <div class="flex flex-col gap-2 mt-2">
                <h2 class="font-semibold text-lg">Current Address</h2>
                <div class="grid grid-cols-3 gap-4">
                    <!-- Province -->
                    <div class="flex flex-col gap-1">
                        <label class="text-paragraph">Province</label>
                        <div
                            class="w-full bg-card px-3 py-1.5 rounded-xl outline-none border-1 border-white focus:border-blue-button hover:border-blue-button">
                            <select disabled class="w-full outline-none text-heading-dark font-medium">
                                <option selected>Marinduque</option>
                            </select>
                        </div>
                    </div>

                    <!-- Municipality -->
                    <div class="flex flex-col gap-1">
                        <label class="text-paragraph">Municipality</label>
                        <div
                            class="w-full bg-card px-3 py-1.5 rounded-xl outline-none border-1 border-white focus:border-blue-button hover:border-blue-button">
                            <select wire:model.live="current_municipality" {{ $isEditingAddress ? '' : 'disabled' }}
                                class="w-full outline-none text-heading-dark font-medium">
                                <option value="">-- Select Municipality --</option>
                                @foreach ($municipalities as $municipal)
                                    <option value="{{ $municipal }}">{{ ucwords($municipal) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Barangay -->
                    <div class="flex flex-col gap-1">
                        <label class="text-paragraph">Barangay</label>
                        <div
                            class="w-full bg-card px-3 py-1.5 rounded-xl outline-none border-1 border-white focus:border-blue-button hover:border-blue-button">
                            <select wire:model.live="current_barangay" wire:key="current-{{ $current_municipality }}"
                                {{ $isEditingAddress ? '' : 'disabled' }}
                                {{ empty($current_barangays) ? 'disabled' : '' }}
                                class="w-full outline-none text-heading-dark font-medium">
                                <option value="">-- Select Barangay --</option>
                                @foreach ($current_barangays as $barangay)
                                    <option value="{{ $barangay }}">{{ ucwords($barangay) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full bg-card p-4 rounded-[12px] flex flex-col gap-4">
            <div class="flex w-full items-start justify-between">
                <div class="flex items-center gap-2">
                    <img src="{{ asset('images/account.png') }}" class="h-6" alt="">
                    <h1 class="text-2xl font-semibold">Account Info.</h1>
                </div>
                <div class="flex gap-2 items-center">
                    <button wire:click="toggleEditAccount"
                        class="w-fit flex items-center border-1 border-gray-300 gap-1 px-4 py-2 bg-white rounded-2xl cursor-pointer hover:text-white hover:border-blue-button hover:bg-blue-button">
                        <span class="material-symbols-rounded">
                            {{ $isEditingAccount ? 'cancel' : 'edit' }}
                        </span>
                        <p>{{ $isEditingAccount ? 'Cancel' : 'Edit' }}</p>
                    </button>

                    @if ($isEditingAccount)
                        <button wire:click="saveAccount"
                            class="w-fit flex items-center border-1 border-gray-300 gap-1 px-4 py-2 bg-white rounded-2xl cursor-pointer hover:text-white hover:border-blue-button hover:bg-blue-button">
                            <span class="material-symbols-rounded">save</span>
                            <p>Save</p>
                        </button>
                    @endif
                </div>
            </div>
            <!-- Account Inputs when in default-->
            @if (!$isEditingAccount)
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col gap-1">
                        <label class="text-paragraph">Username</label>
                        <input type="text" value="{{ $username }}" disabled
                            class="placeholder:text-heading-dark placeholder:font-medium bg-white px-3 py-1.5 rounded-xl outline-none border-1 border-white focus:border-blue-button hover:border-blue-button" />
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-paragraph">Password</label>
                        @if ($isDefaultAccount)
                            <input type="text" value="{{ $default_password }}" disabled
                                class="placeholder:text-heading-dark placeholder:font-medium bg-white px-3 py-1.5 rounded-xl outline-none border-1 border-white focus:border-blue-button hover:border-blue-button" />
                        @else
                            <input type="password" value="********" disabled
                                class="placeholder:text-heading-dark placeholder:font-medium bg-white px-3 py-1.5 rounded-xl outline-none border-1 border-white focus:border-blue-button hover:border-blue-button" />
                        @endif
                    </div>
                </div>
            @else
                <div class="grid grid-cols-4 gap-4">
                    <div class="flex flex-col gap-1">
                        <label class="text-paragraph">Enter new Username</label>
                        <input wire:model="username" type="text" placeholder="Username"
                            class="placeholder:text-heading-dark placeholder:font-medium bg-white px-3 py-1.5 rounded-xl outline-none border-1 border-white focus:border-blue-button hover:border-blue-button" />
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-paragraph">Enter old password</label>
                        <input wire:model="old_password" type="password" placeholder="Old Password"
                            class="placeholder:text-heading-dark placeholder:font-medium bg-white px-3 py-1.5 rounded-xl outline-none border-1 border-white focus:border-blue-button hover:border-blue-button" />
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-paragraph">Enter new password</label>
                        <input wire:model="password" type="password" placeholder="New Password"
                            class="placeholder:text-heading-dark placeholder:font-medium bg-white px-3 py-1.5 rounded-xl outline-none border-1 border-white focus:border-blue-button hover:border-blue-button" />
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-paragraph">Confirm Password</label>
                        <input wire:model="password_confirmation" type="password" placeholder="Confirm Password"
                            class="placeholder:text-heading-dark placeholder:font-medium bg-white px-3 py-1.5 rounded-xl outline-none border-1 border-white focus:border-blue-button hover:border-blue-button" />
                    </div>
                </div>
            @endif
        </div>
    </div>
</main>
