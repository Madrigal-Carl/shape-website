<div>
    @if ($isOpen)
        <section class="bg-black/30 fixed w-dvw h-dvh p-10 top-0 left-0 z-50 backdrop-blur-xs flex justify-center gap-6">
            <!-- Teacher Profile -->
            <div class="flex items-center justify-center gap-6">
                <div class="col-span-1 w-180 h-full  bg-card p-8 rounded-4xl relative overflow-hidden">

                    <div class="w-full h-full flex flex-col  gap-12 Addlesson overflow-y-auto">
                        <div class="flex items-center justify-between gap-2">
                            <div class="flex items-center gap-2">
                                <img src="{{ asset('images/person.png') }}" class="h-8" alt="" />
                                <h1 class="text-3xl font-bold text-heading-dark">
                                    Teacher's Info.
                                </h1>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex items-center gap-2">
                                <button
                                    class="z-20 profile-button flex items-center bg-white py-2 px-5 rounded-full gap-2 shadow-2xl text-paragraph cursor-pointer hover:text-white hover:bg-blue-button hover:shadow-xl/35 hover:shadow-blue-button">
                                    <span class="material-symbols-rounded">save</span>
                                    <p class="text-sm">Export Form</p>
                                </button>

                                <button
                                    class="z-20 profile-button flex items-center bg-white py-2 px-5 rounded-full gap-2 shadow-2xl text-paragraph cursor-pointer hover:text-white hover:bg-blue-button hover:shadow-xl/35 hover:shadow-blue-button">
                                    <span class="material-symbols-rounded">docs</span>
                                    <p class="text-sm">Generate Reports</p>
                                </button>

                                {{-- <button
                            class="profile-button flex items-center bg-white py-2 px-5 rounded-full gap-2 shadow-2xl text-paragraph cursor-pointer hover:text-white hover:bg-blue-button hover:shadow-xl/35 hover:shadow-blue-button hover:scale-105">
                            <span class="material-symbols-rounded">calendar_month</span>
                            <p class="text-sm">Select Date</p>
                        </button> --}}


                            </div>
                        </div>

                        <!-- Profile pic and info -->
                        <div class="flex gap-6">
                            <img src="{{ asset('images/default_profiles/default-male-teacher-pfp.png') }}"
                                alt="" class="rounded-full w-20" />

                            <div class="flex flex-col justify-between">
                                <h1 class="font-medium text-xl leading-4">Dave Geroleo
                                </h1>
                                <p class="text-sm text-paragraph">ID: <span>1234567890</span></p>
                                <div class="w-fit">
                                    <div class="gap-2 bg-[#D2FBD0]  px-3 py-1 rounded-lg flex items-center w-fit">
                                        <small class="text-[#0D5F07]">Active</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Summary -->
                        <div class="flex flex-col gap-4">
                            <h1 class="text-2xl font-semibold text-heading-dark">Summary</h1>
                            <div class="grid grid-cols-3 grid-rows-1 gap-4">
                                <div
                                    class="bg-gradient-to-tr h-48 from-blue-button to-[#00EEFF] shadow-blue-button shadow-2xl/45 p-6 text-white rounded-3xl flex flex-col justify-between gap-6">
                                    <div class="flex justify-between w-full">
                                        <div>
                                            <p class="text-xs leading-snug font-normal">Total</p>
                                            <h1 class="text-lg font-semibold leading-6">STUDENTS</h1>
                                        </div>
                                        <span class="material-symbols-rounded icon">people</span>
                                    </div>
                                    <h1 class="text-5xl font-bold">25</h1>
                                </div>

                                <div
                                    class="bg-gradient-to-tr h-48 from-lime to-[#00ff80] shadow-lime shadow-2xl/45 p-6 text-white rounded-3xl flex flex-col justify-between gap-6">
                                    <div class="flex justify-between w-full">
                                        <div>
                                            <p class="text-xs leading-snug font-normal">No. of created</p>
                                            <h1 class="text-lg font-semibold leading-6">LESSONS</h1>
                                        </div>
                                        <span class="material-symbols-rounded icon">book_ribbon</span>
                                    </div>
                                    <h1 class="text-5xl font-bold">30</h1>
                                </div>

                                <div
                                    class="bg-gradient-to-tr h-48 from-yellowOrange to-[#FFEA00] shadow-yellowOrange shadow-2xl/45 p-6 text-white rounded-3xl flex flex-col justify-between gap-6">
                                    <div class="flex justify-between w-full">
                                        <div>
                                            <p class="text-xs leading-snug font-normal">No. of uploaded</p>
                                            <h1 class="text-lg font-semibold leading-6">VIDEOS</h1>
                                        </div>
                                        <span class="material-symbols-rounded icon">video_library</span>
                                    </div>
                                    <h1 class="text-5xl font-bold">23
                                    </h1>
                                </div>

                                {{-- <div
                            class="bg-gradient-to-tr from-danger to-[#ff00aa] shadow-danger shadow-2xl/45 p-6 text-white rounded-3xl flex flex-col justify-between gap-6">
                            <div>
                                <p class="text-sm leading-snug font-normal">Competed</p>
                                <h1 class="text-2xl font-semibold leading-6 max-w-50">
                                    QUIZZES
                                </h1>
                            </div>
                            <h1 class="text-5xl font-bold">0</h1>
                        </div> --}}
                            </div>
                        </div>

                        <div class="flex flex-col gap-4">

                            <!-- Basic Info -->
                            <div class="flex flex-col gap-4 bg-white p-6 rounded-2xl">
                                <h1 class="text-2xl font-semibold text-heading-dark">Basic Info</h1>
                                <div class="grid grid-cols-4 gap-4">
                                    <div class="col-span-1 flex flex-col gap-1">
                                        <p class="font-medium">Gender:</p>
                                        <p class="font-medium">Age:</p>
                                        <p class="font-medium">Birthday:</p>
                                        <p class="font-medium">Current Address:</p>
                                        <p class="font-medium">Permanent Address:</p>
                                        <p class="font-medium">Specialization:</p>
                                        <p class="font-medium">Contact No.:</p>
                                        <p class="font-medium">Email:</p>
                                    </div>

                                    <div class="col-span-3 flex flex-col gap-1">
                                        <p class="text-paragraph">Make</p>
                                        <p class="text-paragraph">21
                                        </p>
                                        <p class="text-paragraph">
                                            Dec 20, 2003</p>
                                        <p class="text-paragraph">Balimbing Boac Marinduque</p>
                                        <p class="text-paragraph">Balimbing Boac Marinduque</p>
                                        <p class="text-paragraph">Super Handsome</p>
                                        <p class="text-paragraph">1234567890</p>
                                        <p class="text-paragraph">exampleemail@gmail.com</p>
                                    </div>
                                </div>
                                <!-- End of Basic Info -->
                            </div>
                            <div class="flex flex-col bg-white rounded-2xl p-6 gap-4 ">
                                <h1 class="text-2xl font-semibold text-heading-dark">Assigned Lessons</h1>
                                <table class="table-auto border-collapse border-0">
                                    <thead class="sticky top-0 left-0 z-40 bg-white">
                                        <tr>
                                            <th class="px-4 py-3 rounded-l-xl text-center font-semibold bg-card">ID</th>
                                            <th class="px-4 py-3 text-center font-semibold bg-card">
                                                Curriculum Name
                                            </th>
                                            <th class="px-4 py-3 text-center font-semibold bg-card">
                                                Grade Level
                                            </th>
                                            <th class="px-4 py-3 text-center font-semibold bg-card">
                                                No. of Subjects
                                            </th>
                                            <th class="px-4 py-3 rounded-r-xl text-center font-semibold bg-card">Actions
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>
                                            <!-- Your original cells -->
                                            <td class="px-4 py-3 text-center text-paragraph">1</td>
                                            <td class="px-4 py-3 text-center text-paragraph">
                                                FSL Curriculum
                                            </td>
                                            <td class="px-4 py-3 text-center text-paragraph">
                                                Grade 1</td>
                                            <td class="px-4 py-3 text-center text-paragraph">
                                                15</td>

                                            <td class="px-4 py-3 text-center">
                                                <div class="flex justify-center items-center gap-1 text-white">
                                                    <button
                                                        class="bg-blue-button px-2 py-1 flex gap-2 items-center rounded-lg cursor-pointer hover:scale-110 min-w-[50px] justify-center relative">

                                                        <!-- Text (hidden when loading) -->
                                                        <small class="transition-opacity duration-150">
                                                            View
                                                        </small>

                                                        <!-- Spinner (overlay) -->
                                                        {{-- <svg wire:loading
                                                        wire:target='openViewCurriculumModal({{ $curriculum->id }})'
                                                        class="w-4 h-4 text-white animate-spin absolute"
                                                        viewBox="0 0 100 101" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                                            fill="currentColor" />
                                                        <path
                                                            d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                                            fill="currentFill" />
                                                    </svg> --}}
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        {{-- <tr>
                                            <td colspan="7" class="text-center py-6 text-gray-500">
                                                No curriculums found.
                                            </td>
                                        </tr> --}}
                                    </tbody>
                                </table>
                            </div>
                            <div class="flex flex-col gap-4 bg-white p-6 rounded-2xl">
                                <div class="flex flex-col gap-2 mb-4">
                                    <h1 class="text-2xl font-semibold text-heading-dark">
                                        Student Performance
                                    </h1>
                                    <p class="text-paragraph">Overview of student's lesson progress and quiz scores.</p>
                                </div>


                                <!-- LineChart -->
                                <div class="flex flex-col gap-4">
                                    <div class="col-span-1 row-span-2 h-full bg-white rounded-2xl flex flex-col gap-4">
                                        <h1 class="text-xl font-semibold">Lesson Progress Over Time</h1>
                                        <div id="PerformanceLinechart" class="w-full" wire:ignore
                                            x-data="{}" x-init="() => {
                                                var options = {
                                                    series: [{
                                                            name: 'Series 1',
                                                            data: [31, 40, 28, 51, 42, 109, 100],
                                                        },
                                                        {
                                                            name: 'Series 2',
                                                            data: [11, 32, 45, 32, 34, 52, 41],
                                                        },
                                                    ],
                                                    chart: {
                                                        type: 'area',
                                                        height: 350,
                                                        toolbar: { show: false },
                                                    },
                                                    dataLabels: { enabled: false },
                                                    stroke: { curve: 'smooth' },
                                                    xaxis: {
                                                        type: 'datetime',
                                                        categories: [
                                                            '2018-09-19T00:00:00.000Z',
                                                            '2018-09-19T01:30:00.000Z',
                                                            '2018-09-19T02:30:00.000Z',
                                                            '2018-09-19T03:30:00.000Z',
                                                            '2018-09-19T04:30:00.000Z',
                                                            '2018-09-19T05:30:00.000Z',
                                                            '2018-09-19T06:30:00.000Z',
                                                        ],
                                                    },
                                                    tooltip: {
                                                        x: { format: 'dd/MM/yy HH:mm' },
                                                    },
                                                };
                                            
                                                var chart = new ApexCharts(document.querySelector('#PerformanceLinechart'), options);
                                                chart.render();
                                            }">
                                        </div>
                                    </div>

                                </div>

                                <!-- BarChart -->
                                <div class="flex flex-col gap-4">
                                    <div class="col-span-1 row-span-2 h-full bg-white rounded-2xl flex flex-col gap-4">
                                        <h1 class="text-xl font-semibold">Average Quiz Score per Subjects</h1>
                                        <div id="PerformanceBarchart" class="w-full" wire:ignore
                                            x-data="{}" x-init="() => {
                                                var options = {
                                                    series: [
                                                        { name: 'Net Profit', data: [44, 55, 57, 56, 61, 58, 63, 60, 66] },
                                                        { name: 'Revenue', data: [76, 85, 101, 98, 87, 105, 91, 114, 94] },
                                                        { name: 'Free Cash Flow', data: [35, 41, 36, 26, 45, 48, 52, 53, 41] }
                                                    ],
                                                    chart: {
                                                        type: 'bar',
                                                        height: 350,
                                                        toolbar: { show: false },
                                                    },
                                                    plotOptions: {
                                                        bar: {
                                                            horizontal: false,
                                                            columnWidth: '55%',
                                                            borderRadius: 5,
                                                            borderRadiusApplication: 'end',
                                                        },
                                                    },
                                                    dataLabels: { enabled: false },
                                                    stroke: { show: true, width: 2, colors: ['transparent'] },
                                                    xaxis: { categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'] },
                                                    fill: { opacity: 1 },
                                                    tooltip: { y: { formatter: val => `${val}%` } },
                                                };
                                            
                                                var chart = new ApexCharts(document.querySelector('#PerformanceBarchart'), options);
                                                chart.render();
                                            }">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                </div>
                <!-- End Teacher Profile -->


                {{-- Students Table --}}
                <div class="w-220 h-full Addlesson bg-card p-8 rounded-4xl relative">
                    <div
                        class="col-span-1 Addlesson w-full h-full flex flex-col gap-8 self-center-safe overflow-hidden">

                        <!-- Student Table -->
                        <div class="w-full flex flex-col gap-4 h-full">
                            <div class="side flex items-center justify-between gap-2 mb-2">
                                <h1 class="text-2xl font-semibold text-heading-dark">Student List</h1>
                                <div class="flex items-center gap-4 self-start">
                                    <div
                                        class="profile-button flex items-center bg-white py-2 px-5 rounded-full gap-2 shadow-2xl text-paragraph cursor-pointer hover:text-white hover:bg-blue-button hover:shadow-xl/35 hover:shadow-blue-button">
                                        <select class="w-30 outline-none">
                                            <option value="" class=" text-heading-dark" selected disabled>
                                                Grade Level
                                            </option>
                                            <option value="all" class=" text-heading-dark">
                                                All
                                            </option>
                                            <option value="all" class=" text-heading-dark">
                                                Grade 1
                                            </option>
                                        </select>
                                    </div>

                                    <div
                                        class="profile-button flex items-center bg-white py-2 px-5 rounded-full gap-2 shadow-2xl text-paragraph cursor-pointer hover:text-white hover:bg-blue-button hover:shadow-xl/35 hover:shadow-blue-button">
                                        <select name="" id="" class="w-30 outline-none"
                                            wire:change="$set('status', $event.target.value)">
                                            <option class=" text-heading-dark" selected disabled>
                                                Status
                                            </option>
                                            <option value="all" class=" text-heading-dark">
                                                All
                                            </option>
                                            <option value="active" class=" text-lime">
                                                Active
                                            </option>
                                            <option value="inactive" class=" text-paragraph">
                                                Inactive
                                            </option>
                                            <option value="graduated" class=" text-blue-button">
                                                Graduated
                                            </option>
                                            <option value="transferred" class=" text-yellowOrange">
                                                Transferred
                                            </option>
                                            <option value="dropped" class=" text-danger">
                                                Dropped
                                            </option>
                                        </select>
                                    </div>


                                    {{-- <div
                                        class="flex gap-2 items-center bg-white py-3 px-5 rounded-full shadow-2xl/15 text-paragraph border-2 border-white hover:border-blue-button cursor-pointer">
                                        <span class="material-symbols-rounded">search</span>
                                        <input type="text"
                                            class="outline-none w-20 focus:w-60 placeholder-paragraph"
                                            placeholder="Search">
                                    </div> --}}
                                    <button type="button" wire:click='closeModal'
                                        class="bg-white profile-button flex items-center p-2 rounded-full gap-2 shadow-2xl text-paragraph cursor-pointer hover:text-white hover:bg-blue-button hover:shadow-xl/35 hover:shadow-blue-button">
                                        <span class="material-symbols-rounded">close</span>
                                    </button>
                                </div>
                            </div>

                            <div class="flex flex-col w-full p-6 min-h-[20%] bg-white rounded-3xl shadow-2xl/5">
                                <div class="flex flex-col overflow-y-scroll min-h-[20%]">
                                    <div class="flex flex-col rounded-3xl bg-white">
                                        <table class="table-auto border-separate relative">
                                            <thead class="sticky top-0 left-0 z-40 bg-white">
                                                <tr>
                                                    <th class="px-4 pb-3 text-center font-semibold">ID</th>
                                                    <th class="px-4 pb-3 text-center font-semibold">Name</th>
                                                    <th class="px-4 pb-3 text-center font-semibold">
                                                        Disability
                                                    </th>
                                                    <th class="px-4 pb-3 text-center font-semibold w-20">
                                                        Lessons
                                                    </th>
                                                    <th class="px-4 pb-3 text-center font-semibold w-20">
                                                        Activities
                                                    </th>
                                                    <th class="px-4 pb-3 text-center font-semibold">Status</th>
                                                    <th class="px-4 pb-3 text-center font-semibold">Actions</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr>
                                                    <td class="px-4 py-3 text-center text-paragraph">
                                                        01</td>
                                                    <td class="px-4 py-3 text-center text-paragraph align-middle">
                                                        <p class="truncate w-25">
                                                            Erickson Dave Geroleo</p>
                                                    </td>
                                                    <td class="px-4 py-3 text-center text-paragraph align-middle">
                                                        <p class="truncate w-25">
                                                            Hearing Impaired</p>
                                                    </td>
                                                    <td class="px-4 py-3 text-center text-paragraph">
                                                        20
                                                    </td>
                                                    <td class="px-4 py-3 text-center text-paragraph">
                                                        20
                                                    </td>
                                                    <td class="px-4 py-3 text-center">
                                                        <div class="flex justify-center items-center">


                                                            <div
                                                                class="gap-2 bg-[#D2FBD0] px-2 py-1 rounded-full flex items-center w-fit">
                                                                <small class="text-[#0D5F07]">Active</small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-4 py-3 text-center">
                                                        <div class="flex justify-center items-center gap-1 text-white">
                                                            <button
                                                                class="px-2 py-1 flex gap-2 items-center rounded-lg min-w-[50px] justify-center relative transition bg-danger cursor-pointer hover:scale-110">

                                                                <!-- Text (hidden when loading) -->
                                                                <small class="transition-opacity duration-150">
                                                                    Edit
                                                                </small>

                                                                <!-- Spinner (overlay) -->
                                                                {{-- <svg wire:loading
                                                                    wire:target='openEditStudentModal({{ $student->id }})'
                                                                    aria-hidden="true"
                                                                    class="w-4 h-4 text-white animate-spin absolute"
                                                                    viewBox="0 0 100 101" fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                                                        fill="currentColor" />
                                                                    <path
                                                                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                                                        fill="currentFill" />
                                                                </svg> --}}
                                                            </button>
                                                            <button
                                                                class="bg-blue-button cursor-pointer hover:scale-110 px-2 py-1 flex gap-2 items-center rounded-lg min-w-[50px] justify-center relative">

                                                                <!-- Text (hidden when loading) -->
                                                                <small class="transition-opacity duration-150">
                                                                    View
                                                                </small>

                                                                <!-- Spinner (overlay) -->
                                                                {{-- <svg wire:loading
                                                                    wire:target='openViewStudentModal({{ $student->id }})'
                                                                    class="w-4 h-4 text-white animate-spin absolute"
                                                                    viewBox="0 0 100 101" fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                                                        fill="currentColor" />
                                                                    <path
                                                                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                                                        fill="currentFill" />
                                                                </svg> --}}
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>






                                                {{-- <tr>
                                                    <td colspan="7" class="text-center py-6 text-gray-500">
                                                        No Students found.
                                                    </td>
                                                </tr> --}}

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            {{-- <div
                                class="rounded-full bg-white gap-1 p-2 w-fit self-center-safe flex items-center text-sm shadow-2xl">
                                <button class="cursor-pointer py-1 flex items-center px-3">
                                    <span class="material-symbols-outlined">
                                        chevron_left
                                    </span>
                                </button>

                                <button
                                    class=" bg-blue-button text-white py-1 px-4 rounded-full cursor-pointer">1</button>
                                <button
                                    class="py-1 px-4 hover:bg-blue-button rounded-full hover:text-white cursor-pointer">2</button>

                                <button class="cursor-pointer py-1 flex items-center px-3">
                                    <span class="material-symbols-outlined">
                                        chevron_right
                                    </span>
                                </button>
                            </div> --}}
                        </div>

                    </div>
                </div>
            </div>
        </section>
    @endif
</div>
