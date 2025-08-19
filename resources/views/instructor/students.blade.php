<main class="col-span-5 px-8 py-4 flex flex-col h-dvh gap-16 overflow-y-auto">
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
        <div class="flex gap-4">
            <button
                class="flex items-center bg-white py-2 px-5 rounded-full gap-2 shadow-2xl text-paragraph cursor-pointer hover:text-white hover:bg-blue-button hover:shadow-xl/35 hover:shadow-blue-button hover:scale-105">
                <span class="material-symbols-rounded">calendar_month</span>
                <p class="text-sm">Select Date</p>
            </button>
            <button
                class="flex items-center bg-white py-2 px-5 rounded-full gap-2 shadow-2xl text-paragraph cursor-pointer hover:text-white hover:bg-blue-button hover:shadow-xl/35 hover:shadow-blue-button hover:scale-105">
                <span class="material-symbols-rounded">save</span>
                <p class="text-sm">Export</p>
            </button>
        </div>
    </div>

    <!-- Student Table -->
    <div class="flex flex-col gap-4 min-h-[20%]">
        <div class="side flex items-center justify-between gap-2">
            <h1 class="text-4xl font-medium">Student List</h1>
            <div class="flex items-center gap-4">
                <div
                    class="flex items-center bg-white py-3 px-5 rounded-full shadow-2xl text-paragraph hover:bg-blue-button hover:text-white cursor-pointer">
                    <select name="" id="" class="w-30 outline-none">
                        <option value="pending" class="text-sm text-heading-dark" selected disabled>
                            Disability
                        </option>
                        <option value="pending" class="text-sm text-heading-dark">
                            All
                        </option>
                        <option value="pending" class="text-sm text-lime">
                            Autism
                        </option>
                        <option value="pending" class="text-sm text-yellowOrange">
                            Hearing
                        </option>
                        <option value="pending" class="text-sm text-danger">
                            Speech
                        </option>
                    </select>
                </div>

                <div
                    class="flex items-center bg-white py-3 px-5 rounded-full shadow-2xl text-paragraph hover:bg-blue-button hover:text-white cursor-pointer">
                    <select name="" id="" class="w-30 outline-none">
                        <option value="pending" class="text-sm text-heading-dark" selected disabled>
                            Status
                        </option>
                        <option value="pending" class="text-sm text-heading-dark">
                            All
                        </option>
                        <option value="pending" class="text-sm text-lime">
                            Active
                        </option>
                        <option value="pending" class="text-sm text-paragraph">
                            Inactive
                        </option>
                        <option value="pending" class="text-sm text-blue-button">
                            Graduated
                        </option>
                        <option value="pending" class="text-sm text-yellowOrange">
                            Transferred
                        </option>
                        <option value="pending" class="text-sm text-danger">
                            Dropped
                        </option>
                    </select>
                </div>
            </div>
        </div>

        <div class="flex flex-col min-h-[20%] p-6 bg-white rounded-3xl">
            <div class="flex flex-col overflow-y-scroll min-h-[20%]">
                <div class="flex flex-col bg-whitel rounded-3xl bg-white">
                    <table class="table-auto border-separate relative">
                        <thead class="sticky top-0 left-0 z-40 bg-white">
                            <tr>
                                <th class="px-4 pb-3 text-center font-semibold">ID</th>
                                <th class="px-4 pb-3 text-center font-semibold">Name</th>
                                <th class="px-4 pb-3 text-center font-semibold">
                                    Disability
                                </th>
                                <th class="px-4 pb-3 text-center font-semibold w-20">
                                    Completed Lessons
                                </th>
                                <th class="px-4 pb-3 text-center font-semibold w-20">
                                    Completed Activitis
                                </th>
                                <th class="px-4 pb-3 text-center font-semibold w-20">
                                    Completed Quizzes
                                </th>
                                <th class="px-4 pb-3 text-center font-semibold">Status</th>
                                <th class="px-4 pb-3 text-center font-semibold">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td class="px-4 py-3 text-center">01</td>
                                <td class="px-4 py-3 text-center">Carl S. Madrigal</td>
                                <td class="px-4 py-3 text-center">Hearing Impairement</td>
                                <td class="px-4 py-3 text-center">4/10</td>
                                <td class="px-4 py-3 text-center">14/20</td>
                                <td class="px-4 py-3 text-center">4/10</td>
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
                                <td class="px-4 py-3 text-center">01</td>
                                <td class="px-4 py-3 text-center">Carl S. Madrigal</td>
                                <td class="px-4 py-3 text-center">Hearing Impairement</td>
                                <td class="px-4 py-3 text-center">4/10</td>
                                <td class="px-4 py-3 text-center">14/20</td>
                                <td class="px-4 py-3 text-center">4/10</td>
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
    <div class="bg-white w-full h-full rounded-3xl px-3 pt-3 pb-6 flex flex-col gap-3">
        <div class="flex gap-2 items-center p-3">
            <span class="material-symbols-rounded text-yellowOrange">local_library</span>
            <h1 class="text-xl font-semibold">Student Feed</h1>
        </div>

        <!-- Student Notifications -->
        <div class="flex flex-col gap-2 px-3 overflow-y-auto">
            <div class="flex gap-2 w-full bg-card p-3 rounded-full">
                <img src="{{ asset('images/profile.jpg') }}" class="rounded-full w-10" alt="" />
                <!-- notification Details -->
                <div>
                    <h2 class="leading-tight font-semibold text-md">
                        Juan Dela Cruz
                    </h2>
                    <p class="text-xs leading-tight text-paragraph">
                        Completed Lesson 1
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
                        Completed Lesson 1
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
                        Completed Lesson 1
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
                        Completed Lesson 1
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
                        Completed Lesson 1
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
                        Completed Lesson 1
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- System Feed -->
    <div class="bg-white w-full h-full rounded-3xl px-3 pt-3 pb-6 flex flex-col gap-3">
        <div class="flex gap-2 items-center p-3">
            <span class="material-symbols-rounded text-danger">settings_alert</span>
            <h1 class="text-xl font-semibold">System Feed</h1>
        </div>

        <!-- System Notifications -->
        <div class="flex flex-col gap-2 px-3 overflow-y-auto">
            <div class="gap-2 w-full bg-card p-3 rounded-lg">
                <!-- System Details -->
                <h2 class="leading-tight font-semibold text-md">
                    Lesson Created Successfully!
                </h2>
                <p class="text-xs leading-tight text-paragraph">just now</p>
            </div>

            <div class="gap-2 w-full bg-card p-3 rounded-lg">
                <!-- System Details -->
                <h2 class="leading-tight font-semibold text-md">
                    Lesson Created Successfully!
                </h2>
                <p class="text-xs leading-tight text-paragraph">just now</p>
            </div>

            <div class="gap-2 w-full bg-card p-3 rounded-lg">
                <!-- System Details -->
                <h2 class="leading-tight font-semibold text-md">
                    Lesson Created Successfully!
                </h2>
                <p class="text-xs leading-tight text-paragraph">just now</p>
            </div>

            <div class="gap-2 w-full bg-card p-3 rounded-lg">
                <!-- System Details -->
                <h2 class="leading-tight font-semibold text-md">
                    Lesson Created Successfully!
                </h2>
                <p class="text-xs leading-tight text-paragraph">just now</p>
            </div>

            <div class="gap-2 w-full bg-card p-3 rounded-lg">
                <!-- System Details -->
                <h2 class="leading-tight font-semibold text-md">
                    Lesson Created Successfully!
                </h2>
                <p class="text-xs leading-tight text-paragraph">just now</p>
            </div>

            <div class="gap-2 w-full bg-card p-3 rounded-lg">
                <!-- System Details -->
                <h2 class="leading-tight font-semibold text-md">
                    Lesson Created Successfully!
                </h2>
                <p class="text-xs leading-tight text-paragraph">just now</p>
            </div>
        </div>
    </div>
</aside>

<!-- Enrollment Form pup Ups -->
<section
    class="bg-black/30 absolute w-dvw h-dvh top-0 left-0 z-50 backdrop-blur-xs hidden justify-center items-center overflow-y-auto p-10">
    <!-- first form -->
    <div id="firstForm" class="bg-white p-8 rounded-4xl w-150 flex flex-col gap-8">
        <div class="flex items-center gap-2">
            <img src="{{ asset('images/form.png') }}" alt="" />
            <h1 class="text-2xl font-semibold text-heading-dark">
                Education Enrollment Form
            </h1>
        </div>

        <div class="flex items-center gap-4">
            <input type="image" src="https://placehold.co/100x100" alt="" class="w-15 rounded-full" />
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
                    <input type="text" placeholder="Middlen me"
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
            <button class="bg-gray-100 py-1.5 px-3 w-full rounded-xl text-heading-dark font-medium">
                Cancel
            </button>
            <button type="submit" id="nextBtn"
                class="bg-blue-button py-1.5 px-3 w-full rounded-xl text-white font-medium">
                Next
            </button>
        </div>
    </div>
    <!-- End of first form -->

    <!-- Second form -->
    <div id="secondForm" class="bg-white p-8 rounded-4xl w-150 hidden flex-col gap-8">
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
            <button class="bg-gray-100 py-1.5 px-3 w-full rounded-xl text-heading-dark font-medium">
                Cancel
            </button>
            <button type="submit" class="bg-yellowOrange py-1.5 px-3 w-full rounded-xl text-white font-medium">
                Prev
            </button>
            <button type="submit" class="bg-blue-button py-1.5 px-3 w-full rounded-xl text-white font-medium">
                Next
            </button>
        </div>
    </div>
    <!-- End of Second form -->

    <!-- Third form -->
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
            <button class="bg-gray-100 py-1.5 px-3 w-full rounded-xl text-heading-dark font-medium">
                Cancel
            </button>
            <button type="submit" class="bg-yellowOrange py-1.5 px-3 w-full rounded-xl text-white font-medium">
                Prev
            </button>
            <button type="submit" class="bg-blue-button py-1.5 px-3 w-full rounded-xl text-white font-medium">
                Register
            </button>
        </div>
    </div>
    <!-- End of Third form -->
</section>

<!-- Sudent Profile -->
<section
    class="bg-black/30 absolute w-dvw h-dvh top-0 left-0 z-50 backdrop-blur-xs hidden justify-center overflow-y-auto p-10">
    <!-- Third form -->
    <div class="bg-white p-8 rounded-4xl w-250 flex flex-col gap-12 self-center-safe">
        <div class="flex items-center justify-between gap-2">
            <h1 class="text-4xl font-semibold text-heading-dark">
                Student Info.
            </h1>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2">
                <button
                    class="profile-button flex items-center bg-white py-2 px-5 rounded-full gap-2 shadow-2xl text-paragraph cursor-pointer hover:text-white hover:bg-blue-button hover:shadow-xl/35 hover:shadow-blue-button hover:scale-105">
                    <span class="material-symbols-rounded">save</span>
                    <p class="text-sm">Export Form</p>
                </button>

                <button
                    class="profile-button flex items-center bg-white py-2 px-5 rounded-full gap-2 shadow-2xl text-paragraph cursor-pointer hover:text-white hover:bg-blue-button hover:shadow-xl/35 hover:shadow-blue-button hover:scale-105">
                    <span class="material-symbols-rounded">docs</span>
                    <p class="text-sm">Generate Reports</p>
                </button>

                <button
                    class="profile-button flex items-center bg-white py-2 px-5 rounded-full gap-2 shadow-2xl text-paragraph cursor-pointer hover:text-white hover:bg-blue-button hover:shadow-xl/35 hover:shadow-blue-button hover:scale-105">
                    <span class="material-symbols-rounded">calendar_month</span>
                    <p class="text-sm">Select Date</p>
                </button>

                <button
                    class="profile-button flex items-center bg-white p-2 rounded-full gap-2 shadow-2xl text-paragraph cursor-pointer hover:text-white hover:bg-blue-button hover:shadow-xl/35 hover:shadow-blue-button hover:scale-105">
                    <span class="material-symbols-rounded">close</span>
                </button>
            </div>
        </div>

        <!-- Profile pic and info -->
        <div class="flex gap-6">
            <img src="{{ asset('images/profile.jpg') }}" alt="" class="rounded-full w-20" />

            <div class="flex flex-col justify-between">
                <h1 class="font-medium text-xl leading-4">Dave Geroleo</h1>
                <p class="text-sm text-paragraph">ID: <span>123344</span></p>
                <div class="px-2 py-0.5 rounded-lg bg-[#D2FBD0] w-fit">
                    <select name="" id="" class="w-fit outline-none text-[#0D5F07] text-sm">
                        <option value="pending" class="text-sm text-black" selected>
                            Active
                        </option>
                        <option value="pending" class="text-sm text-black">
                            inactive
                        </option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Summary -->
        <div class="flex flex-col gap-4">
            <h1 class="text-2xl font-medium">Summary</h1>
            <div class="grid grid-cols-4 grid-rows-1 gap-4">
                <div
                    class="bg-gradient-to-tr from-blue-button to-[#00EEFF] shadow-blue-button shadow-2xl/45 p-6 text-white rounded-3xl flex flex-col justify-between gap-6">
                    <div class="">
                        <p class="text-sm leading-snug font-normal">Earned</p>
                        <h1 class="text-2xl font-semibold leading-6">REWARDS</h1>
                    </div>
                    <h1 class="text-4xl font-semibold">24</h1>
                </div>

                <div
                    class="bg-gradient-to-tr from-lime to-[#00ff80] shadow-lime shadow-2xl/45 p-6 text-white rounded-3xl flex flex-col justify-between gap-6">
                    <div>
                        <p class="text-sm leading-snug font-normal">Completed</p>
                        <h1 class="text-2xl font-semibold leading-6">LESSONS</h1>
                    </div>
                    <h1 class="text-4xl font-semibold">24</h1>
                </div>

                <div
                    class="bg-gradient-to-tr from-yellowOrange to-[#FFEA00] shadow-yellowOrange shadow-2xl/45 p-6 text-white rounded-3xl flex flex-col justify-between gap-6">
                    <div>
                        <p class="text-sm leading-snug font-normal">Completed</p>
                        <h1 class="text-2xl font-semibold leading-6 max-w-50">
                            ACTIVITIES
                        </h1>
                    </div>
                    <h1 class="text-4xl font-semibold">24</h1>
                </div>

                <div
                    class="bg-gradient-to-tr from-danger to-[#ff00aa] shadow-danger shadow-2xl/45 p-6 text-white rounded-3xl flex flex-col justify-between gap-6">
                    <div>
                        <p class="text-sm leading-snug font-normal">Competed</p>
                        <h1 class="text-2xl font-semibold leading-6 max-w-50">
                            QUIZZES
                        </h1>
                    </div>
                    <h1 class="text-4xl font-semibold">24</h1>
                </div>
            </div>
        </div>

        <div class="flex flex-col gap-4">
            <!-- Account Info -->
            <div class="flex flex-col gap-4 border-1 border-gray-300 p-6 rounded-2xl">
                <h1 class="text-2xl font-medium">Account Info</h1>
                <div class="grid grid-cols-4 gap-4">
                    <div class="col-span-1 flex flex-col gap-1">
                        <p class="font-medium">Username:</p>
                        <p class="font-medium">Password:</p>
                    </div>

                    <div class="col-span-3 flex flex-col gap-1">
                        <p class="text-paragraph">exampleUsername</p>
                        <p class="text-paragraph">examplePassword</p>
                    </div>
                </div>
            </div>
            <!-- End of Account Info -->

            <!-- Basic Info -->
            <div class="flex flex-col gap-4 border-1 border-gray-300 p-6 rounded-2xl">
                <h1 class="text-2xl font-medium">Basic Info</h1>
                <div class="grid grid-cols-4 gap-4">
                    <div class="col-span-1 flex flex-col gap-1">
                        <p class="font-medium">Gender:</p>
                        <p class="font-medium">Age:</p>
                        <p class="font-medium">Birthday:</p>
                        <p class="font-medium">Current Address:</p>
                        <p class="font-medium">Permanent Address:</p>
                        <p class="font-medium">Grade:</p>
                        <p class="font-medium">Dissability:</p>
                        <p class="font-medium">Parent:</p>
                        <p class="font-medium">Parent Contact No.:</p>
                        <p class="font-medium">Parent Email:</p>
                        <p class="font-medium">Notes:</p>
                    </div>

                    <div class="col-span-3 flex flex-col gap-1">
                        <p class="text-paragraph">Male</p>
                        <p class="text-paragraph">21</p>
                        <p class="text-paragraph">Dec 20, 2003</p>
                        <p class="text-paragraph">Balimbing Boac Marinduque</p>
                        <p class="text-paragraph">Balimbing Boac Marinduque</p>
                        <p class="text-paragraph">3rd Year BSI/T</p>
                        <p class="text-paragraph">Wala gwapo lang</p>
                        <p class="text-paragraph">Nonita Geroleo</p>
                        <p class="text-paragraph">09197011932</p>
                        <p class="text-paragraph">nonita@gmail.com</p>
                        <p class="text-paragraph italic">
                            "Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                            Maiores quasi enim totam reiciendis beatae animi, eos cumque
                            deserunt assumenda perspiciatis expedita qui tempora optio
                            praesentium nesciunt quam nam! Et quae sed, in est earum
                            similique sit. Adipisci placeat iusto blanditiis natus sequi
                            in numquam, dolore dolores nesciunt inventore laborum nam."
                        </p>
                    </div>
                </div>
                <!-- End of Basic Info -->
            </div>
            <div class="flex flex-col bg-whitel rounded-3xl bg-white border-1 border-gray-300 p-6 gap-4">
                <h1 class="text-2xl font-medium">Assigned Lessons</h1>
                <table class="table-auto border-collapse">
                    <thead>
                        <tr>
                            <th class="text-left font-semibold px-2 py-4">Lesson Name</th>
                            <th class="text-center font-semibold px-2 py-4">
                                No. of Videos
                            </th>
                            <th class="text-center font-semibold px-2 py-4">
                                No. of Acts
                            </th>
                            <th class="text-center font-semibold px-2 py-4">
                                No. of Quizzes
                            </th>
                            <th class="text-center font-semibold px-2 py-4">Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td class="text-left px-2 py-4">Lesson 1</td>
                            <td class="text-center px-2 py-4">5</td>
                            <td class="text-center px-2 py-4">4</td>
                            <td class="text-center px-2 py-4">2</td>
                            <td class="text-center px-2 py-4">Completed</td>
                        </tr>

                        <tr>
                            <td class="text-left px-2 py-4">Lesson 1</td>
                            <td class="text-center px-2 py-4">5</td>
                            <td class="text-center px-2 py-4">4</td>
                            <td class="text-center px-2 py-4">2</td>
                            <td class="text-center px-2 py-4">Completed</td>
                        </tr>

                        <tr>
                            <td class="text-left px-2 py-4">Lesson 1</td>
                            <td class="text-center px-2 py-4">5</td>
                            <td class="text-center px-2 py-4">4</td>
                            <td class="text-center px-2 py-4">2</td>
                            <td class="text-center px-2 py-4">Completed</td>
                        </tr>

                        <tr>
                            <td class="text-left px-2 py-4">Lesson 1</td>
                            <td class="text-center px-2 py-4">5</td>
                            <td class="text-center px-2 py-4">4</td>
                            <td class="text-center px-2 py-4">2</td>
                            <td class="text-center px-2 py-4">Completed</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <h1 class="text-3xl font-semibold text-heading-dark">
            Student Performance
        </h1>

        <!-- LineChart -->
        <div class="flex flex-col gap-4">
            <div class="flex flex-col gap-4">
                <h1 class="text-2xl font-medium">Lesson Progress Over time</h1>
                <div id="PerformanceLinechart" class="w-full"></div>
            </div>
        </div>

        <!-- BarChart -->
        <div class="flex flex-col gap-4">
            <div class="flex flex-col gap-4">
                <h1 class="text-2xl font-medium">
                    Average Quiz Score per Subjects
                </h1>
                <div id="PerformanceBarchart" class="w-full"></div>
            </div>
        </div>
    </div>
    <!-- End of Third form -->
</section>
