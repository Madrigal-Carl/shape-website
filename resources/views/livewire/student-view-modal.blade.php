<div>
    @if ($isOpen)
        <section
            class="bg-black/30 fixed w-dvw h-dvh top-0 left-0 z-50 backdrop-blur-xs flex justify-center overflow-y-auto p-10">
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

                        <button type="button" wire:click='closeModal'
                            class="profile-button flex items-center bg-white p-2 rounded-full gap-2 shadow-2xl text-paragraph cursor-pointer hover:text-white hover:bg-blue-button hover:shadow-xl/35 hover:shadow-blue-button hover:scale-105">
                            <span class="material-symbols-rounded">close</span>
                        </button>
                    </div>
                </div>

                <!-- Profile pic and info -->
                <div class="flex gap-6">
                    <img src="{{ asset('storage/' . $student->path) }}" alt="" class="rounded-full w-20" />

                    <div class="flex flex-col justify-between">
                        <h1 class="font-medium text-xl leading-4">{{ ucwords($student->first_name) }}
                            {{ strtoupper(substr($student->middle_name, 0, 1)) }}. {{ ucwords($student->last_name) }}
                        </h1>
                        <p class="text-sm text-paragraph">ID: <span>{{ $student->id }}</span></p>
                        <div class="px-2 py-0.5 rounded-lg bg-[#D2FBD0] w-fit">
                            <div class="w-fit outline-none text-[#0D5F07] text-sm">
                                <p class="text-sm text-black" selected>
                                    {{ ucwords($student->status) }}
                                </p>
                            </div>
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
                                <h1 class="text-2xl font-semibold leading-6">AWARDS</h1>
                            </div>
                            <h1 class="text-4xl font-semibold">24</h1>
                        </div>

                        <div
                            class="bg-gradient-to-tr from-lime to-[#00ff80] shadow-lime shadow-2xl/45 p-6 text-white rounded-3xl flex flex-col justify-between gap-6">
                            <div>
                                <p class="text-sm leading-snug font-normal">Completed</p>
                                <h1 class="text-2xl font-semibold leading-6">LESSONS</h1>
                            </div>
                            <h1 class="text-4xl font-semibold">{{ $student->completed_lessons_count }}</h1>
                        </div>

                        <div
                            class="bg-gradient-to-tr from-yellowOrange to-[#FFEA00] shadow-yellowOrange shadow-2xl/45 p-6 text-white rounded-3xl flex flex-col justify-between gap-6">
                            <div>
                                <p class="text-sm leading-snug font-normal">Completed</p>
                                <h1 class="text-2xl font-semibold leading-6 max-w-50">
                                    ACTIVITIES
                                </h1>
                            </div>
                            <h1 class="text-4xl font-semibold">{{ $student->completed_activities_count }}</h1>
                        </div>

                        <div
                            class="bg-gradient-to-tr from-danger to-[#ff00aa] shadow-danger shadow-2xl/45 p-6 text-white rounded-3xl flex flex-col justify-between gap-6">
                            <div>
                                <p class="text-sm leading-snug font-normal">Competed</p>
                                <h1 class="text-2xl font-semibold leading-6 max-w-50">
                                    QUIZZES
                                </h1>
                            </div>
                            <h1 class="text-4xl font-semibold">{{ $student->completed_quiz }}</h1>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-4">

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
                                <p class="text-paragraph">{{ ucfirst($student->sex) }}</p>
                                <p class="text-paragraph">{{ \Carbon\Carbon::parse($student->birth_date)->age }}</p>
                                <p class="text-paragraph">
                                    {{ \Carbon\Carbon::parse($student->birth_date)->format('F d, Y') }}</p>
                                <p class="text-paragraph">{{ ucwords($student->currentAddress->barangay) }},
                                    {{ ucwords($student->currentAddress->municipality) }},
                                    {{ ucwords($student->currentAddress->province) }}</p>
                                <p class="text-paragraph">{{ ucwords($student->permanentAddress->barangay) }},
                                    {{ ucwords($student->permanentAddress->municipality) }},
                                    {{ ucwords($student->permanentAddress->province) }}</p>
                                <p class="text-paragraph">{{ ucwords($student->profile->grade_level) }}</p>
                                <p class="text-paragraph">{{ ucwords($student->profile->disability_type) }}</p>
                                <p class="text-paragraph">{{ ucwords($student->guardian->first_name) }}
                                    {{ strtoupper(substr($student->guardian->middle_name, 0, 1)) }}.
                                    {{ ucwords($student->guardian->last_name) }}</p>
                                <p class="text-paragraph">{{ ucwords($student->guardian->phone_number) }}</p>
                                <p class="text-paragraph">{{ ucwords($student->guardian->email) }}</p>
                                <p class="text-paragraph italic">{{ ucfirst($student->profile->support_need) }}
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
                                @forelse ($student->lessons as $lesson)
                                    <tr>
                                        <td class="text-left px-2 py-4">{{ $lesson->title }}</td>
                                        <td class="text-center px-2 py-4">{{ count($lesson->videos) }}</td>
                                        <td class="text-center px-2 py-4">{{ count($lesson->activityLessons) }}</td>
                                        <td class="text-center px-2 py-4">1</td>
                                        <td class="text-center px-2 py-4">
                                            {{ $lesson->isCompletedByStudent($student->id) ? 'Completed' : 'In-Progress' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-gray-500">
                                            No lessons found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <h1 class="text-3xl font-semibold text-heading-dark">
                    Student Performance
                </h1>
                <!-- LineChart -->
                <div class="flex flex-col gap-4">
                    <div
                        class="col-span-1 row-span-2 h-full bg-white p-6 rounded-3xl flex flex-col gap-4 shadow-2xl/15">
                        <h1 class="text-xl font-semibold">Lesson Progress Over Time</h1>
                        <div id="PerformanceLinechart" class="w-full" wire:ignore x-data="{}"
                            x-init="() => {
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
                    <div
                        class="col-span-1 row-span-2 h-full bg-white p-6 rounded-3xl flex flex-col gap-4 shadow-2xl/15">
                        <h1 class="text-xl font-semibold">Average Quiz Score per Subjects</h1>
                        <div id="PerformanceBarchart" class="w-full" wire:ignore x-data="{}"
                            x-init="() => {
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
            <!-- End of Third form -->
        </section>
    @endif
</div>
