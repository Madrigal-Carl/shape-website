<div>

    {{-- Image game Preview page --}}
    @if ($isPreviewOpen)
        <section
            class=" bg-black/30 fixed w-dvw h-dvh top-0 left-0 z-50 backdrop-blur-xs flex justify-center items-center gap-6">
            <div class="gamePreview w-full h-full">
                <div class="fixed top-0 left-0 w-full h-full bg-black/70 backdrop-blur-3xl shrink-0 p-10">

                    <button wire:click='closePreview' type="button"
                        class="absolute top-10 right-10 z-10 p-3 rounded-full aspect-square flex items-center justify-center bg-white/10 hover:bg-white/30 cursor-pointer">
                        <span class="material-symbols-rounded scale-x-110 text-gray-400">close</span>
                    </button>
                    <div class="w-full h-full flex flex-col justify-center gap-4 relative">
                        {{-- Image pagination --}}
                        <div class="flex items-center gap-4 justify-between w-full h-full">
                            <button type="button" wire:click="prevImage"
                                class="p-3 rounded-full aspect-square flex items-center justify-center bg-white/10 hover:bg-white/30 cursor-pointer">
                                <span class="material-symbols-rounded scale-x-110 text-gray-400">chevron_backward</span>
                            </button>

                            <div
                                class="w-300 aspect-video object-contain object-center flex items-center justify-center overflow-hidden rounded-2xl">
                                <img src="{{ asset($previewImages[$previewIndex]) }}"
                                    class="h-full object-contain object-center rounded-2xl" alt="">
                            </div>


                            <button type="button" wire:click="nextImage"
                                class="p-3 rounded-full aspect-square flex items-center justify-center bg-white/10 hover:bg-white/30 cursor-pointer">
                                <span class="material-symbols-rounded scale-110 text-gray-400">chevron_forward</span>
                            </button>
                        </div>
                        <div class="flex items-center gap-2 justify-center">
                            @foreach ($previewImages as $i => $path)
                                <img src="{{ asset($path) }}" wire:click="setImage({{ $i }})"
                                    class="w-24 aspect-video object-cover rounded-lg cursor-pointer
                                {{ $i === $previewIndex ? 'opacity-100 ring-2 ring-blue-500' : 'opacity-40 hover:opacity-80' }}">
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    {{-- End Image game Preview page --}}
    @if ($isOpen)
        <section
            class="bg-black/40 fixed w-dvw h-dvh p-10 top-0 left-0 z-30 backdrop-blur-xs flex justify-center items-center gap-6">
            <div class="flex flex-col w-[50%] h-full gap-8 bg-card shadow-2xl rounded-4xl p-8">

                <div class="w-full flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('images/activity-hub-icon.png') }}" class="h-8" alt="">
                        <p class="text-3xl font-bold text-heading-dark">Activity Hub</p>
                    </div>

                    <button type="button"
                        class="profile-button flex items-center p-2 rounded-full gap-2 shadow-2xl text-paragraph cursor-pointer bg-white hover:text-white hover:bg-blue-button hover:shadow-xl/35 hover:shadow-blue-button"
                        wire:click='closeModal'>
                        <span class="material-symbols-rounded ">close</span>
                    </button>
                </div>


                <div class="w-full flex flex-col gap-2">
                    <h1 class="font-semibold text-xl">Specialization:</h1>
                    <!--Categories-->
                    <div class="w-full flex items-center gap-2 gameCategories overflow-x-auto pb-2">
                        @foreach ($specializations as $spec)
                            <div wire:click="toggleSpecialization('{{ $spec->name }}')"
                                class="w-fit shrink-0 flex items-center gap-2 px-4 py-2 rounded-xl cursor-pointer
                                    {{ in_array($spec->name, $selectedSpecializations, true) ? 'bg-blue-button text-white' : 'bg-white hover:bg-blue-button hover:text-white' }}">
                                <img src="{{ asset('images/specialization_icons/' . $spec->icon) }}" alt=""
                                    class="h-6">
                                <p class="text-base">{{ ucwords($spec->name) }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="w-full flex flex-col gap-2">
                    <h1 class="font-semibold text-xl">Subjects:</h1>
                    <!-- Subject Categories-->
                    <div class="w-full flex items-center gap-2 gameCategories overflow-x-auto pb-2">
                        @foreach ($subjects as $subj)
                            <div wire:click="toggleSubject({{ $subj->id }})"
                                class="w-fit shrink-0 flex items-center gap-2 px-4 py-2 rounded-xl cursor-pointer
                                {{ in_array($subj->id, $selectedSubjects ?? []) ? 'bg-blue-button text-white' : 'bg-white hover:bg-blue-button hover:text-white' }}">
                                <img src="{{ asset('images/subject_icons/' . $subj->icon) }}"
                                    alt="{{ $subj->name }}" class="h-6">
                                <p class="text-base">{{ ucwords($subj->name) }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2 overflow-y-auto rounded-xl gamesGrid">
                    <!--Game container at game hub-->
                    @forelse ($activities as $activity)
                        <div class="w-fit shrink-0 flex flex-col gap-2 relative cursor-pointer">
                            <img src="{{ asset($activity->gameImages->first()->path) }}"
                                class="aspect-video w-auto h-fit rounded-xl object-cover" />
                            <div
                                class="absolute bottom-0 bg-gradient-to-t from-black/80 via-black/10 to-black/0 w-full h-full rounded-xl items-center">
                                <div class="h-full w-full flex items-end justify-between p-3">
                                    <div class="flex items-center w-full justify-between">
                                        <div class="w-full flex items-center gap-2">
                                            <img src="{{ asset($activity->path) }}" alt=""
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
                                                class="cursor-pointer bg-white/40 backdrop-blur-sm px-3 py-1 rounded-full p-0 flex items-center justify-center text-white hover:bg-yellowOrange hover:scale-110">
                                                <p class="text-sm">Add</p>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-2 flex flex-col items-center justify-center py-10">
                            <p class="text-gray-400 text-sm">No activities found</p>
                        </div>
                    @endforelse
                </div>
            </div>

            @if ($act && $isOpenActivityView)
                <div
                    class="flex flex-col w-[30%] h-full bg-card shadow-2xl overflow-y-auto gamesGrid rounded-4xl relative">
                    <div class="w-full flex items-center justify-between p-8 absolute top-0 left-0 z-10 text-white">
                        <p class="font-bold text-3xl">Activity Info</p>
                        <button
                            class="profile-button flex items-center p-2 rounded-full gap-2 shadow-2xl text-white cursor-pointer hover:text-white hover:bg-blue-button hover:shadow-xl/35 hover:shadow-blue-button"
                            type="button" wire:click="closeActivityView">
                            <span class="material-symbols-rounded">close</span>
                        </button>
                    </div>

                    <div class="relative">
                        <img src="{{ asset($act->gameImages->first()->path) }}" alt=""
                            class=" aspect-[3/1.2] object-cover rounded-t-4xl">
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
                                    @foreach ($act->specializations as $specialization)
                                        {{ ucwords($specialization->name) }}@if (!$loop->last)
                                            ,
                                        @endif
                                    @endforeach
                                </p>
                            </div>
                        </div>

                        <div class="flex flex-col gap-2">
                            <h1 class="text-xl font-semibold">Preview:</h1>
                            <div class="flex items-center gap-2 overflow-x-scroll overflow-y-hidden pb-4">
                                <img src="{{ asset('images/game-previews/Cast a spell - FSL.png') }}" alt=""
                                    class="w-45 rounded-3xl col-span-2 row-span-2 cursor-pointer">
                                <img src="{{ asset('images/game-previews/Cast a spell - FSL.png') }}" alt=""
                                    class="w-45 rounded-3xl col-span-2 row-span-2 cursor-pointer">
                                <img src="{{ asset('images/game-previews/Cast a spell - FSL.png') }}" alt=""
                                    class="w-45 rounded-3xl col-span-2 row-span-2 cursor-pointer">
                                <img src="{{ asset('images/game-previews/Cast a spell - FSL.png') }}" alt=""
                                    class="w-45 rounded-3xl col-span-2 row-span-2 cursor-pointer">
                                <img src="{{ asset('images/game-previews/Cast a spell - FSL.png') }}" alt=""
                                    class="w-45 rounded-3xl col-span-2 row-span-2 cursor-pointer">
                            </div>
                        </div>
                        <div class="flex flex-col gap-2">
                            <h1 class="text-xl font-semibold">Description</h1>
                            <p class="text-sm text-paragraph">{{ $act->description }}</p>
                            <ul class=" list-disc pl-8">
                                <li class="text-sm ">Todo 1: Identifies the sounds of the letters of the
                                    alphabet.</li>
                                <li class="text-sm ">Todo 1: Identifies the sounds of the letters of the
                                    alphabet.</li>
                                <li class="text-sm ">Todo 1: Identifies the sounds of the letters of the
                                    alphabet.</li>
                                <li class="text-sm ">Todo 1: Identifies the sounds of the letters of the
                                    alphabet.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
        </section>
    @endif
</div>
