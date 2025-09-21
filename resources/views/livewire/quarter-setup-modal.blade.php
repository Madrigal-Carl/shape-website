<div>
    @if ($isOpen)
        <section
            class="bg-black/40 fixed w-dvw h-dvh top-0 left-0 z-50 backdrop-blur-xs flex justify-center items-center overflow-y-auto p-10">
            <!-- first form -->
            <div
                class="bg-card/80 backdrop-blur-md shadow-2xl border-2 border-white/60 p-8 rounded-4xl w-220 flex flex-col gap-8">
                <div class="w-full flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('images/calendar.png') }}" class="h-8" alt="" />
                        <h1 class="text-3xl font-bold text-heading-dark">
                            Set Quarters
                        </h1>
                    </div>
                    <div class="flex items-center gap-2 bg-white px-4 py-2 rounded-lg">
                        <span class="material-symbols-rounded">today</span>
                        <p class="font-semibold">
                            S.Y {{ $first_quarter_start ? \Carbon\Carbon::parse($first_quarter_start)->year : '----' }}
                            -
                            {{ $fourth_quarter_end ? \Carbon\Carbon::parse($fourth_quarter_end)->year : '----' }}
                        </p>
                    </div>


                </div>

                <div class="grid grid-cols-2 gap-4">
                    {{-- First Quarter --}}
                    <div class="flex items-center w-full gap-4 bg-white p-4 rounded-3xl ">
                        <div
                            class="flex flex-col items-center justify-center rounded-2xl p-4 aspect-square  h-42 text-white bg-gradient-to-tr from-blue-button to-[#00EEFF] shadow-blue-button shadow-xl/35">
                            <h1 class="text-6xl font-bold text-shadow-blue-button/60 text-shadow-lg">
                                1st</h1>
                            <p class="text-lg">Quarter</p>
                        </div>

                        {{-- inputs --}}
                        <div class="w-full flex flex-col gap-2">
                            {{-- Start --}}
                            <div class="w-full">
                                <label for="" class="font-semibold text-lg">Start</label>
                                <input type="text" wire:model.live="first_quarter_start"
                                    class="px-4 py-2 rounded-lg bg-card placeholder-paragraph outline-none w-full text-paragraph"
                                    onfocus="this.type='date'" onblur="if(!this.value) this.type='text'" />
                            </div>

                            {{-- End --}}
                            <div>
                                <label for="" class="font-semibold text-lg">End</label>
                                <input type="text" wire:model.live="first_quarter_end"
                                    class="px-4 py-2 rounded-lg bg-card placeholder-paragraph outline-none w-full text-paragraph"
                                    onfocus="this.type='date'" onblur="if(!this.value) this.type='text'" />
                            </div>
                        </div>
                    </div>

                    {{-- Second Quarter --}}
                    <div class="flex items-center w-full gap-4 bg-white p-4 rounded-3xl ">
                        <div
                            class="flex flex-col items-center justify-center rounded-2xl p-4 aspect-square  h-42 text-white bg-gradient-to-tr from-lime to-[#00ff80] shadow-lime shadow-xl/35">
                            <h1 class="text-6xl font-bold text-shadow-lime/60 text-shadow-lg ">
                                2nd</h1>
                            <p class="text-lg">Quarter</p>
                        </div>

                        {{-- inputs --}}
                        <div class="w-full flex flex-col gap-2">
                            {{-- Start --}}
                            <div class="w-full">
                                <label for="" class="font-semibold text-lg">Start</label>
                                <input type="text" wire:model.live="second_quarter_start"
                                    class="px-4 py-2 rounded-lg bg-card placeholder-paragraph outline-none w-full text-paragraph"
                                    onfocus="this.type='date'" onblur="if(!this.value) this.type='text'" />
                            </div>

                            {{-- End --}}
                            <div>
                                <label for="" class="font-semibold text-lg">End</label>
                                <input type="text" wire:model.live="second_quarter_end"
                                    class="px-4 py-2 rounded-lg bg-card placeholder-paragraph outline-none w-full text-paragraph"
                                    onfocus="this.type='date'" onblur="if(!this.value) this.type='text'" />
                            </div>
                        </div>
                    </div>



                    {{-- Third Quarters --}}
                    <div class="flex items-center w-full gap-4 bg-white p-4 rounded-3xl ">
                        <div
                            class="flex flex-col items-center justify-center rounded-2xl p-4 aspect-square  h-42 text-white bg-gradient-to-tr from-yellowOrange to-[#FFEA00] shadow-yellowOrange shadow-xl/35">
                            <h1 class="text-6xl font-bold text-shadow-yellowOrange/60 text-shadow-lg">
                                3rd</h1>
                            <p class="text-lg">Quarter</p>
                        </div>

                        {{-- inputs --}}
                        <div class="w-full flex flex-col gap-2">
                            {{-- Start --}}
                            <div class="w-full">
                                <label for="" class="font-semibold text-lg">Start</label>
                                <input type="text" wire:model.live="third_quarter_start"
                                    class="px-4 py-2 rounded-lg bg-card placeholder-paragraph outline-none w-full text-paragraph"
                                    onfocus="this.type='date'" onblur="if(!this.value) this.type='text'" />
                            </div>

                            {{-- End --}}
                            <div>
                                <label for="" class="font-semibold text-lg">End</label>
                                <input type="text" wire:model.live="third_quarter_end"
                                    class="px-4 py-2 rounded-lg bg-card placeholder-paragraph outline-none w-full text-paragraph"
                                    onfocus="this.type='date'" onblur="if(!this.value) this.type='text'" />
                            </div>
                        </div>
                    </div>



                    {{-- fourth Quarters --}}
                    <div class="flex items-center w-full gap-4 bg-white p-4 rounded-3xl ">
                        <div
                            class="flex flex-col items-center justify-center rounded-2xl p-4 aspect-square  h-42 text-white bg-gradient-to-tr from-danger to-[#ff00aa] shadow-danger shadow-xl/35">
                            <h1 class="text-6xl font-bold text-shadow-danger/60 text-shadow-lg">
                                4th</h1>
                            <p class="text-lg">Quarter</p>
                        </div>

                        {{-- inputs --}}
                        <div class="w-full flex flex-col gap-2">
                            {{-- Start --}}
                            <div class="w-full">
                                <label for="" class="font-semibold text-lg">Start</label>
                                <input type="text" wire:model.live="fourth_quarter_start"
                                    class="px-4 py-2 rounded-lg bg-card placeholder-paragraph outline-none w-full text-paragraph"
                                    onfocus="this.type='date'" onblur="if(!this.value) this.type='text'" />
                            </div>

                            {{-- End --}}
                            <div>
                                <label for="" class="font-semibold text-lg">End</label>
                                <input type="text" wire:model.live.live="fourth_quarter_end"
                                    class="px-4 py-2 rounded-lg bg-card placeholder-paragraph outline-none w-full text-paragraph"
                                    onfocus="this.type='date'" onblur="if(!this.value) this.type='text'" />
                            </div>
                        </div>
                    </div>

                </div>





                <!-- buttons -->
                <div class="flex items-center gap-2">
                    <button type="button"
                        class="bg-white py-1.5 px-4 w-full rounded-xl text-heading-dark font-medium hover:bg-gray-100 cursor-pointer"
                        wire:click="closeModal" type="button">
                        Cancel
                    </button>
                    <button type="button"
                        class="bg-blue-button py-1.5 px-4 w-full rounded-xl text-white font-medium hover:bg-blue-700 cursor-pointer"
                        wire:click="saveQuarters">
                        Save
                    </button>
                </div>
            </div>
            <!-- End of first form -->
    @endif
</div>
