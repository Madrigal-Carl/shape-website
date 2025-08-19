<main class="col-span-5 px-8 py-4 flex flex-col h-dvh gap-16 overflow-y-none">
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

    <!-- curriculumn Table -->
    <div class="flex flex-col gap-4 min-h-[20%]">
        <div class="side flex items-center justify-between gap-2">
            <h1 class="text-4xl font-medium">Rewards Inventory</h1>
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

        <div class="flex flex-col min-h-[20%] p-6 bg-white rounded-3xl">
            <div class="flex flex-col overflow-y-scroll">
                <div class="flex flex-col bg-whitel rounded-3xl bg-white">
                    <table class="table-auto border-separate relative">
                        <thead class="sticky top-0 left-0 z-40 bg-white">
                            <tr>
                                <th class="px-4 pb-3 text-center font-semibold">ID</th>
                                <th class="px-4 pb-3 text-center font-semibold">
                                    Reward Name
                                </th>
                                <th class="px-4 pb-3 text-center font-semibold">
                                    Student Claimes
                                </th>
                                <th class="px-4 pb-3 text-center font-semibold">
                                    Quantity
                                </th>
                                <th class="px-4 pb-3 text-center font-semibold">Status</th>
                                <th class="px-4 pb-3 text-center font-semibold">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td class="px-4 py-3 text-center">01</td>
                                <td class="px-4 py-3 text-center">Ice-cream</td>
                                <td class="px-4 py-3 text-center">45</td>
                                <td class="px-4 py-3 text-center">100</td>

                                <td class="px-4 py-3 text-center">
                                    <div class="flex justify-center items-center">
                                        <div class="gap-2 bg-[#D2FBD0] px-2 py-1 rounded-full flex items-center w-fit">
                                            <small class="text-[#0D5F07]">Active</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <div class="flex justify-center items-center gap-1 text-white">
                                        <button class="bg-danger px-2 py-1 flex gap-2 items-center rounded-lg">
                                            <small>Edit</small>
                                        </button>
                                        <button class="bg-blue-button px-2 py-1 flex gap-2 items-center rounded-lg">
                                            <small>View</small>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="px-4 py-3 text-center">02</td>
                                <td class="px-4 py-3 text-center">Cupcake</td>
                                <td class="px-4 py-3 text-center">45</td>
                                <td class="px-4 py-3 text-center">100</td>

                                <td class="px-4 py-3 text-center">
                                    <div class="flex justify-center items-center">
                                        <div class="gap-2 bg-[#D2FBD0] px-2 py-1 rounded-full flex items-center w-fit">
                                            <small class="text-[#0D5F07]">Active</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <div class="flex justify-center items-center gap-1 text-white">
                                        <button
                                            class="bg-danger px-2 py-1 flex gap-2 items-center rounded-lg cursor-pointer hover:scale-110">
                                            <small>Edit</small>
                                        </button>
                                        <button
                                            class="bg-blue-button px-2 py-1 flex gap-2 items-center rounded-lg cursor-pointer hover:scale-110">
                                            <small>View</small>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="px-4 py-3 text-center">03</td>
                                <td class="px-4 py-3 text-center">Chocolate</td>
                                <td class="px-4 py-3 text-center">45</td>
                                <td class="px-4 py-3 text-center">100</td>

                                <td class="px-4 py-3 text-center">
                                    <div class="flex justify-center items-center">
                                        <div class="gap-2 bg-[#D2FBD0] px-2 py-1 rounded-full flex items-center w-fit">
                                            <small class="text-[#0D5F07]">Active</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <div class="flex justify-center items-center gap-1 text-white">
                                        <button
                                            class="bg-danger px-2 py-1 flex gap-2 items-center rounded-lg cursor-pointer hover:scale-110">
                                            <small>Edit</small>
                                        </button>
                                        <button
                                            class="bg-blue-button px-2 py-1 flex gap-2 items-center rounded-lg cursor-pointer hover:scale-110">
                                            <small>View</small>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="px-4 py-3 text-center">04</td>
                                <td class="px-4 py-3 text-center">Cookie</td>
                                <td class="px-4 py-3 text-center">45</td>
                                <td class="px-4 py-3 text-center">100</td>
                                <td class="px-4 py-3 text-center">
                                    <div class="flex justify-center items-center">
                                        <div class="gap-2 bg-[#D2FBD0] px-2 py-1 rounded-full flex items-center w-fit">
                                            <small class="text-[#0D5F07]">Active</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <div class="flex justify-center items-center gap-1 text-white">
                                        <button
                                            class="bg-danger px-2 py-1 flex gap-2 items-center rounded-lg cursor-pointer hover:scale-110">
                                            <small>Edit</small>
                                        </button>
                                        <button
                                            class="bg-blue-button px-2 py-1 flex gap-2 items-center rounded-lg cursor-pointer hover:scale-110">
                                            <small>View</small>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="px-4 py-3 text-center">05</td>
                                <td class="px-4 py-3 text-center">Candy</td>
                                <td class="px-4 py-3 text-center">45</td>
                                <td class="px-4 py-3 text-center">100</td>
                                <td class="px-4 py-3 text-center">
                                    <div class="flex justify-center items-center">
                                        <div class="gap-2 bg-[#D2FBD0] px-2 py-1 rounded-full flex items-center w-fit">
                                            <small class="text-[#0D5F07]">Active</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <div class="flex justify-center items-center gap-1 text-white">
                                        <button
                                            class="bg-danger px-2 py-1 flex gap-2 items-center rounded-lg cursor-pointer hover:scale-110">
                                            <small>Edit</small>
                                        </button>
                                        <button
                                            class="bg-blue-button px-2 py-1 flex gap-2 items-center rounded-lg cursor-pointer hover:scale-110">
                                            <small>View</small>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 text-center">06</td>
                                <td class="px-4 py-3 text-center">Lollipop</td>
                                <td class="px-4 py-3 text-center">45</td>
                                <td class="px-4 py-3 text-center">100</td>
                                <td class="px-4 py-3 text-center">
                                    <div class="flex justify-center items-center">
                                        <div class="gap-2 bg-[#D2FBD0] px-2 py-1 rounded-full flex items-center w-fit">
                                            <small class="text-[#0D5F07]">Active</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <div class="flex justify-center items-center gap-1 text-white">
                                        <button
                                            class="bg-danger px-2 py-1 flex gap-2 items-center rounded-lg cursor-pointer hover:scale-110">
                                            <small>Edit</small>
                                        </button>
                                        <button
                                            class="bg-blue-button px-2 py-1 flex gap-2 items-center rounded-lg cursor-pointer hover:scale-110">
                                            <small>View</small>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Aside -->
<aside class="col-span-2 grid grid-cols-1 grid-rows-2 pr-4 py-4 gap-4 h-dvh">
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
