<main class="col-span-5 pl-8 pr-4 py-4 flex flex-col h-dvh gap-16 overflow-y-auto">
    <!-- Greetings -->
    @php
        $user = App\Models\Account::with('accountable')->find(auth()->id());
    @endphp
    <div class="flex gap-2 w-auto justify-between">
        <div class="flex gap-4">
            <span class="w-1 h-full bg-blue-button rounded-full"></span>
            <div>
                <h1 class="text-2xl font-medium">
                    Welcome back,
                    <span class="font-bold text-blue-button">{{ $user->accountable->first_name }}</span>
                </h1>
                <p class="text-sm text-paragraph">Here is your summary today</p>
            </div>
        </div>

        <!-- Buttons -->
        <button
            class="flex items-center bg-white py-2 px-5 rounded-full gap-2 shadow-2xl text-paragraph cursor-pointer hover:text-white hover:bg-blue-button hover:shadow-xl/35 hover:shadow-blue-button hover:scale-105">
            <span class="material-symbols-rounded">calendar_month</span>
            <p class="text-sm">Select Date</p>
        </button>
    </div>

    <!-- Award inventory -->
    <div class="flex flex-col gap-4">
        <div class="side flex items-center justify-between gap-2">
            <h1 class="text-4xl font-medium">Awards Inventory</h1>
            <div
                class="flex items-center bg-white py-3 px-5 rounded-full shadow-2xl text-paragraph cursor-pointer hover:text-white hover:bg-blue-button">
                <select name="" id="" class="w-25 outline-none">
                    <option value="pending" class="text-sm text-heading-dark" selected disabled>
                        Filter by
                    </option>
                    <option value="pending" class="text-sm text-heading-dark">
                        All
                    </option>
                    <option value="pending" class="text-sm text-lime">Active</option>
                    <option value="pending" class="text-sm text-paragraph">
                        Inactive
                    </option>
                </select>
                <!-- <span class="material-symbols-rounded">more_horiz</span>
                    <span class="material-symbols-rounded">search</span> -->
            </div>
        </div>


        <!-- Award Grid -->
        <div class="w-full  grid grid-cols-4 gap-4">
            <!-- Award card -->
            <div
                class="max-w-100 flex flex-col gap-8 items-center bg-[radial-gradient(circle_at_center,_#93CEF5,_#006FDF)] p-4 rounded-3xl">
                <div class="flex flex-col items-center gap-2 pt-8">
                    <img src="{{ asset('images/Awards_icons/medal.png') }}" alt="" class="h-35 mb-4">
                    <p class="font-medium text-xl text-white w-full">Best in Kagaguhan</p>
                    <div class="flex items-center w-full justify-center gap-4 text-white">
                        <p class="text-sm">Awardees:</p>
                        <p class="text-sm">24</p>
                    </div>
                </div>



                <div class="flex items-center gap-2 w-full">
                    <button type="button"
                        class="w-full flex items-center justify-center gap-1 px-3 py-2 bg-white rounded-xl text-paragraph">
                        <span class="material-symbols-rounded award-icon">print</span>
                        <p class="text-sm">Print</p>
                    </button>
                    <button wire:click='openViewAwardModal({{ 1 }})'
                        class="w-full flex items-center justify-center gap-1 px-3 py-2 bg-yellowOrange rounded-xl text-white relative">

                        <span class="material-symbols-rounded award-icon transition-opacity duration-150"
                            wire:loading.class="opacity-0" wire:target='openViewAwardModal({{ 1 }})'>
                            visibility
                        </span>
                        <p class="text-sm transition-opacity duration-150" wire:loading.class="opacity-0"
                            wire:target='openViewAwardModal({{ 1 }})'>
                            View
                        </p>

                        <svg wire:loading wire:target='openViewAwardModal({{ 1 }})'
                            class="w-4 h-4 text-white animate-spin absolute" viewBox="0 0 100 101" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                fill="currentColor" />
                            <path
                                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                fill="currentFill" />
                        </svg>
                    </button>

                </div>
            </div><!--End of Award card -->
        </div>
    </div>
    <livewire:award-view-modal />
</main>
