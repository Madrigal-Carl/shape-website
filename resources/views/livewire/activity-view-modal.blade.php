<div>
    @if ($isOpen)
        <section class="bg-black/40 fixed w-dvw h-dvh p-10 top-0 left-0 z-50 backdrop-blur-xs flex justify-center gap-6">

            <div class="w-200 h-full Addlesson bg-card p-8 rounded-4xl relative flex">
                <div class="Addlesson w-full h-full flex flex-col  gap-4 self-center-safe overflow-y-auto">
                    <div class="w-full flex items-center justify-between">
                        <div class="flex items-start gap-2">
                            <img src="{{ asset('images/activity-icon.png') }}" class="h-8" alt="" />
                            <h1 class="text-3xl font-bold text-heading-dark">
                                {{ $activity->name }}
                            </h1>
                        </div>

                        <div class="flex items-center gap-2">
                            <button type="button" wire:click='closeModal'
                                class="bg-white profile-button flex items-center p-2 rounded-full gap-2 text-paragraph cursor-pointer hover:text-white hover:bg-blue-button">
                                <span class="material-symbols-rounded">close</span>
                            </button>
                        </div>
                    </div>


                    <div class="grid grid-cols-3 gap-4">
                        <div
                            class="bg-gradient-to-tr h-48 col-span-1 from-blue-button to-[#00EEFF] p-6 text-white rounded-3xl flex flex-col justify-between gap-6">
                            <div class="flex justify-between">
                                <div>
                                    <p class=" leading-snug font-normal">No. of Students</p>
                                    <h1 class="text-2xl font-semibold leading-6">Assigned</h1>
                                </div>
                                <span class="material-symbols-rounded icon">people</span>
                            </div>
                            <h1 class="text-5xl font-bold">{{ $activity->student_activities_count }}</h1>
                        </div>

                        <div class="bg-white p-6 rounded-3xl w-full flex flex-col justify-start gap-4 col-span-2">
                            <div class="flex items-center w-auto gap-4">
                                <h3 class="text-sm font-semibold w-40">Subject:</h3>
                                <p class="text-sm w-full">
                                    {{ ucwords($activity->curriculumSubject->subject->name) }}
                                </p>
                            </div>

                            <div class="flex items-center w-auto gap-4">
                                <h3 class="text-sm font-semibold w-40">Curriculum:</h3>
                                <p class="text-sm w-full">
                                    {{ ucwords($activity->curriculumSubject->curriculum->name) }}
                            </div>


                        </div>
                        @if (!empty($activity->description))
                            <div class="col-span-3 flex flex-col gap-2 bg-white p-6 rounded-2xl">
                                <h1 class="text-lg font-semibold">Description</h1>
                                <p class="text-sm text-paragraph text-justify">{{ $activity->description }}</p>
                            </div>
                        @endif
                    </div>


                    <div class="flex flex-col bg-white rounded-2xl p-6 gap-4 ">
                        <h1 class="text-2xl font-semibold text-heading-dark">Class Activity Record</h1>
                        <div class="grid grid-cols-2 gap-4">
                            @foreach ($studentsData as $stud)
                                <div
                                    class="flex flex-col gap-4 items-center bg-white rounded-3xl hover:bg-gray-300 cursor-pointer">
                                    <div
                                        class="flex gap-2 items-start justify-between w-full transition-all p-4 duration-200">
                                        <div class="flex gap-2 items-center w-full">
                                            <img src="{{ asset('storage/' . $stud['path']) }}"
                                                class="w-12 h-12 aspect-square object-cover rounded-full"
                                                alt="" />
                                            <div class="flex flex-col">
                                                <p class="text-lg font-semibold">
                                                    {{ $stud['fullname'] }}
                                                </p>
                                                <small class="leading-none text-paragraph">
                                                    {{ ucwords($stud['disability_type']) }}
                                                </small>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-6">
                                            <div class="flex items-center gap-2">
                                                <label class="container w-fit">
                                                    <input type="checkbox" disabled
                                                        {{ $stud['status'] === 'finished' ? 'checked' : '' }}>
                                                    <div class="checkmark"></div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
        </section>
    @endif
</div>
