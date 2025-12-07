<!-- Aside -->
<aside class="col-span-2 grid grid-cols-1 grid-rows-2 pl-4 pr-4 py-4 gap-4 h-dvh">

    <!-- System Feed -->
    <div class="row-span-2 bg-white w-full h-full rounded-3xl px-3 pt-3 pb-6 flex flex-col shadow-2xl/5">
        <div class="flex gap-2 items-center p-3">
            <img src="{{ asset('images/system-feed.png') }}" class="h-6" alt="">
            <h1 class="text-2xl font-bold">Pending Approval</h1>
        </div>

        <!-- System Notifications -->
        <div class="flex flex-col gap-2 px-3 overflow-y-auto">

            <div class="flex flex-col gap-4 w-full bg-card p-4 rounded-3xl">
                <div class="flex items-center gap-2">
                    <img src="{{ asset('images/_storage/default_profiles/default-male-teacher-pfp.png') }}"
                        class="h-8 w-8 rounded-full" alt="">
                    <h1 class="font-semibold text-lg">Teacher's Name</h1>
                </div>
                <h2 class="leading-tight text-md line-clamp-3">
                    Ms. "Teacher Name" has requested to transfer "Student name" to this class
                </h2>
                <div class="flex items-center gap-2">
                    <button type="button"
                        class="bg-white py-1.5 px-3 w-full rounded-xl text-heading-dark font-medium hover:bg-gray-300 cursor-pointer">
                        Decline
                    </button>
                    <button type="button"
                        class="bg-blue-button py-1.5 px-3 w-full rounded-xl text-white font-medium hover:bg-blue-700 cursor-pointer">
                        Approve
                    </button>
                </div>
                {{-- <p class="text-sm leading-tight text-paragraph">
                    Dec 20 2003</p> --}}
            </div>

            <div class="flex flex-col gap-4 w-full bg-card p-4 rounded-3xl">
                <div class="w-full flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('images/_storage/default_profiles/default-male-teacher-pfp.png') }}"
                            class="h-8 w-8 rounded-full" alt="">
                        <h1 class="font-semibold text-lg">Teacher's Name</h1>
                    </div>
                    <div class="flex items-center bg-[#D2FBD0] text-[#0D5F07] pr-2 pl-1 rounded-full">
                        <span class="material-symbols-rounded">
                            check_small
                        </span>
                        <p class="text-xs">approved</p>
                    </div>
                </div>
                <h2 class="leading-tight text-md line-clamp-3">
                    Ms. "Teacher Name" has requested to transfer "Student name" to this class
                </h2>
                {{-- <div class="flex items-center gap-2">
                    <button type="button"
                        class="bg-white py-1.5 px-3 w-full rounded-xl text-heading-dark font-medium hover:bg-gray-300 cursor-pointer">
                        Decline
                    </button>
                    <button type="button"
                        class="bg-blue-button py-1.5 px-3 w-full rounded-xl text-white font-medium hover:bg-blue-700 cursor-pointer">
                        Approve
                    </button>
                </div> --}}
                <p class="text-sm leading-tight text-paragraph">
                    Dec 20 2003</p>
            </div>
            <div class="flex flex-col gap-4 w-full bg-card p-4 rounded-3xl">
                <div class="w-full flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('images/_storage/default_profiles/default-male-teacher-pfp.png') }}"
                            class="h-8 w-8 rounded-full" alt="">
                        <h1 class="font-semibold text-lg">Teacher's Name</h1>
                    </div>
                    <div class="flex items-center bg-[#fce4e4] text-[#af0000] pr-2 pl-1 rounded-full">
                        <span class="material-symbols-rounded">
                            close_small
                        </span>
                        <p class="text-xs">declined</p>
                    </div>
                </div>
                <h2 class="leading-tight text-md line-clamp-3">
                    Ms. "Teacher Name" has requested to transfer "Student name" to this class
                </h2>
                {{-- <div class="flex items-center gap-2">
                    <button type="button"
                        class="bg-white py-1.5 px-3 w-full rounded-xl text-heading-dark font-medium hover:bg-gray-300 cursor-pointer">
                        Decline
                    </button>
                    <button type="button"
                        class="bg-blue-button py-1.5 px-3 w-full rounded-xl text-white font-medium hover:bg-blue-700 cursor-pointer">
                        Approve
                    </button>
                </div> --}}
                <p class="text-sm leading-tight text-paragraph">
                    Dec 20 2003</p>
            </div>
            {{-- @empty
                <div class="h-full w-full text-center py-[100%]">
                    <p class="text-paragraph">No System Feed yet.</p>
                </div>
            @endforelse --}}
        </div>
    </div>
</aside>
