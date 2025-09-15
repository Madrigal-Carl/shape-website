<main class="col-span-5 pl-8 pr-7 py-4 flex flex-col h-dvh gap-4 overflow-y-none">
    <!-- Greetings -->
    <div class="flex mt-4 gap-2 w-auto justify-between">
        <div class="flex gap-4">
            <span class="w-2 h-full bg-blue-button rounded-full"></span>
            <div class="flex flex-col gap-1">
                <h1 class="text-2xl font-semibold leading-tight">
                    Welcome back, {{ auth()->user()->accountable->sex == 'male' ? 'Sir' : 'Ma\'am' }}
                    <span class="font-bold text-blue-button">
                        {{ auth()->user()->accountable->first_name }}</span>
                </h1>
                <p class="text-lg text-paragraph leading-4">Here is your summary today</p>
            </div>
        </div>

        <!-- Buttons -->
        <button wire:click="openAddCurriculumModal"
            class="relative flex items-center self-start justify-center bg-white py-3 px-5 rounded-full gap-2 shadow-2xl/15 text-paragraph cursor-pointer border-2 border-white hover:border-blue-button hover:text-white hover:bg-blue-button hover:shadow-xl/35 hover:shadow-blue-button hover:scale-105"
            wire:loading.attr="disabled" wire:target="openAddCurriculumModal">

            <!-- Normal state -->
            <div class="flex items-center gap-2" wire:loading.class="invisible" wire:target="openAddCurriculumModal">
                <span class="material-symbols-rounded">add</span>
                <p class="">Add Curriculum</p>
            </div>

            <!-- Loading spinner -->
            <div wire:loading wire:target="openAddCurriculumModal" role="status"
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
    <div class="mt-12 flex flex-col gap-4 min-h-[20%]">
        <div class="side flex items-center justify-between gap-2 mb-2">
            <h1 class="text-4xl font-bold">Curriculum List</h1>
            <livewire:curriculum-add-modal />
            <livewire:curriculum-edit-modal />
            <livewire:curriculum-view-modal />
            <div class="flex items-center gap-4">
                <div
                    class="flex items-center h-fit bg-white py-3 px-5 rounded-full shadow-2xl/15 text-paragraph border-2 border-white hover:border-blue-button hover:bg-blue-button hover:text-white cursor-pointer">
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
                    class="flex gap-2 items-center self-start h-fit bg-white py-3 px-5 rounded-full shadow-2xl/15 text-paragraph border-2 border-white hover:border-blue-button cursor-pointer">
                    <span class="material-symbols-rounded">search</span>
                    <input type="text" class="outline-none w-20 focus:w-60 placeholder-paragraph"
                        wire:model.live="search" placeholder="Search">
                </div>
            </div>

        </div>

        <div class="flex flex-col items-center min-h-[20%] p-6 bg-white rounded-3xl w-full shadow-2xl/5">
            <div class="flex flex-col overflow-y-scroll w-full">
                <div class="flex flex-col bg-whitel rounded-3xl bg-white">
                    <table class="table-auto border-collapse border-0">
                        <thead class="sticky top-0 left-0 z-40 bg-white">
                            <tr>
                                <th class="px-4 pb-3 text-center font-semibold">ID</th>
                                <th class="px-4 pb-3 text-center font-semibold">
                                    Curriculum Name
                                </th>
                                <th class="px-4 pb-3 text-center font-semibold">
                                    Grade Level
                                </th>
                                <th class="px-4 pb-3 text-center font-semibold">
                                    No. of Subjects
                                </th>
                                <th class="px-4 pb-3 text-center font-semibold">Status</th>
                                <th class="px-4 pb-3 text-center font-semibold">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($curriculums as $curriculum)
                                <tr>
                                    <!-- Your original cells -->
                                    <td class="px-4 py-3 text-center text-paragraph">{{ $curriculum->id }}</td>
                                    <td class="px-4 py-3 text-center text-paragraph flex flex-col items-center">
                                        <p class="w-40   truncate">{{ ucwords($curriculum->name) }}</p>
                                    </td>
                                    <td class="px-4 py-3 text-center text-paragraph">
                                        {{ ucwords($curriculum->grade_level) }}</td>
                                    <td class="px-4 py-3 text-center text-paragraph">
                                        {{ count($curriculum->curriculumSubjects) }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex justify-center items-center">
                                            <div>
                                                <input type="checkbox" id="checkboxInput-{{ $curriculum->id }}"
                                                    class="toggleInput" wire:click="toggleStatus({{ $curriculum->id }})"
                                                    {{ $curriculum->status === 'active' ? 'checked' : '' }}>
                                                <label for="checkboxInput-{{ $curriculum->id }}"
                                                    class="toggleSwitch"></label>
                                            </div>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex justify-center items-center gap-1 text-white">
                                            <button wire:click='openEditCurriculumModal({{ $curriculum->id }})'
                                                class="px-2 py-1 flex gap-2 items-center rounded-lg min-w-[50px] justify-center relative
                                                {{ $curriculum->status === 'active' ? 'bg-gray-400 cursor-not-allowed opacity-70' : 'bg-danger cursor-pointer hover:scale-110' }}"
                                                {{ $curriculum->status === 'active' ? 'disabled' : '' }}>

                                                <!-- Text (hidden when loading) -->
                                                <small class="transition-opacity duration-150"
                                                    wire:loading.class="opacity-0"
                                                    wire:target='openEditCurriculumModal({{ $curriculum->id }})'>
                                                    Edit
                                                </small>

                                                <!-- Spinner (overlay) -->
                                                <svg wire:loading
                                                    wire:target='openEditCurriculumModal({{ $curriculum->id }})'
                                                    aria-hidden="true" class="w-4 h-4 text-white animate-spin absolute"
                                                    viewBox="0 0 100 101" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                                        fill="currentColor" />
                                                    <path
                                                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                                        fill="currentFill" />
                                                </svg>
                                            </button>
                                            <button wire:click='openViewCurriculumModal({{ $curriculum->id }})'
                                                class="bg-blue-button px-2 py-1 flex gap-2 items-center rounded-lg cursor-pointer hover:scale-110 min-w-[50px] justify-center relative">

                                                <!-- Text (hidden when loading) -->
                                                <small class="transition-opacity duration-150"
                                                    wire:loading.class="opacity-0"
                                                    wire:target='openViewCurriculumModal({{ $curriculum->id }})'>
                                                    View
                                                </small>

                                                <!-- Spinner (overlay) -->
                                                <svg wire:loading
                                                    wire:target='openViewCurriculumModal({{ $curriculum->id }})'
                                                    class="w-4 h-4 text-white animate-spin absolute"
                                                    viewBox="0 0 100 101" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                                        fill="currentColor" />
                                                    <path
                                                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                                        fill="currentFill" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-6 text-gray-500">
                                        No curriculums found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if ($curriculums->lastPage() > 1)
            <div class="rounded-full bg-white gap-1 p-2 w-fit self-center-safe flex items-center text-sm shadow-2xl">
                <button
                    class="cursor-pointer py-1 flex items-center px-3 {{ $curriculums->onFirstPage() ? 'hidden' : '' }}"
                    @if (!$curriculums->onFirstPage()) wire:click="gotoPage({{ $curriculums->currentPage() - 1 }})" @endif>
                    <span class="material-symbols-outlined">
                        chevron_left
                    </span>
                </button>

                @foreach ($curriculums->getUrlRange(1, $curriculums->lastPage()) as $page => $url)
                    @if ($page == $curriculums->currentPage())
                        <button
                            class=" bg-blue-button text-white py-1 px-4 rounded-full cursor-pointer">{{ $page }}</button>
                    @else
                        <button wire:click="gotoPage({{ $page }})"
                            class="py-1 px-4 hover:bg-blue-button rounded-full hover:text-white cursor-pointer">{{ $page }}</button>
                    @endif
                @endforeach

                <button
                    class="cursor-pointer py-1 flex items-center px-3 {{ $curriculums->hasMorePages() ? '' : 'hidden' }}"
                    @if ($curriculums->hasMorePages()) wire:click="gotoPage({{ $curriculums->currentPage() + 1 }})" @endif>
                    <span class="material-symbols-outlined">
                        chevron_right
                    </span>
                </button>
            </div>
        @endif
    </div>

</main>
