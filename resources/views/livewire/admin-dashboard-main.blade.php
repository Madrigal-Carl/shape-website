<main class="col-span-5 pl-8 pr-4 py-4 flex flex-col h-dvh gap-4 overflow-y-auto">
    <!-- Greetings -->
    <div class="flex gap-2 mt-4 w-auto justify-between">
        <div class="flex gap-4">
            <span class="w-2 h-full bg-blue-button rounded-full"></span>
            <div class="flex flex-col gap-1">
                <h1 class="text-2xl font-semibold leading-tight">
                    Welcome back, Sir
                    <span class="font-bold text-blue-button">Dave</span>
                </h1>
                <p class="text-lg text-paragraph leading-4">Here is your summary today</p>
                <div class="w-max px-2 py-1 mt-4 rounded-lg border-1 border-gray-300 hover:border-blue-button">
                    <select class="w-full outline-none text-heading-dark font-medium text-lg"
                        wire:model.live='school_year'>
                        @php
                            $currentYear = now()->schoolYear()?->name;
                            $years = collect($school_years);

                            if (!$years->contains($currentYear)) {
                                $years->push($currentYear);
                            }
                        @endphp

                        @foreach ($school_years as $sy)
                            <option value="{{ $sy->id }}" {{ $sy->id == $school_year ? 'selected' : '' }}>
                                S.Y {{ $sy->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Buttons -->
        <div class="flex gap-4 self-start">
            <button wire:click='openQuarterModal'
                class="flex items-center bg-white py-3 px-5 rounded-full gap-2 text-paragraph cursor-pointer border-2 border-white hover:border-blue-button hover:text-white hover:bg-blue-button">
                <span class="material-symbols-rounded">calendar_month</span>
                <p class="">Set Quarters</p>
            </button>
            {{-- <button
                class="flex items-center bg-white py-3 px-5 rounded-full gap-2 text-paragraph cursor-pointer border-2 border-white hover:border-blue-button hover:text-white hover:bg-blue-button">
                <span class="material-symbols-rounded">save</span>
                <p class="">Export</p>
            </button> --}}
        </div>
    </div>

    <!-- Dashboard -->
    <div class="mt-12 flex flex-col gap-4">
        <h1 class="text-5xl font-bold mb-2">Dashboard</h1>
        <div class="w-full grid grid-cols-2 gap-4">
            <div class="grid grid-cols-2 grid-rows-2 gap-4">
                <div
                    class="bg-gradient-to-tr h-48 from-blue-button to-[#00EEFF] shadow-blue-button shadow-2xl/45 p-6 text-white rounded-3xl flex flex-col justify-between gap-6">
                    <div class="flex justify-between">
                        <div>
                            <p class="text-sm leading-snug font-normal">Total Students</p>
                            <h1 class="text-2xl font-semibold leading-6">ENROLLED</h1>
                        </div>
                        <span class="material-symbols-rounded icon">people</span>
                    </div>
                    <h1 class="text-5xl font-bold">24</h1>
                </div>

                <div
                    class="bg-gradient-to-tr h-48 from-lime to-[#00ff80] shadow-lime shadow-2xl/45 p-6 text-white rounded-3xl flex flex-col justify-between gap-6">
                    <div class="flex justify-between">
                        <div>
                            <p class="text-sm leading-snug font-normal">Students with</p>
                            <h1 class="text-2xl font-semibold leading-6">AUTISM</h1>
                        </div>
                        <span class="material-symbols-rounded icon">sentiment_very_satisfied</span>
                    </div>
                    <h1 class="text-5xl font-bold">14</h1>
                </div>

                <div
                    class="bg-gradient-to-tr h-48 from-yellowOrange to-[#FFEA00] shadow-yellowOrange shadow-2xl/45 p-6 text-white rounded-3xl flex flex-col justify-between gap-6">
                    <div class="flex justify-between">
                        <div>
                            <p class="text-sm leading-snug font-normal">Students with</p>
                            <h1 class="text-2xl font-semibold leading-6 max-w-50">
                                HEARING IMPAIRED
                            </h1>
                        </div>
                        <span class="material-symbols-rounded icon">hearing_disabled</span>
                    </div>
                    <h1 class="text-5xl font-bold">6</h1>
                </div>

                <div
                    class="bg-gradient-to-tr h-48 from-danger to-[#ff00aa] shadow-danger shadow-2xl/45 p-6 text-white rounded-3xl flex flex-col justify-between gap-6">
                    <div class="flex justify-between">
                        <div>
                            <p class="text-sm leading-snug font-normal">Total Students</p>
                            <h1 class="text-2xl font-semibold leading-6 max-w-50">
                                SPEECH IMPAIRED
                            </h1>
                        </div>
                        <span class="material-symbols-rounded icon">graphic_eq</span>
                    </div>
                    <h1 class="text-5xl font-bold">5</h1>
                </div>
            </div>
            <div class="grid grid-cols-1 grid-rows-2 gap-4">
                <div class="bg-white p-6 h-48 text-heading-dark rounded-3xl flex flex-col justify-between gap-6">
                    <div class="flex justify-between">
                        <div>
                            <p class="text-sm leading-snug font-normal text-paragraph">
                                Total No. of
                            </p>
                            <h1 class="text-2xl font-semibold leading-6">INSTRUCTORS</h1>
                        </div>
                        <img src="{{ asset('images/student-feed.png') }}" class="h-6" alt="">
                    </div>
                    <h1 class="text-5xl font-bold text-lime">10</h1>
                </div>
                <div class="bg-white p-6 h-48 text-heading-dark rounded-3xl flex flex-col justify-between gap-6">
                    <div class="flex justify-between">
                        <div>
                            <p class="text-sm leading-snug font-normal text-paragraph">
                                Total No. of
                            </p>
                            <h1 class="text-2xl font-semibold leading-6">CURRICULUM</h1>
                        </div>
                        <img src="{{ asset('images/curriculum-icon.png') }}" class="h-6" alt="">
                    </div>
                    <h1 class="text-5xl font-bold text-blue-button">2</h1>
                </div>
            </div>
        </div>
    </div>
    <livewire:quarter-setup-modal :is-open="$shouldOpenModal" />
    <div class="grid grid-cols-2 grid-rows-4 gap-4">
        <div class="col-span-1 row-span-2 h-full bg-white p-6 rounded-3xl flex flex-col gap-4">
            <h1 class="text-2xl font-semibold">Weekly Activities</h1>
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

        <div class="col-span-1 row-span-2 h-full bg-white p-6 rounded-3xl flex flex-col gap-4">
            <h1 class="text-2xl font-semibold">Overall Learning Skills Progress</h1>
            <div id="Piechart" class="w-full" wire:ignore x-data="{}" x-init="() => {
                var options = {
                    series: [44, 55, 13, 43, 22, 43, 22],
                    chart: {
                        width: 460,
                        type: 'pie',
                        toolbar: { show: false }
                    },
                    labels: ['Self-Help', 'Social', 'Numeracy', 'Literacy', 'Motor', 'Pre-Vocational', 'Vocational'],
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

        <div class="col-span-2 row-span-2 h-full bg-white p-6 rounded-3xl flex flex-col gap-4">
            <h1 class="text-2xl font-semibold">Overall Time Spent on Activities</h1>
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
