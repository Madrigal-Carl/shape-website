<main class="col-span-5 pl-8 pr-4 py-4 flex flex-col h-dvh gap-16 overflow-y-auto">
    <!-- Greetings -->
    <div class="flex gap-2 w-auto justify-between">
        <div class="flex gap-4">
            <span class="w-1 h-full bg-blue-button rounded-full"></span>
            <div>
                <h1 class="text-2xl font-medium">
                    Welcome back, Sir
                    <span class="font-bold text-blue-button">Dave</span>
                </h1>
                <p class="text-sm text-paragraph">Here is your summary today</p>
            </div>
        </div>

        <!-- Buttons -->
        <button
            class="flex items-center bg-white py-2 px-5 rounded-full gap-2 shadow-2xl text-paragraph cursor-pointer hover:text-white hover:bg-blue-button hover:shadow-xl/35 hover:shadow-blue-button hover:scale-105">
            <span class="material-symbols-rounded">add</span>
            <p class="text-sm">Add New Rewards</p>
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
            <div class="max-w-100 flex flex-col gap-8 items-center bg-[radial-gradient(circle_at_center,_#93CEF5,_#006FDF)] p-4 rounded-3xl">
                <div class="flex flex-col items-center gap-2 pt-8">
                    <img src="{{ asset('images/Awards_icons/medal.png') }}" alt="" class="h-35 mb-4">
                    <p class="font-medium text-xl text-white w-full">Best in Kagaguhan</p>
                    <div class="flex items-center w-full justify-center gap-4 text-white">
                        <p class="text-sm">Awardees:</p>
                        <p class="text-sm">24</p>
                    </div>
                </div>



                <div class="flex items-center gap-2 w-full">
                    <button class="w-full flex items-center justify-center gap-1 px-3 py-2 bg-white rounded-xl text-paragraph">
                        <span class="material-symbols-rounded award-icon">print</span>
                        <p class="text-sm">Print</p>
                    </button>
                    <button class="w-full flex items-center justify-center gap-1 px-3 py-2 bg-yellowOrange rounded-xl text-white">
                        <span class="material-symbols-rounded award-icon">visibility</span>
                        <p class="text-sm">View</p>
                    </button>
                </div>
            </div><!--End of Award card -->


        </div>
    </div>
</main>

<!-- Aside -->
<aside class="col-span-2 grid grid-cols-1 grid-rows-2 pr-4 pl-4 py-4 gap-4 h-dvh">
    <!-- Student Feed -->
    <div
        class="bg-gradient-to-tr from-blue-button to-[#2BB4EE] w-full h-full rounded-3xl px-3 pt-3 pb-6 flex flex-col gap-3">
        <div class="flex gap-2 items-center p-3">
            <span class="material-symbols-rounded text-white">award_star</span>
            <h1 class="text-xl font-semibold text-white">
                Students Rewards Summary
            </h1>
        </div>

        <!-- Student Notifications -->
        <div class="flex flex-col gap-2 px-3 overflow-y-auto reward-sum">
            <div class="flex gap-2 w-full bg-white/15 p-3 rounded-full">
                <img src="{{ asset('images/profile.jpg') }}" class="rounded-full w-10" alt="" />
                <!-- notification Details -->
                <div class="w-full flex items-center justify-between pr-4 pl-2">
                    <h2 class="leading-tight font-semibold text-md text-white">
                        Juan Dela Cruz
                    </h2>
                    <p class="text-xs leading-tight text-white">15 Rewards</p>
                </div>
            </div>

            <div class="flex gap-2 w-full bg-white/15 p-3 rounded-full">
                <img src="{{ asset('images/profile.jpg') }}" class="rounded-full w-10" alt="" />
                <!-- notification Details -->
                <div class="w-full flex items-center justify-between pr-4 pl-2">
                    <h2 class="leading-tight font-semibold text-md text-white">
                        Juan Dela Cruz
                    </h2>
                    <p class="text-xs leading-tight text-white">15 Rewards</p>
                </div>
            </div>

            <div class="flex gap-2 w-full bg-white/15 p-3 rounded-full">
                <img src="{{ asset('images/profile.jpg') }}" class="rounded-full w-10" alt="" />
                <!-- notification Details -->
                <div class="w-full flex items-center justify-between pr-4 pl-2">
                    <h2 class="leading-tight font-semibold text-md text-white">
                        Juan Dela Cruz
                    </h2>
                    <p class="text-xs leading-tight text-white">15 Rewards</p>
                </div>
            </div>

            <div class="flex gap-2 w-full bg-white/15 p-3 rounded-full">
                <img src="{{ asset('images/profile.jpg') }}" class="rounded-full w-10" alt="" />
                <!-- notification Details -->
                <div class="w-full flex items-center justify-between pr-4 pl-2">
                    <h2 class="leading-tight font-semibold text-md text-white">
                        Juan Dela Cruz
                    </h2>
                    <p class="text-xs leading-tight text-white">15 Rewards</p>
                </div>
            </div>

            <div class="flex gap-2 w-full bg-white/15 p-3 rounded-full">
                <img src="{{ asset('images/profile.jpg') }}" class="rounded-full w-10" alt="" />
                <!-- notification Details -->
                <div class="w-full flex items-center justify-between pr-4 pl-2">
                    <h2 class="leading-tight font-semibold text-md text-white">
                        Juan Dela Cruz
                    </h2>
                    <p class="text-xs leading-tight text-white">15 Rewards</p>
                </div>
            </div>

            <div class="flex gap-2 w-full bg-white/15 p-3 rounded-full">
                <img src="{{ asset('images/profile.jpg') }}" class="rounded-full w-10" alt="" />
                <!-- notification Details -->
                <div class="w-full flex items-center justify-between pr-4 pl-2">
                    <h2 class="leading-tight font-semibold text-md text-white">
                        Juan Dela Cruz
                    </h2>
                    <p class="text-xs leading-tight text-white">15 Rewards</p>
                </div>
            </div>

            <div class="flex gap-2 w-full bg-white/15 p-3 rounded-full">
                <img src="{{ asset('images/profile.jpg') }}" class="rounded-full w-10" alt="" />
                <!-- notification Details -->
                <div class="w-full flex items-center justify-between pr-4 pl-2">
                    <h2 class="leading-tight font-semibold text-md text-white">
                        Juan Dela Cruz
                    </h2>
                    <p class="text-xs leading-tight text-white">15 Rewards</p>
                </div>
            </div>

            <div class="flex gap-2 w-full bg-white/15 p-3 rounded-full">
                <img src="{{ asset('images/profile.jpg') }}" class="rounded-full w-10" alt="" />
                <!-- notification Details -->
                <div class="w-full flex items-center justify-between pr-4 pl-2">
                    <h2 class="leading-tight font-semibold text-md text-white">
                        Juan Dela Cruz
                    </h2>
                    <p class="text-xs leading-tight text-white">15 Rewards</p>
                </div>
            </div>
        </div>
    </div>

    <!-- System Feed -->
    <div class="bg-white w-full h-full rounded-3xl px-3 pt-3 pb-6 flex flex-col gap-3">
        <div class="flex gap-2 items-center p-3">
            <span class="material-symbols-rounded text-danger">settings_alert</span>
            <h1 class="text-xl font-semibold">Reward Logs</h1>
        </div>

        <!-- System Notifications -->
        <div class="flex flex-col gap-2 px-3 overflow-y-auto">
            <div class="flex gap-2 w-full bg-card p-3 rounded-full">
                <img src="{{ asset('images/profile.jpg') }}" class="rounded-full w-10" alt="" />
                <!-- notification Details -->
                <div>
                    <h2 class="leading-tight font-semibold text-md">
                        Juan Dela Cruz
                    </h2>
                    <p class="text-xs leading-tight text-paragraph">
                        exchange 3 cookies for 1 chocolate
                    </p>
                </div>
            </div>

            <div class="flex gap-2 w-full bg-card p-3 rounded-full">
                <img src="{{ asset('images/profile.jpg') }}" class="rounded-full w-10" alt="" />
                <!-- notification Details -->
                <div>
                    <h2 class="leading-tight font-semibold text-md">
                        Juan Dela Cruz
                    </h2>
                    <p class="text-xs leading-tight text-paragraph">
                        exchange 3 cookies for 1 chocolate
                    </p>
                </div>
            </div>

            <div class="flex gap-2 w-full bg-card p-3 rounded-full">
                <img src="{{ asset('images/profile.jpg') }}" class="rounded-full w-10" alt="" />
                <!-- notification Details -->
                <div>
                    <h2 class="leading-tight font-semibold text-md">
                        Juan Dela Cruz
                    </h2>
                    <p class="text-xs leading-tight text-paragraph">
                        exchange 3 cookies for 1 chocolate
                    </p>
                </div>
            </div>

            <div class="flex gap-2 w-full bg-card p-3 rounded-full">
                <img src="{{ asset('images/profile.jpg') }}" class="rounded-full w-10" alt="" />
                <!-- notification Details -->
                <div>
                    <h2 class="leading-tight font-semibold text-md">
                        Juan Dela Cruz
                    </h2>
                    <p class="text-xs leading-tight text-paragraph">
                        exchange 3 cookies for 1 chocolate
                    </p>
                </div>
            </div>

            <div class="flex gap-2 w-full bg-card p-3 rounded-full">
                <img src="{{ asset('images/profile.jpg') }}" class="rounded-full w-10" alt="" />
                <!-- notification Details -->
                <div>
                    <h2 class="leading-tight font-semibold text-md">
                        Juan Dela Cruz
                    </h2>
                    <p class="text-xs leading-tight text-paragraph">
                        exchange 3 cookies for 1 chocolate
                    </p>
                </div>
            </div>

            <div class="flex gap-2 w-full bg-card p-3 rounded-full">
                <img src="{{ asset('images/profile.jpg') }}" class="rounded-full w-10" alt="" />
                <!-- notification Details -->
                <div>
                    <h2 class="leading-tight font-semibold text-md">
                        Juan Dela Cruz
                    </h2>
                    <p class="text-xs leading-tight text-paragraph">
                        exchange 3 cookies for 1 chocolate
                    </p>
                </div>
            </div>

            <div class="flex gap-2 w-full bg-card p-3 rounded-full">
                <img src="{{ asset('images/profile.jpg') }}" class="rounded-full w-10" alt="" />
                <!-- notification Details -->
                <div>
                    <h2 class="leading-tight font-semibold text-md">
                        Juan Dela Cruz
                    </h2>
                    <p class="text-xs leading-tight text-paragraph">
                        exchange 3 cookies for 1 chocolate
                    </p>
                </div>
            </div>

            <div class="flex gap-2 w-full bg-card p-3 rounded-full">
                <img src="{{ asset('images/profile.jpg') }}" class="rounded-full w-10" alt="" />
                <!-- notification Details -->
                <div>
                    <h2 class="leading-tight font-semibold text-md">
                        Juan Dela Cruz
                    </h2>
                    <p class="text-xs leading-tight text-paragraph">
                        exchange 3 cookies for 1 chocolate
                    </p>
                </div>
            </div>
        </div>
    </div>
</aside>

<!-- Awards View -->
<section class="bg-black/30 absolute w-dvw h-dvh p-10 top-0 left-0 z-50 backdrop-blur-xs hidden justify-center gap-6">
    <!-- Awards View Info-->
    <div class="w-150 max-h-full Addlesson bg-white py-8 rounded-4xl relative flex">
        <div class="Addlesson w-full h-full flex flex-col px-8 pb-18 gap-8 self-center-safe overflow-y-auto">

            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('images/award-icon.png') }}" alt="" class="h-10">
                    <h1 class=" text-2xl font-semibold text-heading-dark">Awards View</h1>
                </div>
                <!-- Buttons -->
                <div class="flex gap-4">
                    <button class="flex items-center bg-white py-2 px-5 rounded-full gap-2 shadow-2xl text-paragraph cursor-pointer hover:text-white hover:bg-blue-button hover:shadow-xl/35 hover:shadow-blue-button hover:scale-105">
                        <span class="material-symbols-rounded">calendar_month</span>
                        <p class="text-sm">Select Date</p>
                    </button>
                </div>
            </div>


            <div class="w-full flex flex-col gap-4 items-center justify-center">
                <img src="{{ asset('images/Awards_icons/medal.png') }}" alt="" class="h-50">
                <h1 class="text-5xl font-semibold text-center w-80%">Best in Math</h1>
            </div>

            <div class="w-full flex items-center gap-4 justify-center text-xl text-paragraph">
                <p class="font-semibold">Total Awardees:</p>
                <p>24</p>
            </div>

            <!-- student list of awardees -->
            <div class="w-full grid grid-cols-2 gap-2">
                <!-- Student name tag -->
                <div class="w-full bg-card p-2 text-center rounded-2xl">
                    <p class="font-semibold text-lg">Carl S. Madrigal</p>
                </div>

                <!-- Student name tag -->
                <div class="w-full bg-card p-2 text-center rounded-2xl">
                    <p class="font-semibold text-lg">Carl S. Madrigal</p>
                </div>

                <!-- Student name tag -->
                <div class="w-full bg-card p-2 text-center rounded-2xl">
                    <p class="font-semibold text-lg">Carl S. Madrigal</p>
                </div>

                <!-- Student name tag -->
                <div class="w-full bg-card p-2 text-center rounded-2xl">
                    <p class="font-semibold text-lg">Carl S. Madrigal</p>
                </div>

                <!-- Student name tag -->
                <div class="w-full bg-card p-2 text-center rounded-2xl">
                    <p class="font-semibold text-lg">Carl S. Madrigal</p>
                </div>

                <!-- Student name tag -->
                <div class="w-full bg-card p-2 text-center rounded-2xl">
                    <p class="font-semibold text-lg">Carl S. Madrigal</p>
                </div>

                <!-- Student name tag -->
                <div class="w-full bg-card p-2 text-center rounded-2xl">
                    <p class="font-semibold text-lg">Carl S. Madrigal</p>
                </div>

                <!-- Student name tag -->
                <div class="w-full bg-card p-2 text-center rounded-2xl">
                    <p class="font-semibold text-lg">Carl S. Madrigal</p>
                </div>

                <!-- Student name tag -->
                <div class="w-full bg-card p-2 text-center rounded-2xl">
                    <p class="font-semibold text-lg">Carl S. Madrigal</p>
                </div>

                <!-- Student name tag -->
                <div class="w-full bg-card p-2 text-center rounded-2xl">
                    <p class="font-semibold text-lg">Carl S. Madrigal</p>
                </div>

                <!-- Student name tag -->
                <div class="w-full bg-card p-2 text-center rounded-2xl">
                    <p class="font-semibold text-lg">Carl S. Madrigal</p>
                </div>

                <!-- Student name tag -->
                <div class="w-full bg-card p-2 text-center rounded-2xl">
                    <p class="font-semibold text-lg">Carl S. Madrigal</p>
                </div>

                <!-- Student name tag -->
                <div class="w-full bg-card p-2 text-center rounded-2xl">
                    <p class="font-semibold text-lg">Carl S. Madrigal</p>
                </div>

                <!-- Student name tag -->
                <div class="w-full bg-card p-2 text-center rounded-2xl">
                    <p class="font-semibold text-lg">Carl S. Madrigal</p>
                </div>
            </div>

            <div class="flex items-center gap-2 absolute w-full left-0 bottom-0 px-5 pb-5 pt-10  rounded-b-4xl bg-gradient-to-t from-white via-white to-white/50">
                <button class=" bg-gray-100 py-1.5 px-3 w-full rounded-xl text-heading-dark font-medium">Cancel</button>
                <button type="submit" class="bg-blue-button py-1.5 px-3 w-full rounded-xl text-white font-medium">Print</button>
            </div>
        </div>
    </div><!--End of Awards View Info-->


</section><!-- Awards View -->
