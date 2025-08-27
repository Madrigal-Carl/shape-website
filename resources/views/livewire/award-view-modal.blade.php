<div>
    @if ($isOpen)
        <section class="bg-black/30 fixed w-dvw h-dvh p-10 top-0 left-0 z-50 backdrop-blur-xs flex justify-center gap-6">
            <!-- Awards View Info-->
            <div class="w-150 max-h-full Addlesson bg-white py-8 rounded-4xl relative flex">
                <div class="Addlesson w-full h-full flex flex-col px-8 pb-18 gap-8 self-center-safe overflow-y-auto">

                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <img src="{{ asset('images/award-icon.png') }}" alt="" class="h-10">
                            <h1 class=" text-2xl font-semibold text-heading-dark">Awards View</h1>
                        </div>
                        <!-- Buttons -->
                    </div>


                    <div class="w-full flex flex-col gap-4 items-center justify-center">
                        <img src="{{ asset('images/Awards_icons/medal.png') }}" alt="" class="h-50">
                        <h1 class="text-5xl font-semibold text-center w-80%">{{ $award->name }}</h1>
                    </div>

                    <div class="w-full flex items-center gap-4 justify-center text-xl text-paragraph">
                        <p class="font-semibold">Total Awardees:</p>
                        <p>{{ $award->awardees_count }}</p>
                    </div>

                    <!-- student list of awardees -->
                    <div class="w-full grid grid-cols-2 gap-2">
                        <!-- Student name tag -->
                        @forelse ($award->students as $student)
                            <div class="w-full bg-card p-2 text-center rounded-2xl">
                                <p class="font-semibold text-lg">{{ $student->full_name }}</p>
                            </div>
                        @empty
                            <div class="w-full bg-card p-4 text-center rounded-2xl text-gray-400">
                                <p class="font-semibold text-lg">No students have received this award yet.</p>
                            </div>
                        @endforelse
                    </div>

                    <div
                        class="flex items-center gap-2 absolute w-full left-0 bottom-0 px-5 pb-5 pt-10  rounded-b-4xl bg-gradient-to-t from-white via-white to-white/50">
                        <button type="button" wire:click='closeModal()'
                            class=" bg-gray-100 py-1.5 px-3 w-full rounded-xl text-heading-dark font-medium">Cancel</button>
                        <button type="submit"
                            class="bg-blue-button py-1.5 px-3 w-full rounded-xl text-white font-medium">Print</button>
                    </div>
                </div>
            </div><!--End of Awards View Info-->


        </section>>
    @endif
</div>
