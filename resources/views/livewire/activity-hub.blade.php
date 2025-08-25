<div>
    @if ($isOpen)
        <section
            class="bg-black/30 fixed w-dvw h-dvh p-10 top-0 left-0 z-50 backdrop-blur-xs flex justify-center items-center gap-6">
            <div class="flex flex-col w-[50%] h-full gap-4 bg-white shadow-2xl rounded-4xl p-8">
                <button type="button" class="cursor-pointer w-full flex items-center justify-between"
                    wire:click='closeModal'>
                    <p class="font-semibold text-2xl">Activity Hub</p>
                    <span class="material-symbols-rounded">close</span>
                </button>

                <div class="w-full flex flex-col gap-2">
                    <h1 class="text-lg font-medium">Activity Categories:</h1>
                    <!--Categories-->
                    <div class="w-full flex items-center gap-2 gameCategories overflow-x-auto pb-2">
                        @php
                            $categories = [
                                'autism spectrum disorder' => 'Autism Spectrum Disorder',
                                'hearing impairment' => 'Hearing Impairment',
                                'speech disorder' => 'Speech Disorder',
                            ];
                        @endphp

                        @foreach ($categories as $slug => $label)
                            <div wire:click="toggleCategory('{{ $slug }}')"
                                class="w-fit shrink-0 flex items-center gap-2 px-3 py-1 rounded-xl cursor-pointer
                                {{ in_array($slug, $selectedCategories, true) ? 'bg-blue-button text-white' : 'bg-card hover:bg-blue-button hover:text-white' }}">
                                <img src="{{ asset('images/game-icons/game-categories-icons/arts.png') }}"
                                    alt="" class="h-6">
                                <p class="text-base">{{ $label }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2 overflow-y-auto rounded-xl gamesGrid">
                    <!--Game container at game hub-->
                    @foreach ($activities as $activity)
                        <div class="w-fit shrink-0 flex flex-col gap-2 relative cursor-pointer">
                            <img src="{{ asset('images/game-icons/game-posters/mario-kart-world-review-1.jpg') }}"
                                class="aspect-video w-auto h-fit rounded-xl object-cover" />

                            <div
                                class="absolute bottom-0 bg-gradient-to-t from-black/80 via-black/10 to-black/0 w-full h-full rounded-xl items-center">
                                <div class="h-full w-full flex items-end justify-between p-3">
                                    <div class="flex items-center w-full justify-between">
                                        <div class="w-full flex items-center gap-2">
                                            <img src="{{ asset('images/game-icons/mario.jpeg') }}" alt=""
                                                class="h-10 rounded-lg aspect-square object-cover">
                                            <div class="flex flex-col">
                                                <h1 class="text-white font-medium text-sm truncate">
                                                    {{ $activity->name }}
                                                </h1>
                                                <p class="text-white/60 text-xs truncate font-light w-46">
                                                    {{ $activity->description }}</p>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-2">
                                            <button type="button" wire:click="viewActivity({{ $activity->id }})"
                                                class="cursor-pointer bg-white/40 backdrop-blur-sm px-3 py-1 rounded-full p-0 flex items-center justify-center text-white hover:bg-blue-button hover:scale-110">
                                                <p class="text-sm">View</p>
                                            </button>
                                            <button type="button" wire:click="addActivity({{ $activity->id }})"
                                                class="cursor-pointer bg-white/40 backdrop-blur-sm px-3 py-1 rounded-full p-0 flex items-center justify-center text-white hover:bg-blue-button hover:scale-110">
                                                <p class="text-sm">Add</p>
                                            </button>
                                        </div>


                                    </div>

                                </div>
                            </div>
                        </div><!--End Game container at game hub-->
                    @endforeach
                </div>
            </div>

            @if ($activity && $isOpenActivityView)
                <div
                    class="flex flex-col w-[30%] h-full bg-white shadow-2xl overflow-y-auto gamesGrid rounded-4xl relative">
                    <div class="w-full flex items-center justify-between p-8 absolute top-0 left-0 z-10 text-white">
                        <p class="font-semibold text-2xl">Activity Info</p>
                        <button class="cursor-pointer" type="button" wire:click="closeActivityView">
                            <span class="material-symbols-rounded">close</span>
                        </button>
                    </div>

                    <div class="relative">
                        <img src="{{ asset('images/game-icons/game-posters/mario-kart-world-review-1.jpg') }}"
                            alt="" class=" aspect-[3/1.2] object-cover rounded-t-4xl">
                        <div
                            class="absolute bottom-0 bg-gradient-to-b from-black/80 via-black/0 to-black/0 w-full h-full rounded-t-4xl items-center">
                        </div>
                    </div>

                    <div class="w-full p-8 flex flex-col gap-8">
                        <div class="flex items-start gap-4">
                            <img src="{{ asset('images/game-icons/mario.jpeg') }}" alt=""
                                class="h-20 aspect-square object-cover rounded-3xl">
                            <div>
                                <h1 class="font-semibold text-2xl w-full leading-7">{{ $act->name }}</h1>
                                <p class="text-sm text-paragraph w-full">
                                    {{ collect($act->category ?? [])->map(fn($cat) => ucwords($cat))->implode(', ') }}
                                </p>
                            </div>
                        </div>

                        <div class="flex flex-col gap-2">
                            <h1 class="text-xl font-semibold">Preview:</h1>
                            <div class="grid grid-cols-3 grid-rows-3 gap-1">
                                <img src="{{ asset('images/game-icons/game-posters/mario-kart-world-review-1.jpg') }}"
                                    alt="" class="w-full rounded-lg col-span-2 row-span-2">
                                <img src="{{ asset('images/game-icons/game-posters/mario-kart-world-review-1.jpg') }}"
                                    alt="" class="w-full rounded-lg col-span-1 row-span-1">
                                <img src="{{ asset('images/game-icons/game-posters/mario-kart-world-review-1.jpg') }}"
                                    alt="" class="w-full rounded-lg col-span-1 row-span-1">
                                <img src="{{ asset('images/game-icons/game-posters/mario-kart-world-review-1.jpg') }}"
                                    alt="" class="w-full rounded-lg col-span-1 row-span-1">
                                <img src="{{ asset('images/game-icons/game-posters/mario-kart-world-review-1.jpg') }}"
                                    alt="" class="w-full rounded-lg col-span-1 row-span-1">
                                <img src="{{ asset('images/game-icons/game-posters/mario-kart-world-review-1.jpg') }}"
                                    alt="" class="w-full rounded-lg col-span-1 row-span-1">
                            </div>
                        </div>

                        <div class="flex flex-col gap-2">
                            <h1 class="text-xl font-semibold">Description</h1>
                            <p class="text-sm text-paragraph">{{ $act->description }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </section>
    @endif
</div>
