<div>
    @if ($isOpen)
        <section
            class="bg-black/40 fixed w-dvw h-dvh top-0 left-0 z-50 backdrop-blur-xs flex justify-center overflow-y-auto p-10">
            <!-- Third form -->
            <div class="bg-card p-8 rounded-4xl w-280 flex flex-col gap-12 self-center-safe">
                <div class="flex items-center justify-between gap-2">
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('images/person.png') }}" class="h-8" alt="" />
                        <h1 class="text-3xl font-bold text-heading-dark">
                            Student's Info.
                        </h1>
                    </div>


                    <!-- Action Buttons -->
                    <div class="flex items-center gap-2">
                        {{-- <button
                            class="profile-button flex items-center bg-white py-2 px-5 rounded-full gap-2 text-paragraph cursor-pointer hover:text-white hover:bg-blue-button">
                            <span class="material-symbols-rounded">save</span>
                            <p class="text-sm">Export Form</p>
                        </button> --}}
                        <div
                            class="flex items-center bg-white py-2 px-5 rounded-full text-paragraph hover:bg-blue-button hover:text-white cursor-pointer">
                            <select name="" id="" class="w-max outline-none" wire:model.live="quarter">
                                <option value="1" class=" text-heading-dark">
                                    1st Quarter
                                </option>
                                <option value="2" class=" text-heading-dark">
                                    2nd Quarter
                                </option>
                                <option value="3" class=" text-heading-dark">
                                    3rd Quarter
                                </option>
                                <option value="4" class=" text-heading-dark">
                                    4th Quarter
                                </option>
                            </select>
                        </div>

                        <button wire:click="exportDocx"
                            class="profile-button flex items-center bg-white py-2 px-5 rounded-full gap-2 text-paragraph cursor-pointer hover:text-white hover:bg-blue-button">
                            <span class="material-symbols-rounded">docs</span>
                            <p class="text-sm">Generate Reports</p>
                        </button>

                        <button type="button" wire:click='closeModal'
                            class="bg-white profile-button flex items-center p-2 rounded-full gap-2 text-paragraph cursor-pointer hover:text-white hover:bg-blue-button">
                            <span class="material-symbols-rounded">close</span>
                        </button>
                    </div>
                </div>

                <!-- Profile pic and info -->
                <div class="flex gap-6">
                    <img src="{{ asset('storage/' . $student->path) }}" alt="" class="rounded-full w-20" />

                    <div class="flex flex-col justify-between">
                        <h1 class="font-medium text-xl leading-4">{{ $student->full_name }}
                        </h1>
                        <p class="text-sm text-paragraph">LRN: <span>{{ $student->lrn }}</span></p>
                        <div class="w-fit">
                            @php
                                $statusStyles = [
                                    'active' => ['bg' => 'bg-[#D2FBD0]', 'text' => 'text-[#0D5F07]'],
                                    'inactive' => ['bg' => 'bg-[#F7F7F7]', 'text' => 'text-[#3B3B3B]'],
                                    'graduated' => ['bg' => 'bg-[#D0E8FF]', 'text' => 'text-[#004A9F]'],
                                    'transferred' => [
                                        'bg' => 'bg-[#F0E5C0]',
                                        'text' => 'text-[#7F5900]',
                                    ],
                                    'dropped' => ['bg' => 'bg-[#fce4e4]', 'text' => 'text-[#af0000]'],
                                ];

                                $style = $statusStyles[strtolower($student->enrollmentStatus($school_year))] ?? [
                                    'bg' => 'bg-gray-200',
                                    'text' => 'text-gray-600',
                                ];
                            @endphp

                            <div class="gap-2 {{ $style['bg'] }} px-3 py-1 rounded-lg flex items-center w-fit">
                                <small
                                    class="{{ $style['text'] }}">{{ ucwords($student->enrollmentStatus($school_year)) }}</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Summary -->
                <div class="flex flex-col gap-4">
                    <h1 class="text-2xl font-semibold text-heading-dark">Summary</h1>
                    <div class="grid grid-cols-3 grid-rows-1 gap-4">
                        <div
                            class="bg-gradient-to-tr h-48 from-blue-button to-[#00EEFF] p-6 text-white rounded-3xl flex flex-col justify-between gap-6">
                            <div class="flex justify-between w-full">
                                <div>
                                    <p class="text-xs leading-snug font-normal">Earned</p>
                                    <h1 class="text-lg font-semibold leading-6">AWARDS</h1>
                                </div>
                                <span class="material-symbols-rounded icon">award_star</span>
                            </div>
                            <h1 class="text-5xl font-bold">{{ $student->totalAwardsCount($school_year) }}</h1>
                        </div>

                        <div
                            class="bg-gradient-to-tr h-48 from-lime to-[#00ff80] p-6 text-white rounded-3xl flex flex-col justify-between gap-6">
                            <div class="flex justify-between w-full">
                                <div>
                                    <p class="text-xs leading-snug font-normal">Completed</p>
                                    <h1 class="text-lg font-semibold leading-6">LESSONS</h1>
                                </div>
                                <span class="material-symbols-rounded icon">book_ribbon</span>
                            </div>
                            <h1 class="text-5xl font-bold">{{ $student->completedLessonsCount($school_year, $quarter) }}
                            </h1>
                        </div>

                        <div
                            class="bg-gradient-to-tr h-48 from-yellowOrange to-[#FFEA00] p-6 text-white rounded-3xl flex flex-col justify-between gap-6">
                            <div class="flex justify-between w-full">
                                <div>
                                    <p class="text-xs leading-snug font-normal">Completed</p>
                                    <h1 class="text-lg font-semibold leading-6">ACTIVITIES</h1>
                                </div>
                                <span class="material-symbols-rounded icon">stadia_controller</span>
                            </div>
                            <h1 class="text-5xl font-bold">
                                {{ $student->completedActivitiesCount($school_year, $quarter) }}</h1>
                        </div>
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
                                <p class="text-paragraph">
                                    {{ ucwords($student->isEnrolledIn($school_year)->gradeLevel->name) }}</p>
                                <p class="text-paragraph">{{ ucwords($student->disability_type) }}</p>
                                <p class="text-paragraph">{{ $student->guardian->fullname }}</p>
                                <p class="text-paragraph">{{ ucwords($student->guardian->phone_number) }}</p>
                                <p class="text-paragraph">{{ ucwords($student->guardian->email) }}</p>
                                <p class="text-paragraph italic">{{ ucfirst($student->support_need) }}
                                </p>
                            </div>
                        </div>
                        <!-- End of Basic Info -->
                    </div>
                    <div class="flex flex-col bg-white rounded-2xl p-6 gap-4 ">
                        <h1 class="text-2xl font-semibold text-heading-dark">Assigned Lessons</h1>
                        <table class="table-auto border-collapse">
                            <thead>
                                <tr>
                                    <th class="text-left font-semibold pb-2 text-lg">Lesson Name</th>
                                    <th class="text-center font-semibold pb-2 text-lg">
                                        No. of Videos
                                    </th>
                                    <th class="text-center font-semibold pb-2 text-lg">
                                        No. of Activities
                                    </th>
                                    <th class="text-center font-semibold pb-2 text-lg">Status</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($filteredLessons as $lesson)
                                    <tr>
                                        <td class="text-left pt-2 text-paragraph">{{ $lesson->title }}</td>
                                        <td class="text-center pt-2 text-paragraph">{{ $lesson->videos->count() }}</td>
                                        <td class="text-center pt-2 text-paragraph">
                                            {{ $lesson->activityLessons->count() }}</td>
                                        <td class="text-center pt-2 text-paragraph">
                                            {{ $lesson->isCompletedByStudent($student->id) ? 'Completed' : 'In-Progress' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-gray-500">
                                            No lessons found for this quarter.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="flex flex-col gap-8 bg-white p-6 rounded-2xl">
                        <div class="flex flex-col gap-2 mb-4">
                            <h1 class="text-2xl font-semibold text-heading-dark">
                                Student Performance
                            </h1>
                            <p class="text-paragraph">Overview of student's lesson progress and quiz scores.</p>
                        </div>


                        <div class="w-full grid grid-cols-2 gap-4">
                            <!-- BarChart -->
                            <div class="flex flex-col gap-4">
                                <div class="col-span-1 h-full bg-white rounded-2xl flex flex-col gap-4">
                                    <h1 class="text-xl font-semibold">Weekly Activities</h1>
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

                            {{-- Radar Graph --}}
                            <div class="col-span-1 h-full bg-white rounded-2xl flex flex-col gap-4">
                                <h1 class="text-xl font-semibold">Student Performance Stats</h1>
                                <div id="RadarChart" class="w-full" wire:ignore x-data="{}"
                                    x-init="() => {
                                        var options = {
                                            series: [{
                                                name: 'Average Score',
                                                data: [44, 55, 13, 43, 22, 43, 22]
                                            }],
                                            plotOptions: {
                                                radar: {
                                                    polygons: {
                                                        strokeColor: '#e8e8e8',
                                                        fill: {
                                                            colors: ['#f8f8f8', '#fff']
                                                        }
                                                    }
                                                }
                                            },
                                            chart: {
                                                height: 410,
                                                type: 'radar',
                                                toolbar: { show: false }
                                            },
                                            xaxis: {
                                                categories: [
                                                    'Self-Help',
                                                    'Social',
                                                    'Numeracy',
                                                    'Literacy',
                                                    'Motor',
                                                    'Pre-Vocational',
                                                    'Vocational'
                                                ]
                                            },
                                            dataLabels: {
                                                enabled: true,
                                                background: {
                                                    enabled: true,
                                                    borderRadius: 2,
                                                }
                                            },
                                            fill: {
                                                opacity: 0.3, // adjust transparency
                                                colors: ['#247BFF'] // bg color
                                            },
                                            stroke: {
                                                colors: ['#247BFF'], //  outline color
                                                width: 2
                                            },
                                            markers: {
                                                size: 4,
                                                colors: ['#247BFF'], // marker color
                                                strokeColors: '#fff',
                                                strokeWidth: 2
                                            },
                                            responsive: [{
                                                breakpoint: 500,
                                                options: {
                                                    chart: { height: 300 },
                                                    legend: { position: 'bottom' }
                                                }
                                            }]
                                        };
                                    
                                        var chart = new ApexCharts(document.querySelector('#RadarChart'), options);
                                        chart.render();
                                    }">
                                </div>
                            </div>
                        </div>


                        <!-- LineChart -->
                        <div class="col-span-1 h-full bg-white rounded-2xl flex flex-col gap-4">
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
                </div>





            </div>
            <!-- End of Third form -->
        </section>
    @endif
</div>
