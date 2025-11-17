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

            <div wire:loading wire:target="saveQuarters"
                class="bg-black/10 fixed w-dvw h-dvh z-50 flex justify-center items-center backdrop-blur-sm">
                <svg aria-hidden="true"
                    class="w-12 h-12 text-gray-200 animate-spin fill-blue-600 absolute top-1/2 left-[49%]"
                    viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                        fill="currentColor" />
                    <path
                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                        fill="currentFill" />
                </svg>
                <span class="sr-only">Loading...</span>
            </div>
            <!-- End of first form -->
    @endif
</div>
