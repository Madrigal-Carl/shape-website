<main class="col-span-5 pl-8 pr-4 py-4 flex flex-col h-dvh gap-12 overflow-y-auto">
    <!-- Greetings -->
    <div class="flex gap-2 mt-4 w-auto justify-between">
        <div class="flex gap-4">
            <span class="w-2 h-full bg-blue-button rounded-full"></span>
            <div class="flex flex-col gap-1">
                <h1 class="text-2xl font-semibold leading-tight">
                    Welcome back, {{ auth()->user()->accountable->sex == 'male' ? 'Sir' : 'Ma\'am' }}
                    <span class="font-bold text-blue-button">
                        {{ auth()->user()->accountable->first_name }}</span>
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
                            <option value="{{ $sy->id }}">
                                S.Y {{ $sy->name }}
                            </option>
                        @endforeach

                    </select>
                </div>
            </div>
        </div>

        <!-- Buttons -->

        <livewire:award-view-modal />
    </div>

    <!-- Award inventory -->
    <div class="flex flex-col gap-4">
        <div class="side flex items-center justify-between gap-2 mb-2">
            <h1 class="text-4xl font-bold">Awards Inventory</h1>

            <div class="flex items-center">
                <div
                    class="flex items-center bg-white py-3 px-5 rounded-full border-2 border-white hover:border-blue-button text-paragraph hover:bg-blue-button hover:text-white cursor-pointer">
                    <select name="" id="" class="w-max outline-none" wire:model.live="grade_level">
                        <option value="" class=" text-heading-dark" disabled>
                            Grade Level
                        </option>
                        <option value="all" class=" text-heading-dark">
                            All
                        </option>
                        @foreach ($grade_levels as $grade)
                            <option value="{{ $grade }}" class=" text-heading-dark">
                                {{ ucwords($grade) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

        </div>

        <!-- Award Grid -->
        <div class="w-full grid grid-cols-3 gap-4">
            @foreach ($awards as $award)
                <div
                    class="max-w-100 h-109.5 flex flex-col justify-between gap-8 items-center bg-[radial-gradient(circle_at_center,_#93CEF5,_#006FDF)] p-4 rounded-3xl ">
                    <div class="flex flex-col items-center gap-2 pt-8">
                        <img src="{{ asset('images/Awards_icons/medal.png') }}" alt="" class="h-48 mb-4">
                        <p class="font-bold text-3xl text-white w-full text-center">{{ $award->name }}</p>
                        <div class="flex items-center w-full justify-center gap-4 text-white/80">
                            <p class="text-base">Total Awardees:</p>
                            <p class="text-base">{{ $award->awardees_count }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 w-full">
                        <button type="button"
                            class="w-full flex items-center justify-center gap-1 px-3 py-2 bg-white rounded-xl text-paragraph hover:bg-gray-300 cursor-pointer">
                            <span class="material-symbols-rounded award-icon">print</span>
                            <p class="text-sm">Print</p>
                        </button>
                        <button wire:click='openViewAwardModal({{ $award->id }})'
                            class="cursor-pointer w-full flex items-center justify-center gap-1 px-3 py-2 bg-yellowOrange hover:bg-amber-500 rounded-xl text-white relative">

                            <span class="material-symbols-rounded award-icon transition-opacity duration-150"
                                wire:loading.class="opacity-0" wire:target='openViewAwardModal({{ $award->id }})'>
                                visibility
                            </span>
                            <p class="text-sm transition-opacity duration-150" wire:loading.class="opacity-0"
                                wire:target='openViewAwardModal({{ $award->id }})'>
                                View
                            </p>

                            <svg wire:loading wire:target='openViewAwardModal({{ $award->id }})'
                                class="w-4 h-4 text-white animate-spin absolute" viewBox="0 0 100 101" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                    fill="currentColor" />
                                <path
                                    d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                    fill="currentFill" />
                            </svg>
                        </button>

                    </div>
                </div>
            @endforeach
        </div>
    </div>
</main>
