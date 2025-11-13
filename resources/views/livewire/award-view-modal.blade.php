<div>
    @if ($isOpen)
        <section class="bg-black/40 fixed w-dvw h-dvh p-10 top-0 left-0 z-50 backdrop-blur-xs flex justify-center gap-6">
            <!-- Awards View Info-->
            <div class="w-150 max-h-full Addlesson bg-card py-8 rounded-4xl relative flex">
                <div class="Addlesson w-full h-full flex flex-col px-8 pb-18 gap-8 self-center-safe overflow-y-auto">

                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <img src="{{ asset('images/award-icon.png') }}" alt="" class="h-10">
                            <h1 class=" text-3xl font-bold text-heading-dark">Awards View</h1>
                        </div>
                        <!-- Buttons -->
                    </div>


                    <div class="w-full flex flex-col gap-4 items-center justify-center my-10">
                        <img src="{{ asset('storage/' . $award->path) }}" alt="" class="h-50">
                        <h1 class="text-5xl font-bold text-center w-80%">{{ $award->name }}</h1>
                    </div>

                    <div class="w-full flex flex-col gap-4 mb-4">
                        <h2 class="text-xl font-semibold">Description</h2>
                        <p class=" text-justify text-paragraph">{{ $award->description }}</p>
                    </div>

                    <div class="w-full flex flex-col gap-4">
                        <div class="w-full flex items-center gap-4 justify-between text-xl ">
                            <h2 class="text-xl font-semibold">Awardees:</h2>
                            <p class="text-paragraph px-4 border-b-2 border-gray-300">{{ $award->awardees_count }} </p>
                        </div>

                        <!-- student list of awardees -->
                        <div class="w-full h-full grid grid-cols-2 gap-4 ">
                            <!-- Student name tag -->
                            @forelse ($award->students as $student)
                                <div
                                    class="w-full col-span-1 bg-white p-8 text-center flex flex-col items-center justify-center rounded-2xl">
                                    <img src="{{ asset('storage/' . $student->path) }}" class="h-16 mb-2 rounded-full"
                                        alt="">
                                    <p class="font-semibold text-lg">{{ $student->full_name }}</p>
                                </div>
                            @empty
                                <div
                                    class="w-full h-full col-span-2 bg-white p-4 text-center flex flex-col justify-center items-center rounded-2xl text-paragraph ">
                                    <p class="font-medium text-lg">No students have received this award yet.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>


                    <div
                        class="flex items-center gap-2 absolute w-full left-0 bottom-0 px-8 pb-8 pt-4  rounded-b-4xl bg-card">
                        <button type="button" wire:click='closeModal()'
                            class=" bg-white py-1.5 px-3 w-full rounded-xl text-heading-dark font-medium cursor-pointer hover:bg-gray-300">Cancel</button>
                        <button type="submit"
                            class="bg-blue-button py-1.5 px-3 w-full rounded-xl text-white font-medium cursor-pointer hover:bg-blue-700">Print</button>
                    </div>
                </div>
            </div><!--End of Awards View Info-->


        </section>>
    @endif
</div>
