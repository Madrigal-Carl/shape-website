<div>
    @if ($isOpen)
        <div
            class="bg-black/40 fixed w-dvw h-dvh top-0 left-0 z-50 backdrop-blur-xs flex justify-center items-center p-10">
            <!-- Add lesson container -->
            <div class="flex h-full justify-center gap-6">
                <div class="w-180 h-full Addlesson bg-card p-8 rounded-4xl relative">
                    <!-- first form -->
                    <div class="Addlesson w-full h-[100%] flex flex-col gap-8 self-center-safe overflow-y-auto">
                        <div class="flex items-center gap-2">
                            <img src="{{ asset('images/activity-add-icon.png') }}" class="h-8" alt="" />
                            <h1 class="text-3xl font-bold text-heading-dark">
                                Add Activity
                            </h1>
                        </div>

                        <div class="flex flex-col gap-3">
                            <h2 class="font-semibold text-xl ">Activity Information</h2>
                            <div class="flex flex-col gap-2">
                                <input type="text" placeholder="Activity Name" wire:model.live="activity_name"
                                    class="px-4 py-2 rounded-lg bg-white placeholder-paragraph outline-none w-full" />

                                <div class="px-4 py-2 rounded-lg bg-white">
                                    <select wire:model.live="grade_level" name="" id=""
                                        class="w-full outline-none text-paragraph">
                                        <option value="" class="text-sm text-black" selected disabled>
                                            Grade & Section
                                        </option>
                                        @foreach ($grade_levels as $level)
                                            <option value="{{ $level->id }}" class="text-sm text-paragraph">
                                                {{ ucwords($level->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="flex items-center gap-2 w-full">
                                    <div class="px-4 py-2 rounded-lg bg-white w-full">
                                        <select name="" id="" wire:model.live="curriculum"
                                            wire:key="{{ $grade_level }}" class="w-full outline-none text-paragraph">
                                            <option value="" class="text-sm text-black" selected disabled>
                                                Curriculum
                                            </option>
                                            @foreach ($curriculums as $curriculum)
                                                <option value="{{ $curriculum->id }}" class="text-sm text-paragraph">
                                                    {{ ucwords($curriculum->name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="flex items-center gap-2 w-full">
                                    <div class="px-4 py-2 rounded-lg bg-white w-full">
                                        <select name="" id="" wire:model.live="subject"
                                            wire:key="{{ $curriculum }}" class="w-full outline-none text-paragraph">
                                            <option value="" class="text-sm text-black" selected disabled>
                                                Subject
                                            </option>
                                            @foreach ($subjects as $subject)
                                                <option value="{{ $subject->id }}" class="text-sm text-paragraph">
                                                    {{ ucwords($subject->name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <textarea name="" id="" maxlength="200" placeholder="Description (Optional)"
                                    wire:model.live="description"
                                    class="px-3 py-2 rounded-lg bg-white placeholder-paragraph resize-none h-24 outline-none"></textarea>
                            </div>
                        </div>

                        <div class="flex flex-col gap-3 flex-1 min-h-0">
                            <h2 class="font-semibold text-xl">Domains</h2>
                            {{-- Specilize selected Student --}}
                            <div class=" rounded-lg relative flex flex-col gap-2 flex-1 min-h-0">
                                {{-- Header --}}
                                <div class="flex items-center justify-between w-full">
                                    <p class="text-paragraph">Assign your activity to a domain.</p>
                                </div>

                                {{-- Search --}}
                                <div class="flex items-center gap-2 px-4 py-2 rounded-lg bg-white w-full">
                                    <span class="material-symbols-rounded">person_search</span>
                                    <input type="text" placeholder="Search Domain" wire:model.live="search"
                                        class="w-full outline-none text-heading-dark placeholder-heading-dark" />
                                </div>

                                <div class="flex items-center gap-2 px-4 py-2 rounded-lg bg-white w-full">
                                    <p class="w-full outline-none text-heading-dark placeholder-heading-dark">
                                        {{ count($selectedTodoIds) ? count($selectedTodoIds) . ' Todos Selected' : 'No Todo Selected' }}
                                    </p>
                                </div>

                                <div class="flex-1 min-h-0 flex flex-col gap-1 bg-white rounded-lg p-2">
                                    <div class="flex flex-col gap-1 flex-1 min-h-0 overflow-y-scroll pr-2 rounded-lg">
                                        @forelse($this->filteredDomain as $domain)
                                            <div>
                                                <div wire:click="toggleDomain({{ $domain->id }})"
                                                    class="flex items-center justify-between p-2 cursor-pointer hover:bg-gray-100 rounded-lg">
                                                    <p class="text-paragraph font-semibold">{{ $domain->name }}</p>
                                                    <span>{{ in_array($domain->id, $expandedDomains) ? '−' : '+' }}</span>
                                                </div>

                                                @if (in_array($domain->id, $expandedDomains))
                                                    @if ($domain->subDomains->count())
                                                        @foreach ($domain->subDomains as $subDomain)
                                                            <div class="ml-4">
                                                                <div wire:click="toggleSubDomain({{ $subDomain->id }})"
                                                                    class="flex items-center justify-between p-2 cursor-pointer hover:bg-gray-50 rounded-lg">
                                                                    <p class="text-sm text-paragraph font-medium">
                                                                        {{ $subDomain->name }}</p>
                                                                    <span>{{ in_array($subDomain->id, $expandedSubDomains) ? '−' : '+' }}</span>
                                                                </div>

                                                                @if (in_array($subDomain->id, $expandedSubDomains))
                                                                    @foreach ($subDomain->todos as $todo)
                                                                        <div class="flex items-center gap-2 ml-4 p-1">
                                                                            <label class="container w-fit">
                                                                                <input type="checkbox"
                                                                                    wire:model.live="selectedTodoIds"
                                                                                    value="{{ $todo->id }}">
                                                                                <div class="checkmark"></div>
                                                                            </label>
                                                                            <p class="text-sm text-paragraph">
                                                                                {{ $todo->todo }}
                                                                            </p>
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    @endif

                                                    @if ($domain->todos->count())
                                                        @foreach ($domain->todos as $todo)
                                                            <div class="flex items-center gap-2 ml-4 p-1">
                                                                <label class="container w-fit">
                                                                    <input type="checkbox"
                                                                        wire:model.live="selectedTodoIds"
                                                                        value="{{ $todo->id }}">
                                                                    <div class="checkmark"></div>
                                                                </label>
                                                                <p class="text-sm text-paragraph">{{ $todo->todo }}
                                                                </p>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                @endif
                                            </div>
                                        @empty
                                            <p
                                                class="text-center text-sm text-gray-500 h-full flex justify-center items-center">
                                                No domain found.
                                            </p>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Add lesson container -->

                <div class="w-180 h-full Addlesson bg-card p-8 rounded-4xl relative">
                    <div class="Addlesson w-full h-[100%] flex flex-col pb-14 self-center-safe overflow-y-auto">
                        <div class="flex items-center gap-2 sticky top-0 left-0 w-full bg-card pb-4">
                            <img src="{{ asset('images/activity-record-icon.png') }}" class="h-8" alt="" />
                            <h1 class="text-3xl font-bold text-heading-dark">
                                Class Activity Record
                            </h1>
                        </div>

                        {{-- Students-con --}}
                        <div class="flex flex-col gap-3 h-full">

                            {{-- Per Student container --}}
                            @forelse ($students as $stud)
                                <div
                                    class="flex flex-col gap-4 items-center bg-white rounded-3xl hover:bg-gray-300  cursor-pointer">
                                    {{-- Student profile --}}
                                    <div
                                        class="flex gap-2 items-start justify-between w-full transition-all p-4  duration-200">
                                        <div class="flex gap-2 items-center w-full">
                                            <img src="{{ asset('storage/' . $stud->path) }}"
                                                class="w-12 h-12 aspect-square object-cover rounded-full"
                                                alt="" />
                                            <div class="flex flex-col">
                                                <p class="text-lg font-semibold">
                                                    {{ $stud->fullname }}
                                                </p>
                                                <small class="leading-none text-paragraph">
                                                    {{ ucwords($stud->disability_type) }}
                                                </small>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-6">
                                            <div class="flex items-center gap-2">
                                                <label class="container w-fit">
                                                    <input type="checkbox" wire:model="checkedStudents"
                                                        value="{{ $stud->id }}">
                                                    <div class="checkmark"></div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div
                                    class="flex flex-col items-center justify-center gap-4 py-12 bg-white rounded-2xl shadow-inner h-full">
                                    <h2 class="text-lg font-semibold text-heading-dark">No Students Found</h2>
                                </div>
                            @endforelse

                        </div>
                    </div>

                    <div wire:loading wire:target="addActivity"
                        class="bg-black/10 fixed top-0 left-0 w-dvw h-dvh z-50 flex justify-center items-center backdrop-blur-sm">
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

                    <div
                        class="flex items-center gap-2 absolute w-full left-0 bottom-0 px-8 pb-8 pt-4 rounded-b-4xl bg-card">
                        <button wire:click='closeModal' type="button"
                            class="bg-white py-1.5 px-3 w-full rounded-xl text-heading-dark font-medium hover:bg-gray-300 cursor-pointer">
                            Cancel
                        </button>
                        <button type="button" wire:click='addActivity'
                            class="bg-blue-button py-1.5 px-3 w-full rounded-xl text-white font-medium cursor-pointer hover:bg-blue-700">
                            Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
