<main class="col-span-5 px-8 py-4 flex flex-col h-dvh gap-4 overflow-y-auto">
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

    <!-- Dashboard -->
    <div class="mt-12 flex flex-col gap-4">
        <h1 class="text-4xl font-medium">Dashboard</h1>
        <div class="grid grid-cols-4 grid-rows-1 gap-4">
            <div
                class="bg-gradient-to-tr from-blue-button to-[#00EEFF] shadow-blue-button shadow-2xl/45 p-6 text-white rounded-3xl flex flex-col justify-between gap-6">
                <div class="flex justify-between">
                    <div>
                        <p class="text-sm leading-snug font-normal">Total Students</p>
                        <h1 class="text-2xl font-semibold leading-6">EBROLLED</h1>
                    </div>
                    <span class="material-symbols-rounded icon">people</span>
                </div>
                <h1 class="text-4xl font-semibold">24</h1>
            </div>

            <div
                class="bg-gradient-to-tr from-lime to-[#00ff80] shadow-lime shadow-2xl/45 p-6 text-white rounded-3xl flex flex-col justify-between gap-6">
                <div class="flex justify-between">
                    <div>
                        <p class="text-sm leading-snug font-normal">Students with</p>
                        <h1 class="text-2xl font-semibold leading-6">AUTISM</h1>
                    </div>
                    <span class="material-symbols-rounded icon">sentiment_very_satisfied</span>
                </div>
                <h1 class="text-4xl font-semibold">24</h1>
            </div>

            <div
                class="bg-gradient-to-tr from-yellowOrange to-[#FFEA00] shadow-yellowOrange shadow-2xl/45 p-6 text-white rounded-3xl flex flex-col justify-between gap-6">
                <div class="flex justify-between">
                    <div>
                        <p class="text-sm leading-snug font-normal">Students with</p>
                        <h1 class="text-2xl font-semibold leading-6 max-w-50">
                            HEARING IMPAIRED
                        </h1>
                    </div>
                    <span class="material-symbols-rounded icon">hearing_disabled</span>
                </div>
                <h1 class="text-4xl font-semibold">24</h1>
            </div>

            <div
                class="bg-gradient-to-tr from-danger to-[#ff00aa] shadow-danger shadow-2xl/45 p-6 text-white rounded-3xl flex flex-col justify-between gap-6">
                <div class="flex justify-between">
                    <div>
                        <p class="text-sm leading-snug font-normal">Total Students</p>
                        <h1 class="text-2xl font-semibold leading-6 max-w-50">
                            SPEECH IMPAIRED
                        </h1>
                    </div>
                    <span class="material-symbols-rounded icon">graphic_eq</span>
                </div>
                <h1 class="text-4xl font-semibold">24</h1>
            </div>
        </div>

        <div class="grid grid-cols-4 grid-rows-1 gap-4">
            <div class="bg-white p-6 text-heading-dark shadow-2xl/15 rounded-3xl flex flex-col justify-between gap-6">
                <div class="flex justify-between">
                    <div>
                        <p class="text-sm leading-snug font-normal text-paragraph">
                            Total No. of
                        </p>
                        <h1 class="text-2xl font-semibold leading-6">CURRICULUM</h1>
                    </div>
                    <span class="material-symbols-rounded icon">book_4</span>
                </div>
                <h1 class="text-4xl font-semibold text-blue-button">24</h1>
            </div>

            <div class="bg-white p-6 text-heading-dark shadow-2xl/15 rounded-3xl flex flex-col justify-between gap-6">
                <div class="flex justify-between">
                    <div>
                        <p class="text-sm leading-snug font-normal text-paragraph">
                            Total No. of
                        </p>
                        <h1 class="text-2xl font-semibold leading-6">LESSONS</h1>
                    </div>
                    <span class="material-symbols-rounded icon">library_books</span>
                </div>
                <h1 class="text-4xl font-semibold text-lime">24</h1>
            </div>

            <div class="bg-white p-6 text-heading-dark shadow-2xl/15 rounded-3xl flex flex-col justify-between gap-6">
                <div class="flex justify-between">
                    <div>
                        <p class="text-sm leading-snug font-normal text-paragraph">
                            Total No. 0f
                        </p>
                        <h1 class="text-2xl font-semibold leading-6">GAMES</h1>
                    </div>
                    <span class="material-symbols-rounded icon">sports_esports</span>
                </div>
                <h1 class="text-4xl font-semibold text-yellowOrange">24</h1>
            </div>

            <div class="bg-white p-6 text-heading-dark shadow-2xl/15 rounded-3xl flex flex-col justify-between gap-6">
                <div class="flex justify-between">
                    <div>
                        <p class="text-sm leading-snug font-normal text-paragraph">
                            Total No. of
                        </p>
                        <h1 class="text-2xl font-semibold leading-6">AWARDS</h1>
                    </div>
                    <span class="material-symbols-rounded icon">award_star</span>
                </div>
                <h1 class="text-4xl font-semibold text-danger">24</h1>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-2 grid-rows-4 gap-4">
        <div class="col-span-1 row-span-2 h-full bg-white p-6 rounded-3xl flex flex-col gap-4 shadow-2xl/15">
            <h1 class="text-xl font-semibold">Weekly Activities</h1>
            <div id="Barchart" class="w-full" wire:ignore x-data="{}" x-init="() => {
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
                    yaxis: { title: { text: '$ (thousands)' } },
                    fill: { opacity: 1 },
                    tooltip: { y: { formatter: val => `$ ${val} thousands` } },
                };
            
                var chart = new ApexCharts(document.querySelector('#Barchart'), options);
                chart.render();
            }">
            </div>
        </div>

        <div class="col-span-1 row-span-2 h-full bg-white p-6 rounded-3xl flex flex-col gap-4 shadow-2xl/15">
            <h1 class="text-xl font-semibold">Weekly Activities</h1>
            <div id="Piechart" class="w-full" wire:ignore x-data="{}" x-init="() => {
                var options = {
                    series: [44, 55, 13, 43, 22],
                    chart: {
                        width: 460,
                        type: 'pie',
                        toolbar: { show: false }
                    },
                    labels: ['Team A', 'Team B', 'Team C', 'Team D', 'Team E'],
                    responsive: [{
                        breakpoint: 500,
                        options: {
                            chart: { width: 200 },
                            legend: { position: 'bottom' }
                        }
                    }]
                };
            
                var chart = new ApexCharts(document.querySelector('#Piechart'), options);
                chart.render();
            }">
            </div>

        </div>

        <div class="col-span-2 row-span-2 h-full bg-white p-6 rounded-3xl flex flex-col gap-4 shadow-2xl/15">
            <h1 class="text-xl font-semibold">Weekly Activities</h1>
            <div id="Linechart" class="w-full" wire:ignore x-data="{}" x-init="() => {
                var options = {
                    series: [
                        { name: 'series1', data: [31, 40, 28, 51, 42, 109, 100] },
                        { name: 'series2', data: [11, 32, 45, 32, 34, 52, 41] }
                    ],
                    chart: {
                        height: 350,
                        type: 'area',
                        toolbar: { show: false }
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
                            '2018-09-19T06:30:00.000Z'
                        ]
                    },
                    tooltip: {
                        x: { format: 'dd/MM/yy HH:mm' }
                    }
                };
            
                var chart = new ApexCharts(document.querySelector('#Linechart'), options);
                chart.render();
            }">
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
