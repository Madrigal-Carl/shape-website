<main class="col-span-5 pl-8 pr-4 py-4 flex flex-col h-dvh gap-16 overflow-y-auto">
    <!-- Greetings -->
    <div class="flex gap-2 w-auto justify-between">
        <div class="flex gap-4">
            <span class="w-1 h-full bg-blue-button rounded-full"></span>
            <div>
                <h1 class="text-2xl font-medium">
                    Welcome back,
                    <span class="font-bold text-blue-button">Dave</span>
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
                    <button type="button" wire:click='openViewAwardModal({{ 1 }})'
                        class="w-full flex items-center justify-center gap-1 px-3 py-2 bg-yellowOrange rounded-xl text-white">
                        <span class="material-symbols-rounded award-icon">visibility</span>
                        <p class="text-sm">View</p>
                    </button>
                </div>
            </div><!--End of Award card -->
        </div>
    </div>
    <livewire:award-view-modal />
</main>
