<div>
    @if ($isOpen)
        <section class="bg-black/30 fixed w-dvw h-dvh p-10 top-0 left-0 z-50 backdrop-blur-xs flex justify-center gap-6">
            <!-- Activity View Info-->
            <div class="w-200 h-full Addlesson bg-card p-8 rounded-4xl relative flex">
                <div class="Addlesson w-full h-full flex flex-col  gap-4 self-center-safe overflow-y-auto">
                    <div class="w-full flex items-center justify-between">
                        <div class="flex items-start gap-2">
                            <img src="{{ asset('images/activity-icon.png') }}" class="h-8" alt="" />
                            <h1 class="text-3xl font-bold text-heading-dark">
                                Activity name.
                            </h1>
                        </div>

                        <div class="flex items-center gap-2">
                            <button type="button" wire:click='closeModal'
                                class="bg-white profile-button flex items-center p-2 rounded-full gap-2 shadow-2xl text-paragraph cursor-pointer hover:text-white hover:bg-blue-button hover:shadow-xl/35 hover:shadow-blue-button">
                                <span class="material-symbols-rounded">close</span>
                            </button>
                        </div>
                    </div>


                    <div class="grid grid-cols-3 gap-4">
                        <div
                            class="bg-gradient-to-tr h-48 col-span-1 from-blue-button to-[#00EEFF] shadow-blue-button shadow-2xl/45 p-6 text-white rounded-3xl flex flex-col justify-between gap-6">
                            <div class="flex justify-between">
                                <div>
                                    <p class="text-xs leading-snug font-normal">No. of Students</p>
                                    <h1 class="text-lg font-semibold leading-6">Assigned</h1>
                                </div>
                                <span class="material-symbols-rounded icon">people</span>
                            </div>
                            <h1 class="text-5xl font-bold">30</h1>
                        </div>

                        <div
                            class="bg-white p-6 rounded-3xl w-full flex flex-col justify-between shadow-2xl/10 col-span-2">
                            <div class="flex items-center w-auto gap-4">
                                <h3 class="text-sm font-semibold w-40">Subject:</h3>
                                <p class="text-sm w-full">
                                    Mathematics
                                </p>
                            </div>

                            <div class="flex items-center w-auto gap-4">
                                <h3 class="text-sm font-semibold w-40">Curriculum:</h3>
                                <p class="text-sm w-full">
                                    Test Curriculum
                            </div>

                            <div class="flex items-center w-auto gap-4">
                                <h3 class="text-sm font-semibold w-40">Grade level:</h3>
                                <p class="text-sm w-full">
                                    Kindergarten 2</p>
                            </div>

                            <div class="flex items-center w-auto gap-4">
                                <h3 class="text-sm font-semibold w-40">No. of Videos:</h3>
                                <p class="text-sm w-full">2</p>
                            </div>

                            <div class="flex items-center w-auto gap-4">
                                <h3 class="text-sm font-semibold w-40">No. of Activity:</h3>
                                <p class="text-sm w-full">4</p>
                            </div>
                        </div>
                        <div class="col-span-3 flex flex-col gap-2 bg-white p-6 rounded-2xl">
                            <h1 class="text-lg font-semibold">Description</h1>
                            <p class="text-sm text-paragraph text-justify">Lorem ipsum dolor sit amet, consectetur
                                adipisicing elit. Consectetur quibusdam ipsum vitae recusandae perspiciatis nam ab
                                nostrum
                                iure rem doloribus.</p>
                        </div>
                    </div>



                    <div class="flex flex-col bg-white rounded-2xl p-6 gap-4 ">
                        <h1 class="text-2xl font-semibold text-heading-dark">Class Activity Record</h1>
                        <table class="table-auto border-collapse">
                            <thead>
                                <tr>
                                    <th class="text-left font-semibold pb-2 text-lg">Student Name</th>
                                    <th class="text-center font-semibold pb-2 text-lg">
                                        Attempt
                                    </th>
                                    <th class="text-center font-semibold pb-2 text-lg">
                                        Time
                                    </th>
                                    <th class="text-center font-semibold pb-2 text-lg">Score</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td class="text-left pt-2 text-paragraph">Carl Madrigal</td>
                                    <td class="text-center pt-2 text-paragraph">999</td>
                                    <td class="text-center pt-2 text-paragraph">999</td>
                                    <td class="text-center pt-2 text-paragraph">999</td>
                                </tr>



                                {{-- <tr>
                                        <td colspan="5" class="text-center py-4 text-gray-500">
                                            No lessons found.
                                        </td>
                                    </tr> --}}
                            </tbody>
                        </table>
                    </div>


                </div>
            </div><!-- End of Lesson View Info-->
        </section>
    @endif
</div>
