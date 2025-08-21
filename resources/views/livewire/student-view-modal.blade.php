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
