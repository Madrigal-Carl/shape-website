<main class="col-span-7 px-8 py-4 flex flex-col h-dvh gap-16 overflow-y-none">
    <!-- Greetings -->
    @php
        $user = App\Models\Account::with('accountable')->find(auth()->id());
    @endphp
    <div class="flex gap-2 w-auto justify-between">
        <div class="flex gap-4">
            <span class="w-1 h-full bg-blue-button rounded-full"></span>
            <div>
                <h1 class="text-2xl font-medium">
                    Welcome back,
                    <span class="font-bold text-blue-button">{{ $user->accountable->first_name }}</span>
                </h1>
                <p class="text-sm text-paragraph">Here is your summary today</p>
            </div>
        </div>

        <!-- Buttons -->
        <button wire:click="openAddLessonModal"
            class="relative flex items-center justify-center bg-white py-2 px-5 rounded-full gap-2 shadow-2xl text-paragraph cursor-pointer hover:text-white hover:bg-blue-button hover:shadow-xl/35 hover:shadow-blue-button hover:scale-105"
            wire:loading.attr="disabled" wire:target="openAddLessonModal">

            <!-- Normal state -->
            <div class="flex items-center gap-2" wire:loading.class="invisible" wire:target="openAddLessonModal">
                <span class="material-symbols-rounded">add</span>
                <p class="text-sm">Add New Lesson</p>
            </div>

            <!-- Loading spinner -->
            <div wire:loading wire:target="openAddLessonModal" role="status"
                class="absolute top-[25%] left-[45%] flex items-center justify-center">
                <svg aria-hidden="true" class="w-6 h-6 text-gray-200 animate-spin fill-blue-600" viewBox="0 0 100 101"
                    fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                        fill="currentColor" />
                    <path
                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                        fill="currentFill" />
                </svg>
                <span class="sr-only">Loading...</span>
            </div>
        </button>
    </div>

    <!-- curriculumn Table -->
    <div class="flex flex-col gap-4 min-h-[20%]">
        <div class="side flex items-center justify-between gap-2">
            <h1 class="text-4xl font-medium">Lesson List</h1>
            <div class="flex gap-4">
                <div
                    class="flex items-center bg-white py-3 px-5 rounded-full shadow-2xl text-paragraph hover:bg-blue-button hover:text-white cursor-pointer">
                    <select wire:change="$set('status', $event.target.value)" name="" id=""
                        class="w-25 outline-none">
                        <option value="pending" class="text-sm text-heading-dark" selected disabled>
                            Filter by
                        </option>
                        <option value="all" class="text-sm text-heading-dark">
                            All
                        </option>
                        <option value="active" class="text-sm text-lime">Active</option>
                        <option value="inactive" class="text-sm text-paragraph">
                            Inactive
                        </option>
                    </select>
                    <!-- <span class="material-symbols-rounded">more_horiz</span>
                        <span class="material-symbols-rounded">search</span> -->
                </div>

                <div
                    class="flex gap-2 items-center bg-white py-3 px-5 rounded-full shadow-2xl text-paragraph border-2 border-white hover:border-blue-button cursor-pointer">
                    <span class="material-symbols-rounded">search</span>
                    <input type="text" class="outline-none w-20 focus:w-60 placeholder-paragraph"
                        placeholder="Search">
                </div>
            </div>
        </div>

        <div class="flex flex-col min-h-[20%] p-6 bg-white rounded-3xl">
            <div class="flex flex-col overflow-y-scroll">
                <div class="flex flex-col bg-whitel rounded-3xl bg-white">
                    <table class="table-auto border-separate relative">
                        <thead class="sticky top-0 left-0 z-40 bg-white">
                            <tr>
                                <th class="px-4 pb-3 text-center font-semibold">ID</th>
                                <th class="px-4 pb-3 text-center font-semibold">
                                    Lesson Name
                                </th>
                                <th class="px-4 pb-3 text-center font-semibold">
                                    Curriculum
                                </th>
                                <th class="px-4 pb-3 text-center font-semibold">
                                    Subjects
                                </th>
                                <th class="px-4 pb-3 text-center font-semibold">
                                    Assigned
                                </th>
                                <th class="px-4 pb-3 text-center font-semibold">Videos</th>
                                <th class="px-4 pb-3 text-center font-semibold">Games</th>
                                <th class="px-4 pb-3 text-center font-semibold">Quizzes</th>
                                <th class="px-4 pb-3 text-center font-semibold">Status</th>
                                <th class="px-4 pb-3 text-center font-semibold">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($lessons as $lesson)
                                <tr>
                                    <td class="px-4 py-3 text-center text-paragraph">{{ $lesson->id }}</td>
                                    <td class="px-4 py-3 text-center text-paragraph">{{ ucwords($lesson->title) }}</td>
                                    <td class="px-4 py-3 text-center text-paragraph">
                                        {{ $lesson->lessonSubject->curriculumSubject->curriculum->name }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        {{ ucwords($lesson->lessonSubject->curriculumSubject->subject->name) }}</td>
                                    <td class="px-4 py-3 text-center">{{ $lesson->students_count }}</td>
                                    <td class="px-4 py-3 text-center">{{ $lesson->videos_count }}</td>
                                    <td class="px-4 py-3 text-center">{{ $lesson->activity_lessons_count }}</td>
                                    <td class="px-4 py-3 text-center">{{ $lesson->quizzes_count }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex justify-center items-center">
                                            <div
                                                class="gap-2 bg-[#D2FBD0] px-2 py-1 rounded-full flex items-center w-fit">
                                                <small class="text-[#0D5F07]">Active</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex justify-center items-center gap-1 text-white">
                                            <button
                                                class="bg-danger px-2 py-1 flex gap-2 items-center rounded-lg cursor-pointer hover:scale-110">
                                                <small>Edit</small>
                                            </button>
                                            <button
                                                class="bg-blue-button px-2 py-1 flex gap-2 items-center rounded-lg cursor-pointer hover:scale-110">
                                                <small>View</small>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="px-4 py-6 text-center text-gray-500">
                                        No lessons found.
                                    </td>
                                </tr>
                            @endforelse
                    </table>
                </div>
            </div>

            @if ($lessons->lastPage() > 1)
                <div class="rounded-full border border-[#E8E8E8] p-2 w-fit flex items-center text-sm">
                    <button class="py-1 px-3 {{ $lessons->onFirstPage() ? 'hidden' : '' }}"
                        @if (!$lessons->onFirstPage()) wire:click="gotoPage({{ $lessons->currentPage() - 1 }})" @endif>
                        <span class="material-symbols-outlined">chevron_backward</span>
                    </button>

                    @foreach ($lessons->getUrlRange(1, $lessons->lastPage()) as $page => $url)
                        @if ($page == $lessons->currentPage())
                            <button class="bg-[#7A7A7A1F] py-1 px-4 rounded-full">{{ $page }}</button>
                        @else
                            <button wire:click="gotoPage({{ $page }})"
                                class="py-1 px-4">{{ $page }}</button>
                        @endif
                    @endforeach

                    <button class="py-1 px-3 {{ $lessons->hasMorePages() ? '' : 'hidden' }}"
                        @if ($lessons->hasMorePages()) wire:click="gotoPage({{ $lessons->currentPage() + 1 }})" @endif>
                        <span class="material-symbols-outlined">chevron_forward</span>
                    </button>
                </div>
            @endif
        </div>
    </div>

    <livewire:lesson-add-modal />
</main>
